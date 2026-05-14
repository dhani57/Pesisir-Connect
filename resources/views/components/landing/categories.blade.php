{{-- Categories Section — Landing Page --}}
@props(['categories'])

<section class="py-16 md:py-24 bg-sand-50" id="kategori">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center mb-10 md:mb-14">
            <span class="badge-ocean mb-3 inline-flex">Kategori Wisata</span>
            <h2 class="section-title">Pilih Petualanganmu</h2>
            <p class="section-subtitle mx-auto">Temukan berbagai layanan wisata pesisir yang sesuai dengan kebutuhanmu</p>
        </div>

        {{-- Categories Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            @foreach($categories as $category)
                <x-category-card :category="$category" />
            @endforeach
        </div>
    </div>
</section>
