<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $siteSettings = \App\Models\Setting::getSiteSettings();
        $siteName = $siteSettings['site_name'];
        $siteUrl = rtrim(config('app.url'), '/');
        $canonicalUrl = $siteUrl . '/' . ltrim(request()->path() === '/' ? '' : request()->path(), '/');
        $pageTitle = trim($__env->yieldContent('title', 'Rakesh Rajbhat | Technology Entrepreneur & Youth Development Builder'));
        $pageDescription = trim($__env->yieldContent('meta_description', 'Official website of Rakesh Rajbhat, founder of Baakhapaa and builder of Skill Sikka, Hillychilly, Future Builders and AI & ICT programs in Nepal.'));
        $shareImage = trim($__env->yieldContent('share_image', asset('images/rakeshrajbhat.jpg')));
        $robots = trim($__env->yieldContent('robots', 'index,follow'));
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="theme-color" content="#0b0e12">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="icon" href="{{ $siteSettings['site_favicon'] ?: asset('favicon.ico') }}" sizes="any">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:alt" content="@yield('share_image_alt', 'Rakesh Rajbhat')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $shareImage }}">
    <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'Person', 'name' => 'Rakesh Rajbhat', 'url' => $siteUrl . '/', 'jobTitle' => 'Technology Entrepreneur and Youth Development Builder', 'description' => 'Nepali technology entrepreneur, civil engineer and youth-development builder.', 'image' => asset('images/rakeshrajbhat.jpg')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    @stack('structured_data')
    @stack('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#101417] text-[#0f1419] antialiased font-sans">
    @include('partials.header')
    <main>@yield('content')</main>
    @include('partials.footer')
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="backToTopBtn" class="go-top-btn" title="Back to top" aria-label="Back to top"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg></button>
    @stack('scripts')
</body>
</html>
