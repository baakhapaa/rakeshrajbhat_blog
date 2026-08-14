<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rakesh Rajbhat · Portfolio')</title>
    <meta name="description" content="@yield('meta_description', 'Official website of Rakesh Rajbhat - Founder, Builder, Future Maker')">
    <meta name="keywords" content="Rakesh Rajbhat, Nepal, Portfolio, Founder, Entrepreneur">
    
    <!-- ... existing code ... -->
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/y9ugybybhrqzufui3bsajx1i1m88rtsggtejv2nc3xg17td8/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @stack('styles')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#101417] text-[#0f1419] antialiased font-sans">

    @include('partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')
    
       <!-- Back to Top Button - Visible on all pages -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            id="backToTopBtn"
            class="go-top-btn" 
            title="Back to top"
            aria-label="Back to top">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
    
    @stack('scripts')
</body>
</html>