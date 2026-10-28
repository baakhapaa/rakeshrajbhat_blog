@extends('layouts.app')

@section('title', $legal['title'].' | Rakesh Rajbhat')
@section('meta_description', $legal['meta_description'])

@section('content')
<section class="min-h-screen bg-[#f8f6f0] pt-32 pb-20 text-[#1e1e1a]">
    <article class="max-w-3xl mx-auto px-5 sm:px-6 lg:px-8">
        <p class="text-[#735A12] font-bold text-xs tracking-widest uppercase mb-3">Legal</p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">{{ $legal['title'] }}</h1>
        @if($updatedLabel)
            <p class="text-sm text-[#4a4a42] mb-10">Last updated: {{ $updatedLabel }}</p>
        @endif

        <div class="legal-body text-[#3a3a34] leading-7">
            {!! $legal['body'] !!}
        </div>
    </article>
</section>
@endsection

<style>
.legal-body > * + * {
    margin-top: 1.25rem;
}
.legal-body h2,
.legal-body h3 {
    font-family: "Playfair Display", serif;
    color: #1e1e1a;
    font-weight: 700;
    line-height: 1.25;
    margin-top: 2rem;
}
.legal-body h2 { font-size: 1.5rem; }
.legal-body h3 { font-size: 1.25rem; }
.legal-body a {
    color: #735A12;
    text-decoration: underline;
}
.legal-body ul,
.legal-body ol {
    padding-left: 1.25rem;
}
.legal-body ul { list-style: disc; }
.legal-body ol { list-style: decimal; }
.legal-body blockquote {
    border-left: 3px solid #D4AF37;
    padding-left: 1rem;
    color: #4a4a42;
}
.legal-body strong,
.legal-body b { font-weight: 700; color: #1e1e1a; }
</style>
