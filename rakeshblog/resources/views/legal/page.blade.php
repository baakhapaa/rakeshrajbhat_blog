@extends('layouts.app')

@section('title', $legal['title'].' | Rakesh Rajbhat')
@section('meta_description', $legal['meta_description'])

@section('content')
<section class="site-theme min-h-screen pt-32 pb-20 text-[#1b1c1a]">
    <article class="max-w-3xl mx-auto px-5 sm:px-6 lg:px-8">
        <div class="site-kicker">
            <span aria-hidden="true"></span>
            <p>Legal</p>
        </div>
        <h1 class="text-4xl md:text-5xl font-semibold mb-4">{{ $legal['title'] }}</h1>
        @if($updatedLabel)
            <p class="text-sm text-[#4a4a42] mb-10">Last updated: {{ $updatedLabel }}</p>
        @endif

        <div class="legal-body text-[#3a3a34] leading-7">
            {!! $legal['body'] !!}
        </div>
    </article>
</section>
@endsection
