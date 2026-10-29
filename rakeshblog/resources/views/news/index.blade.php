@extends('layouts.app')

@section('title', 'News & Updates · Rakesh Rajbhat')

@section('meta_description', $newsContent['intro'])

@section('content')
<section class="news-index text-[#1b1c1a]">
    <div class="news-index-wrap">
        <div class="news-index-head">
            <div class="site-kicker">
                <span aria-hidden="true"></span>
                <p>{{ $newsContent['label'] }}</p>
            </div>
            <h1 class="news-index-title">{{ $newsContent['heading'] }}</h1>
            <p class="news-index-lead">{{ $newsContent['intro'] }}</p>
        </div>

        @if($newsItems->isNotEmpty())
            <div class="news-index-grid">
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

        <div class="news-index-back">
            <a href="{{ route('home') }}#news" class="site-btn site-btn--ghost">
                <i class="fas fa-arrow-left text-xs"></i>
                Back to Home
            </a>
        </div>
    </div>
</section>

@include('partials.news-modal')
@endsection

<style>
.news-index {
    background: #fbf9f6;
    padding: var(--page-top) 0 var(--section-y);
}

.news-index-wrap {
    width: var(--site-width);
    margin: 0 auto;
}

.news-index-head {
    max-width: 44em;
}

.news-index-title {
    margin: 0;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
    font-size: var(--page-title-size);
    font-weight: 700;
    line-height: 1.08;
    letter-spacing: -0.02em;
    color: #1b1c1a;
}

.news-index-lead {
    max-width: 40em;
    margin: clamp(14px, 0.5vw + 10px, 22px) 0 0;
    color: #5f5e5e;
    font-size: clamp(16px, 0.25vw + 14px, 19px);
    line-height: 1.65;
}

.news-index-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: clamp(20px, 1.4vw + 10px, 40px);
    margin-top: var(--heading-gap);
}

@media (min-width: 768px) {
    .news-index-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (min-width: 1024px) {
    .news-index-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}

.news-index-back {
    display: flex;
    justify-content: center;
    margin-top: var(--cta-gap);
}
</style>
