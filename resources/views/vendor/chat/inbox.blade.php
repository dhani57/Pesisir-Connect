<x-vendor-layout :title="'Pesan Pelanggan'">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Kotak Masuk</h2>
            <span class="text-sm text-gray-500">{{ $conversations->total() }} Percakapan</span>
        </div>

        @if($conversations->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($conversations as $conv)
                    <a href="{{ route('vendor.chat.show', $conv) }}" class="flex items-start gap-4 p-4 sm:p-6 hover:bg-gray-50 transition-colors {{ $conv->unread_count > 0 ? 'bg-ocean-50/20' : '' }}">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                            <img src="{{ $conv->customer->avatar_url ?? 'https://ui-avatars.com/api/?name=User&background=f3f4f6' }}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-sm font-bold truncate {{ $conv->unread_count > 0 ? 'text-gray-900' : 'text-gray-700' }}">
                                    {{ $conv->customer->name ?? 'Pelanggan' }}
                                </h3>
                                <span class="text-xs text-gray-400 shrink-0 ml-2">
                                    {{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '' }}
                                </span>
                            </div>
                            
                            <p class="text-sm truncate {{ $conv->unread_count > 0 ? 'font-semibold text-gray-900' : 'text-gray-500' }}">
                                @if($conv->latestMessage)
                                    @if($conv->latestMessage->sender_type === 'vendor')
                                        <span class="text-gray-400">Anda:</span> 
                                    @endif
                                    {{ $conv->latestMessage->body }}
                                @else
                                    <span class="italic text-gray-400">Belum ada pesan</span>
                                @endif
                            </p>
                            
                            @if($conv->product)
                                <div class="mt-2 inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    {{ $conv->product->name }}
                                </div>
                            @endif
                        </div>
                        
                        @if($conv->unread_count > 0)
                            <div class="w-5 h-5 rounded-full bg-ocean-600 text-white text-[10px] font-bold flex items-center justify-center shrink-0 shadow-sm shadow-ocean-600/30">
                                {{ $conv->unread_count }}
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
            
            @if($conversations->hasPages())
                <div class="p-4 sm:p-6 border-t border-gray-100">
                    {{ $conversations->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="text-gray-900 font-bold mb-1">Tidak ada pesan masuk</h3>
                <p class="text-gray-500 text-sm">Pesan dari pelanggan akan muncul di sini.</p>
            </div>
        @endif
    </div>
</x-vendor-layout>
