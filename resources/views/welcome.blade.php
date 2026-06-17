<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="PesisirConnect — Marketplace wisata pesisir Lampung. Sewa perahu, alat snorkeling, dan temukan homestay terbaik di Pahawang, Krui, dan Teluk Kiluan.">
    <meta name="keywords" content="wisata lampung, pahawang, krui, teluk kiluan, sewa perahu, snorkeling, homestay, pesisir lampung">
    <meta name="author" content="PesisirConnect">

    <title>PesisirConnect — Marketplace Wisata Pesisir Lampung</title>

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="PesisirConnect — Marketplace Wisata Pesisir Lampung">
    <meta property="og:description" content="Sewa perahu, alat snorkeling, dan temukan homestay terbaik di Pahawang, Krui, dan Teluk Kiluan. Dukung ekowisata lokal Lampung.">
    <meta property="og:image" content="https://placehold.co/1200x630/0ea5e9/ffffff?text=PesisirConnect+Lampung">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="PesisirConnect — Marketplace Wisata Pesisir Lampung">
    <meta property="twitter:description" content="Sewa perahu, alat snorkeling, dan temukan homestay terbaik di Pahawang, Krui, dan Teluk Kiluan. Dukung ekowisata lokal Lampung.">
    <meta property="twitter:image" content="https://placehold.co/1200x630/0ea5e9/ffffff?text=PesisirConnect+Lampung">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌊</text></svg>">

    {{-- Google Fonts — Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    {{-- Alpine.js cloak --}}
    <style>[x-cloak] { display: none !important; }</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    {{-- Navbar --}}
    <x-navbar />

    {{-- Hero Section --}}
    <x-landing.hero :locations="$locations" />

    {{-- Categories Section --}}
    <x-landing.categories :categories="$categories" />

    {{-- Featured Products --}}
    <x-landing.featured-products :products="$featuredProducts" />

    {{-- Why Choose Us --}}
    <x-landing.why-us />

    {{-- CTA Section --}}
    <x-landing.cta />

    {{-- Footer --}}
    <x-footer />

</body>
</html>
