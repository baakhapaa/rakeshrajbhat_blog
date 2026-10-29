@extends('layouts.app')

@section('title', 'News & Updates · Rakesh Rajbhat')

@section('meta_description', $newsContent['intro'])

@section('content')
<section class="news-page text-[#1b1c1a]">
    <div class="news-page-inner">
        <div class="mb-16 max-w-xl">
            <div class="flex items-center gap-2">
                <span class="block h-0.5 w-6 shrink-0 bg-[#89351d]" aria-hidden="true"></span>
                <p class="font-grotesk text-sm font-bold uppercase leading-4 tracking-[1.1px] text-[#89351d]">{{ $newsContent['label'] }}</p>
            </div>
            <h1 class="pt-1 font-jakarta text-[2rem] font-bold leading-tight tracking-[-0.6px] text-[#1b1c1a] sm:text-[40px] sm:leading-[48px] sm:tracking-[-1px]">{{ $newsContent['heading'] }}</h1>
            <p class="max-w-xl pt-2 font-jakarta text-base leading-6 text-[#5f5e5e]">{{ $newsContent['intro'] }}</p>
        </div>

        @if($newsItems->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($newsItems as $item)
                    @include('partials.news-card', ['item' => $item])
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 rounded-full bg-white/80 flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <i class="fas fa-newspaper text-4xl text-[#D4AF37]/30"></i>
                </div>
                <p class="text-lg font-medium text-[#1e1e1a]">No news yet</p>
                <p class="text-sm text-[#8a8a82] mt-1">Stories will appear here as they are added.</p>
            </div>
        @endif

        <div class="news-back">
            <a href="{{ route('home') }}#news">
                <i class="fas fa-arrow-left text-xs"></i>
                Back to Home
            </a>
        </div>
    </div>
</section>
<style>
    header ~ main > .news-page { margin-top: 0; }
    .news-page {
        background: #fbf9f6;
        padding: calc(var(--site-header-height, 88px) + clamp(32px, 2.4vw, 56px)) clamp(20px, 3vw, 40px) clamp(72px, 6vw, 112px);
    }
    .news-page-inner {
        width: min(1280px, 100%);
        margin: 0 auto;
    }
    @media (min-width: 1600px) {
        .news-page {
            padding-top: calc(var(--site-header-height, 120px) + clamp(48px, 3vw, 88px));
            padding-left: clamp(32px, 4vw, 80px);
            padding-right: clamp(32px, 4vw, 80px);
        }
        .news-page-inner { width: min(1440px, 100%); }
    }
    @media (min-width: 2200px) {
        .news-page {
            padding-top: calc(var(--site-header-height, 140px) + 96px);
        }
        .news-page-inner { width: min(1600px, calc(100% - 160px)); }
    }
    .news-back { margin-top: 64px; text-align: center; }
    .news-back a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #89351d;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-weight: 600;
        text-decoration: none;
    }
    .news-back a:hover { color: #b36855; }
</style>

@include('partials.news-modal')
@endsection
