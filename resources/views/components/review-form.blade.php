{{-- Review Form Component --}}
@props(['transaction', 'product'])

<div class="bg-gradient-to-br from-ocean-50 to-white p-6 md:p-8 rounded-2xl border border-ocean-100 shadow-sm" x-data="reviewForm()">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-full bg-ocean-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-ocean-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-gray-900">Bagikan Pengalaman Anda</h3>
            <p class="text-sm text-gray-500">Ulasan Anda membantu wisatawan lain membuat keputusan.</p>
        </div>
    </div>

    <form action="{{ route('customer.review.store', $transaction) }}" method="POST" class="space-y-5">
        @csrf

        {{-- Interactive Star Rating --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Rating Anda</label>
            <input type="hidden" name="rating" :value="rating">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button"
                            @click="rating = {{ $i }}"
                            @mouseenter="hoverRating = {{ $i }}"
                            @mouseleave="hoverRating = 0"
                            class="p-0.5 transition-transform duration-150 focus:outline-none"
                            :class="({{ $i }} <= (hoverRating || rating)) ? 'scale-110' : 'scale-100 hover:scale-105'">
                        <svg class="w-8 h-8 transition-colors duration-150"
                             :class="({{ $i }} <= (hoverRating || rating)) ? 'text-amber-400 drop-shadow-sm' : 'text-gray-200 hover:text-amber-200'"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </button>
                    @endfor
                </div>
                <span class="text-sm font-medium ml-2 transition-colors duration-150"
                      :class="{
                          'text-gray-400': !rating,
                          'text-red-500': rating === 1,
                          'text-orange-500': rating === 2,
                          'text-amber-500': rating === 3,
                          'text-lime-600': rating === 4,
                          'text-emerald-600': rating === 5,
                      }"
                      x-text="ratingLabels[rating] || 'Pilih rating'"></span>
            </div>
        </div>

        {{-- Review Text --}}
        <div>
            <label for="review_text_{{ $transaction->id }}" class="block text-sm font-semibold text-gray-700 mb-2">Ceritakan Pengalaman Anda</label>
            <textarea id="review_text_{{ $transaction->id }}"
                      name="review_text"
                      rows="4"
                      maxlength="1000"
                      x-model="reviewText"
                      placeholder="Apa yang paling Anda sukai? Bagaimana pelayanannya? Tips untuk wisatawan lain?"
                      class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-500 focus:ring-ocean-500 resize-none bg-white placeholder:text-gray-400"></textarea>
            <div class="flex items-center justify-between mt-1.5">
                <p class="text-xs text-gray-400">Opsional, tapi sangat membantu wisatawan lain</p>
                <span class="text-xs transition-colors duration-200"
                      :class="reviewText.length > 900 ? 'text-amber-500' : 'text-gray-400'"
                      x-text="reviewText.length + '/1000'"></span>
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit"
                :disabled="!rating"
                class="inline-flex items-center gap-2 px-6 py-3 bg-ocean-600 hover:bg-ocean-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-sm font-bold rounded-xl transition-all duration-200 active:scale-[0.98] shadow-md shadow-ocean-600/20 disabled:shadow-none">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            Kirim Ulasan
        </button>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('reviewForm', () => ({
            rating: 0,
            hoverRating: 0,
            reviewText: '',
            ratingLabels: {
                1: 'Sangat Buruk',
                2: 'Buruk',
                3: 'Cukup',
                4: 'Bagus',
                5: 'Sangat Bagus!',
            },
        }));
    });
</script>
