<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            {{ __('Pesan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Kotak Masuk</h3>
                    </div>

                    @if($conversations->count() > 0)
                        <div class="space-y-3">
                            @foreach($conversations as $conv)
                                <a href="{{ route('chat.show', $conv) }}" class="block border border-gray-100 rounded-xl p-4 hover:bg-ocean-50/50 hover:border-ocean-100 transition-all {{ $conv->unread_count > 0 ? 'bg-ocean-50/30' : '' }}">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 shrink-0">
                                            <img src="{{ $conv->vendor->avatar_url ?? '' }}" alt="" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-baseline mb-1">
                                                <h4 class="text-sm font-bold text-gray-900 truncate pr-4 {{ $conv->unread_count > 0 ? 'text-ocean-900' : '' }}">
                                                    {{ $conv->vendor->shop_name ?? 'Vendor' }}
                                                </h4>
                                                <span class="text-xs text-gray-400 shrink-0">
                                                    {{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '' }}
                                                </span>
                                            </div>
                                            <p class="text-sm truncate {{ $conv->unread_count > 0 ? 'font-semibold text-gray-800' : 'text-gray-500' }}">
                                                @if($conv->latestMessage)
                                                    @if($conv->latestMessage->sender_id === auth()->id())
                                                        <span class="text-gray-400">Anda:</span> 
                                                    @endif
                                                    {{ $conv->latestMessage->body }}
                                                @else
                                                    <span class="italic">Belum ada pesan</span>
                                                @endif
                                            </p>
                                        </div>
                                        @if($conv->unread_count > 0)
                                            <div class="w-5 h-5 rounded-full bg-coral-500 text-white text-[10px] font-bold flex items-center justify-center shrink-0">
                                                {{ $conv->unread_count }}
                                            </div>
                                        @endif
                                    </div>
                                    @if($conv->product)
                                        <div class="mt-3 pl-16">
                                            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-gray-50 text-xs text-gray-500 border border-gray-100">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                Terkait: <span class="font-medium text-gray-700">{{ $conv->product->name }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $conversations->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada pesan</h3>
                            <p class="text-gray-500 text-sm">Pesan yang Anda kirim ke vendor akan muncul di sini.</p>
                            <a href="{{ route('catalog') }}" class="inline-block mt-4 text-sm font-semibold text-ocean-600 hover:text-ocean-700">Mulai Eksplorasi &rarr;</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
