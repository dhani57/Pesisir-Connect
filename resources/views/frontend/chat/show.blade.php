<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('chat.inbox') }}" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div class="flex items-center gap-3">
                <img src="{{ $conversation->vendor->avatar_url }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                <div>
                    <h2 class="font-bold text-lg text-gray-900 leading-tight">{{ $conversation->vendor->shop_name }}</h2>
                    <p class="text-xs text-ocean-600 font-medium">Vendor</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto md:py-8 sm:px-6 lg:px-8 h-[calc(100vh-140px)] md:h-[calc(100vh-200px)] flex flex-col">
        <div class="bg-white flex-1 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 flex flex-col"
             x-data="chatBox({{ $conversation->id }}, {{ $messages->last()?->id ?? 0 }})">
            
            @if($conversation->product)
            {{-- Product Context Banner --}}
            <div class="bg-ocean-50 border-b border-ocean-100 p-3 px-4 sm:px-6 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <img src="{{ $conversation->product->thumbnail_url }}" class="w-10 h-10 rounded object-cover shrink-0">
                    <div class="truncate">
                        <p class="text-xs text-gray-500 font-medium">Terkait layanan:</p>
                        <a href="{{ route('produk.detail', $conversation->product->slug) }}" class="text-sm font-bold text-ocean-700 hover:underline truncate block">
                            {{ $conversation->product->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Messages Area --}}
            <div id="messages-container" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6 bg-gray-50/30">
                @foreach($messages as $msg)
                    @if($msg->sender_id === auth()->id())
                        {{-- Sent --}}
                        <div class="flex justify-end gap-3 max-w-[85%] ml-auto">
                            <div class="bg-ocean-600 text-white rounded-2xl rounded-tr-sm px-4 py-2.5 shadow-sm">
                                <p class="text-sm whitespace-pre-wrap">{{ $msg->body }}</p>
                                <span class="text-[10px] text-ocean-200 mt-1 block text-right">{{ $msg->formatted_time }}</span>
                            </div>
                        </div>
                    @else
                        {{-- Received --}}
                        <div class="flex justify-start gap-3 max-w-[85%]">
                            <img src="{{ $conversation->vendor->avatar_url }}" class="w-8 h-8 rounded-full shrink-0 object-cover mt-1">
                            <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm">
                                <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $msg->body }}</p>
                                <span class="text-[10px] text-gray-400 mt-1 block">{{ $msg->formatted_time }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
                
                {{-- Dynamic content from Alpine --}}
                <template x-for="msg in newMessages" :key="msg.id">
                    <div :class="msg.is_mine ? 'flex justify-end gap-3 max-w-[85%] ml-auto' : 'flex justify-start gap-3 max-w-[85%]'">
                        <template x-if="!msg.is_mine">
                            <img src="{{ $conversation->vendor->avatar_url }}" class="w-8 h-8 rounded-full shrink-0 object-cover mt-1">
                        </template>
                        <div :class="msg.is_mine ? 'bg-ocean-600 text-white rounded-2xl rounded-tr-sm px-4 py-2.5 shadow-sm' : 'bg-white border border-gray-100 rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm'">
                            <p class="text-sm whitespace-pre-wrap" :class="msg.is_mine ? '' : 'text-gray-800'" x-text="msg.body"></p>
                            <span class="text-[10px] mt-1 block" :class="msg.is_mine ? 'text-ocean-200 text-right' : 'text-gray-400'" x-text="msg.created_at"></span>
                        </div>
                    </div>
                </template>
                <div x-ref="bottom" class="h-1"></div>
            </div>

            {{-- Input Area --}}
            <div class="p-3 sm:p-4 bg-white border-t border-gray-100 shrink-0">
                <form @submit.prevent="sendMessage" class="flex gap-2 relative">
                    <textarea x-model="newMessage" @keydown.enter.prevent="if(!event.shiftKey) sendMessage()" rows="1" placeholder="Ketik pesan Anda di sini..." class="w-full rounded-2xl border-gray-200 pr-12 focus:border-ocean-500 focus:ring-ocean-500 text-sm resize-none pt-3 pb-3" style="min-height: 44px; max-height: 120px; overflow-y: hidden;" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                    
                    <button type="submit" :disabled="isSending || !newMessage.trim()" class="absolute right-2 bottom-1.5 w-8 h-8 flex items-center justify-center rounded-full bg-ocean-600 text-white hover:bg-ocean-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <svg x-show="!isSending" class="w-4 h-4 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <svg x-show="isSending" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </form>
            </div>
            
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chatBox', (conversationId, initialLastId) => ({
                conversationId: conversationId,
                lastId: initialLastId,
                newMessage: '',
                newMessages: [],
                isSending: false,
                pollingInterval: null,

                init() {
                    this.scrollToBottom();
                    this.startPolling();
                    // Scroll down when new messages are added
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
                            const res = await fetch(`/pesan/${this.conversationId}/poll?last_id=${this.lastId}`);
                            if (res.ok) {
                                const data = await res.json();
                                if (data.messages && data.messages.length > 0) {
                                    const existingIds = new Set(this.newMessages.map(m => m.id));
                                    const filtered = data.messages.filter(m => !existingIds.has(m.id));
                                    if (filtered.length > 0) {
                                        this.newMessages = [...this.newMessages, ...filtered];
                                        const maxId = Math.max(...filtered.map(m => m.id));
                                        if (maxId > this.lastId) {
                                            this.lastId = maxId;
                                        }
                                    }
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
                    this.newMessage = ''; // clear immediately for better UX
                    
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const res = await fetch(`/pesan/${this.conversationId}/kirim`, {
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
                            this.newMessage = body; // restore if failed
                        }
                    } catch (e) {
                        console.error('Send error', e);
                        this.newMessage = body; // restore if failed
                    } finally {
                        this.isSending = false;
                    }
                }
            }));
        });
    </script>
</x-app-layout>
