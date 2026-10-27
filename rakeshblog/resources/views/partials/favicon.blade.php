@php
    $siteFavicon = \App\Models\Setting::getValue('site_favicon') ?: asset('favicon.png');
@endphp
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
<link rel="icon" href="{{ $siteFavicon }}">
<link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
