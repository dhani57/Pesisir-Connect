<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * ChatController
 *
 * Shared controller for chat/messaging between customers and vendors.
 * Supports conversation creation, message sending, AJAX polling for
 * new messages, and read receipts.
 */
class ChatController extends Controller
{
    /**
     * Display the customer's chat inbox.
     */
    public function inbox(): View
    {
        $user = auth()->user();

        $conversations = Conversation::forCustomer($user->id)
            ->with(['vendor', 'product', 'latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('frontend.chat.inbox', compact('conversations'));
    }

    /**
     * Show a specific conversation.
     */
    public function show(Conversation $conversation): View
    {
        $user = auth()->user();

        // Authorization: only the customer in this conversation can view it
        if ($conversation->customer_id !== $user->id) {
            abort(403);
        }

        // Mark messages as read
        $conversation->markAsReadFor($user->id);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $conversation->load(['vendor', 'product', 'customer']);

        return view('frontend.chat.show', compact('conversation', 'messages'));
    }

    /**
     * Start or resume a conversation with a vendor (from product detail page).
     */
    public function startConversation(Request $request): RedirectResponse
    {
        $request->validate([
            'vendor_id'  => ['required', 'exists:vendors,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'message'    => ['required', 'string', 'max:1000'],
        ]);

        $user = auth()->user();
        $vendor = Vendor::findOrFail($request->vendor_id);

        // Prevent vendor from chatting with themselves
        if ($user->id === $vendor->user_id) {
            return back()->with('error', 'Anda tidak bisa mengirim pesan ke toko Anda sendiri.');
        }

        // Find or create conversation
        $conversation = Conversation::firstOrCreate(
            [
                'customer_id' => $user->id,
                'vendor_id'   => $vendor->id,
                'product_id'  => $request->product_id,
            ],
            [
                'subject'         => $request->product_id
                    ? 'Pertanyaan tentang ' . Product::find($request->product_id)?->name
                    : 'Pesan ke ' . $vendor->shop_name,
                'last_message_at' => now(),
            ]
        );

        // Create the first message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $user->id,
            'sender_type'     => 'customer',
            'body'            => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('chat.show', $conversation)
            ->with('success', 'Pesan berhasil dikirim!');
    }

    /**
     * Send a message in an existing conversation.
     */
    public function sendMessage(Request $request, Conversation $conversation): JsonResponse|RedirectResponse
    {
        $user = auth()->user();

        // Authorization
        if ($conversation->customer_id !== $user->id) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $user->id,
            'sender_type'     => 'customer',
            'body'            => $request->body,
        ]);

        $conversation->update(['last_message_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'         => $message->id,
                    'body'       => $message->body,
                    'sender_id'  => $message->sender_id,
                    'created_at' => $message->formatted_time,
                    'is_mine'    => true,
                ],
            ]);
        }

        return back();
    }

    /**
     * Poll for new messages in a conversation (AJAX).
     */
    public function pollMessages(Request $request, Conversation $conversation): JsonResponse
    {
        $user = auth()->user();

        if ($conversation->customer_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lastId = $request->query('last_id', 0);

        $newMessages = $conversation->messages()
            ->where('id', '>', $lastId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn ($msg) => [
                'id'             => $msg->id,
                'body'           => e($msg->body),
                'sender_id'      => $msg->sender_id,
                'sender_name'    => $msg->sender->name ?? 'User',
                'sender_type'    => $msg->sender_type,
                'created_at'     => $msg->formatted_time,
                'is_mine'        => $msg->sender_id === $user->id,
            ]);

        // Mark received messages as read
        $conversation->markAsReadFor($user->id);

        return response()->json([
            'messages'     => $newMessages,
            'unread_count' => 0,
        ]);
    }

    /**
     * Get unread message count for customer (for navbar badge).
     */
    public function unreadCount(): JsonResponse
    {
        $user = auth()->user();

        $count = Message::whereNull('read_at')
            ->where('sender_id', '!=', $user->id)
            ->whereHas('conversation', fn ($q) => $q->where('customer_id', $user->id))
            ->count();

        return response()->json(['count' => $count]);
    }
}
