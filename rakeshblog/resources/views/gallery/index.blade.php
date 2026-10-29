@extends('layouts.app')

@section('title', 'Gallery | Rakesh Rajbhat')
@section('meta_description', 'Photo collections from community visits, projects and moments along the way.')

@section('content')
<section class="gallery-index">
    <div class="gallery-index-wrap">
        <a href="{{ route('home') }}#gallery" class="gallery-index-back">Home</a>
        <div class="gallery-index-marker">
            <span class="gallery-index-dash" aria-hidden="true"></span>
            <p class="gallery-index-kicker">{{ $gallerySection['label'] }}</p>
        </div>
        <h1 class="gallery-index-title">
            @if(in_array($gallerySection['title'], ['My work. The projects & moments between.', 'Moments along the way.', 'Moments along the way'], true))
                My work. The projects<br>& moments between.
            @else
                {{ $gallerySection['title'] }}
            @endif
        </h1>

        @if($collections->isNotEmpty())
            <div class="gallery-index-grid">
                @foreach($collections as $collection)
                    @php
                        $previewImages = $collection->images->take(4);
                        $lead = $previewImages->first();
                        $sideImages = $previewImages->slice(1, 3);
                    @endphp
                    <a href="{{ route('gallery.show', $collection) }}" class="gallery-index-card {{ $sideImages->isEmpty() ? 'is-single' : '' }}" aria-label="View {{ $collection->title }}">
                        <div class="gallery-index-lead">
                            <img src="{{ $lead->url }}" alt="{{ $collection->title }}">
                            <span class="gallery-index-scrim" aria-hidden="true"></span>
                            <span class="gallery-index-count">
                                <img src="{{ asset('images/gallery-count.svg') }}" alt="" width="16" height="16">
                                <span>{{ $collection->images->count() }}</span>
                            </span>
                            <div class="gallery-index-copy">
                                <h2>{{ $collection->title }}</h2>
                            </div>
                        </div>
                        @if($sideImages->isNotEmpty())
                            <div class="gallery-index-side">
                                @foreach($sideImages as $image)
                                    <div class="gallery-index-thumb">
                                        <img src="{{ $image->url }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <p class="gallery-index-empty">{{ $gallerySection['empty'] }}</p>
        @endif
    </div>
</section>
@endsection

<style>
.gallery-index {
    min-height: 100vh;
    background: #fff;
    color: #111;
    padding: 8rem 0 5rem;
}

.gallery-index-wrap {
    width: min(1640px, calc(100% - 2rem));
    margin-inline: auto;
}

.gallery-index-back {
    display: inline-block;
    margin-bottom: 1.75rem;
    color: #89351d;
    font-family: "Space Grotesk", Inter, sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1.1px;
    line-height: 16px;
    text-decoration: none;
    text-transform: uppercase;
}

.gallery-index-marker {
    display: flex;
    align-items: center;
    gap: 8px;
}

.gallery-index-dash {
    display: block;
    width: 24px;
    height: 2px;
    background: #89351d;
}

.gallery-index-kicker {
    margin: 0;
    color: #89351d;
    font-family: "Space Grotesk", Inter, sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1.1px;
    line-height: 16px;
    text-transform: uppercase;
}

.gallery-index-title {
    max-width: 760px;
    margin: 16px 0 0;
    color: #111;
    font-family: Poppins, "Plus Jakarta Sans", Inter, sans-serif;
    font-size: clamp(1.75rem, 3.2vw, 46px);
    font-weight: 600;
    line-height: 1.15;
}

.gallery-index-empty {
    margin-top: 2rem;
    color: #5a5a52;
}

.gallery-index-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    margin-top: 32px;
}

.gallery-index-card {
    display: flex;
    gap: 2px;
    width: min(100%, 480px);
    height: 292px;
    border-radius: 8px;
    overflow: hidden;
    background: #f7f4ee;
    text-decoration: none;
    color: inherit;
}

.gallery-index-lead {
    position: relative;
    flex: 476 1 0;
    min-width: 0;
    height: 100%;
}

.gallery-index-card.is-single .gallery-index-lead {
    flex: 1 1 auto;
}

.gallery-index-lead > img,
.gallery-index-thumb img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-index-scrim {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(19, 24, 14, 0) 40%, rgba(19, 24, 14, 0.85) 100%);
    pointer-events: none;
}

.gallery-index-count,
.gallery-index-copy {
    position: absolute;
    z-index: 1;
}

.gallery-index-count {
    top: 12px;
    left: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    height: 28px;
    min-width: 58px;
    padding: 0 10px;
    border: 1px solid #d5cec2;
    border-radius: 8px;
    background: #fff;
    color: #333;
    font-family: Poppins, "Plus Jakarta Sans", Inter, sans-serif;
    font-size: 14px;
    font-weight: 600;
    line-height: 1;
}

.gallery-index-copy {
    left: 16px;
    right: 16px;
    bottom: 16px;
}

.gallery-index-copy h2 {
    margin: 0;
    color: #fff;
    font-family: Poppins, "Plus Jakarta Sans", Inter, sans-serif;
    font-size: clamp(1.25rem, 1.6vw, 26px);
    font-weight: 600;
    line-height: 1.1;
}

.gallery-index-side {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex: 148 1 0;
    min-width: 0;
    height: 100%;
}

.gallery-index-thumb {
    position: relative;
    flex: 1 1 0;
    min-height: 0;
}

@media (min-width: 900px) {
    .gallery-index-wrap {
        width: min(1640px, calc(100% - 4rem));
    }

    .gallery-index-grid {
        gap: 28px;
    }
}
</style>
