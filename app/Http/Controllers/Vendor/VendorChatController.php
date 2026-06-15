<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * VendorChatController
 *
 * Handles vendor-side chat/messaging:
 * - Inbox view with all customer conversations
 * - Conversation detail view
 * - Message sending (AJAX + form fallback)
 * - AJAX polling for real-time message updates
 */
class VendorChatController extends Controller
{
    /**
     * Display the vendor's chat inbox.
     */
    public function inbox(): View
    {
        $vendor = auth()->user()->vendor;

        $conversations = Conversation::forVendor($vendor->id)
            ->with(['customer', 'product', 'latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($vendor) {
                $q->where('sender_id', '!=', $vendor->user_id)->whereNull('read_at');
            }])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('vendor.chat.inbox', compact('conversations'));
    }

    /**
     * Show a specific conversation.
     */
    public function show(Conversation $conversation): View
    {
        $vendor = auth()->user()->vendor;

        // Authorization: only the vendor in this conversation can view it
        if ($conversation->vendor_id !== $vendor->id) {
            abort(403);
        }

        // Mark messages as read
        $conversation->markAsReadFor($vendor->user_id);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $conversation->load(['customer', 'product', 'vendor']);

        return view('vendor.chat.show', compact('conversation', 'messages'));
    }

    /**
     * Send a message in an existing conversation.
     */
    public function sendMessage(Request $request, Conversation $conversation): JsonResponse
    {
        $vendor = auth()->user()->vendor;

        if ($conversation->vendor_id !== $vendor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $vendor->user_id,
            'sender_type'     => 'vendor',
            'body'            => $request->body,
        ]);

        $conversation->update(['last_message_at' => now()]);

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

    /**
     * Poll for new messages in a conversation (AJAX).
     */
    public function pollMessages(Request $request, Conversation $conversation): JsonResponse
    {
        $vendor = auth()->user()->vendor;

        if ($conversation->vendor_id !== $vendor->id) {
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
                'is_mine'        => $msg->sender_id === $vendor->user_id,
            ]);

        // Mark received messages as read
        $conversation->markAsReadFor($vendor->user_id);

        return response()->json([
            'messages'     => $newMessages,
            'unread_count' => 0,
        ]);
    }
}
