<x-vendor-layout :title="'Chat: ' . ($conversation->customer->name ?? 'Pelanggan')">
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col h-[calc(100vh-140px)]"
         x-data="vendorChatBox({{ $conversation->id }}, {{ $messages->last()?->id ?? 0 }})">
        
        {{-- Header --}}
        <div class="p-4 border-b border-gray-100 flex items-center gap-3 shrink-0">
            <a href="{{ route('vendor.chat.inbox') }}" class="p-2 -ml-2 rounded-lg hover:bg-gray-100 text-gray-500">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <img src="{{ $conversation->customer->avatar_url ?? 'https://ui-avatars.com/api/?name=User' }}" class="w-10 h-10 rounded-full object-cover">
            <div>
                <h2 class="font-bold text-gray-900 leading-tight">
                    <a href="{{ route('customer.profile.show', $conversation->customer_id) }}" target="_blank" class="hover:text-ocean-600 transition-colors">
                        {{ $conversation->customer->name ?? 'Pelanggan' }}
                    </a>
                </h2>
                <p class="text-xs text-gray-500">Pelanggan</p>
            </div>
        </div>

        {{-- Product Context Banner --}}
        @if($conversation->product)
        <div class="bg-gray-50 border-b border-gray-100 p-3 px-4 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ $conversation->product->thumbnail_url }}" class="w-10 h-10 rounded object-cover shrink-0">
                <div class="truncate">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Terkait Produk</p>
                    <a href="{{ route('produk.detail', $conversation->product->slug) }}" target="_blank" class="text-sm font-semibold text-ocean-700 hover:underline truncate block">
                        {{ $conversation->product->name }}
                    </a>
                </div>
            </div>
            <span class="text-sm font-bold text-gray-900 hidden sm:block">{{ $conversation->product->formatted_price }}</span>
        </div>
        @endif

        {{-- Messages Area --}}
        <div id="messages-container" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6">
            @foreach($messages as $msg)
                @if($msg->sender_type === 'vendor')
                    {{-- Sent by Vendor --}}
                    <div class="flex justify-end gap-3 max-w-[85%] ml-auto">
                        <div class="bg-ocean-600 text-white rounded-2xl rounded-tr-sm px-4 py-2.5 shadow-sm">
                            <p class="text-sm whitespace-pre-wrap">{{ $msg->body }}</p>
                            <span class="text-[10px] text-ocean-200 mt-1 block text-right">{{ $msg->formatted_time }}</span>
                        </div>
                    </div>
                @else
                    {{-- Received from Customer --}}
                    <div class="flex justify-start gap-3 max-w-[85%]">
                        <img src="{{ $conversation->customer->avatar_url ?? 'https://ui-avatars.com/api/?name=U' }}" class="w-8 h-8 rounded-full shrink-0 object-cover mt-1">
                        <div class="bg-gray-100 border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm">
                            <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $msg->body }}</p>
                            <span class="text-[10px] text-gray-500 mt-1 block">{{ $msg->formatted_time }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
            
            {{-- Dynamic content from Alpine --}}
            <template x-for="msg in newMessages" :key="msg.id">
                <div :class="msg.is_mine ? 'flex justify-end gap-3 max-w-[85%] ml-auto' : 'flex justify-start gap-3 max-w-[85%]'">
                    <template x-if="!msg.is_mine">
                        <img src="{{ $conversation->customer->avatar_url ?? 'https://ui-avatars.com/api/?name=U' }}" class="w-8 h-8 rounded-full shrink-0 object-cover mt-1">
                    </template>
                    <div :class="msg.is_mine ? 'bg-ocean-600 text-white rounded-2xl rounded-tr-sm px-4 py-2.5 shadow-sm' : 'bg-gray-100 border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm'">
                        <p class="text-sm whitespace-pre-wrap" :class="msg.is_mine ? '' : 'text-gray-800'" x-text="msg.body"></p>
                        <span class="text-[10px] mt-1 block" :class="msg.is_mine ? 'text-ocean-200 text-right' : 'text-gray-500'" x-text="msg.created_at"></span>
                    </div>
                </div>
            </template>
            <div x-ref="bottom" class="h-1"></div>
        </div>

        {{-- Input Area --}}
        <div class="p-3 sm:p-4 bg-gray-50 border-t border-gray-200 shrink-0 rounded-b-2xl">
            <form @submit.prevent="sendMessage" class="flex gap-2 relative">
                <textarea x-model="newMessage" @keydown.enter.prevent="if(!event.shiftKey) sendMessage()" rows="1" placeholder="Ketik balasan Anda..." class="w-full rounded-xl border-gray-300 pr-12 focus:border-ocean-500 focus:ring-ocean-500 text-sm resize-none pt-3 pb-3" style="min-height: 44px; max-height: 120px; overflow-y: hidden;" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                
                <button type="submit" :disabled="isSending || !newMessage.trim()" class="absolute right-2 bottom-1.5 w-8 h-8 flex items-center justify-center rounded-lg bg-ocean-600 text-white hover:bg-ocean-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <svg x-show="!isSending" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <svg x-show="isSending" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </form>
            <p class="text-[10px] text-gray-400 mt-2">Tekan Enter untuk mengirim, Shift+Enter untuk baris baru.</p>
        </div>
        
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('vendorChatBox', (conversationId, initialLastId) => ({
                conversationId: conversationId,
                lastId: initialLastId,
                newMessage: '',
                newMessages: [],
                isSending: false,
                pollingInterval: null,

                init() {
                    this.scrollToBottom();
                    this.startPolling();
                    this.$watch('newMessages', () => {
                        this.$nextTick(() => this.scrollToBottom());
                    });
                },
                
                destroy() {
                    if (this.pollingInterval) clearInterval(this.pollingInterval);
                },

                scrollToBottom() {
                    this.$refs.bottom.scrollIntoView({ behavior: 'smooth' });
                },

                startPolling() {
                    this.pollingInterval = setInterval(async () => {
                        try {
                            const res = await fetch(`/vendor/chat/${this.conversationId}/poll?last_id=${this.lastId}`);
                            if (res.ok) {
                                const data = await res.json();
                                if (data.messages && data.messages.length > 0) {
                                    this.newMessages = [...this.newMessages, ...data.messages];
                                    this.lastId = data.messages[data.messages.length - 1].id;
                                }
                            }
                        } catch (e) {
                            console.error('Polling error', e);
                        }
                    }, 3000);
                },

                async sendMessage() {
                    if (!this.newMessage.trim() || this.isSending) return;
                    
                    this.isSending = true;
                    const body = this.newMessage.trim();
                    this.newMessage = ''; 
                    
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const res = await fetch(`/vendor/chat/${this.conversationId}/send`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ body: body })
                        });
                        
                        if (res.ok) {
                            const data = await res.json();
                            if (data.success) {
                                this.newMessages.push(data.message);
                                this.lastId = data.message.id;
                                this.$refs.bottom.scrollIntoView({ behavior: 'smooth' });
                            }
                        } else {
                            this.newMessage = body; 
                        }
                    } catch (e) {
                        console.error('Send error', e);
                        this.newMessage = body; 
                    } finally {
                        this.isSending = false;
                    }
                }
            }));
        });
    </script>
    @endpush
</x-vendor-layout>
