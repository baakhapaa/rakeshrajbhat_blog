@extends('layouts.app')

@php
    $shareImage = $collection->images->first()->url;
    if (! str_starts_with($shareImage, 'http://') && ! str_starts_with($shareImage, 'https://')) {
        $shareImage = url($shareImage);
    }
@endphp

@section('title', $collection->title.' · Gallery | Rakesh Rajbhat')
@section('meta_description', 'Photographs from '.$collection->title.'.')
@section('share_image', $shareImage)
@section('share_image_alt', $collection->title)

@section('content')
<section class="collection-page">
    <div class="collection-wrap">
        <a href="{{ route('home') }}#gallery" class="collection-back">Gallery</a>
        <div class="collection-head">
            <h1>{{ $collection->title }}</h1>
            <p>{{ $collection->images->count() }} {{ \Illuminate\Support\Str::plural('photograph', $collection->images->count()) }}</p>
        </div>

        <div class="collection-grid">
            @foreach($collection->images as $image)
                <button type="button" class="collection-photo" data-full="{{ $image->url }}">
                    <img src="{{ $image->url }}" alt="{{ $collection->title }}">
                </button>
            @endforeach
        </div>
    </div>
</section>

<div class="collection-lightbox" id="collectionLightbox" hidden>
    <button type="button" class="collection-lightbox-close" id="collectionLightboxClose" aria-label="Close photograph">Close</button>
    <img id="collectionLightboxImage" alt="{{ $collection->title }}">
</div>
@endsection

<style>
.collection-page {
    min-height: 100vh;
    background: #f7f4ee;
    color: #1e1e1a;
    padding: 8rem 1.5rem 5rem;
}

.collection-wrap {
    max-width: 72rem;
    margin: 0 auto;
}

.collection-back {
    color: #735A12;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.collection-back {
    display: inline-block;
    margin-bottom: 1.5rem;
    text-decoration: none;
}

.collection-back:hover {
    color: #1e1e1a;
}

.collection-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1.5rem;
    margin: 0.75rem 0 2rem;
}

.collection-head h1 {
    font-family: "Playfair Display", serif;
    font-size: clamp(2.2rem, 4vw, 3.4rem);
    font-weight: 700;
    line-height: 1.1;
}

.collection-head p {
    color: #5a5a52;
    font-size: 0.95rem;
    white-space: nowrap;
}

.collection-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.75rem;
}

.collection-photo {
    display: block;
    padding: 0;
    border: 0;
    background: #e7e1d6;
    border-radius: 0.75rem;
    overflow: hidden;
    cursor: zoom-in;
}


.collection-photo img {
    display: block;
    width: 100%;
    height: 240px;
    object-fit: cover;
}

.collection-lightbox {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4.5rem 1.5rem 1.5rem;
    background: rgba(11, 14, 18, 0.92);
}

.collection-lightbox[hidden] {
    display: none;
}

.collection-lightbox img {
    max-width: min(1100px, 100%);
    max-height: 100%;
    object-fit: contain;
    border-radius: 0.5rem;
}

.collection-lightbox-close {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    border: 0;
    border-radius: 999px;
    background: #fff;
    color: #1e1e1a;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.55rem 0.9rem;
    cursor: pointer;
}

@media (min-width: 800px) {
    .collection-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .collection-photo img {
        height: 260px;
    }
}

@media (max-width: 640px) {
    .collection-head {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById('collectionLightbox');
    const lightboxImage = document.getElementById('collectionLightboxImage');
    const close = document.getElementById('collectionLightboxClose');
    if (!lightbox || !lightboxImage) return;

    document.querySelectorAll('.collection-photo').forEach(function (button) {
        button.addEventListener('click', function () {
            lightboxImage.src = button.dataset.full;
            lightbox.hidden = false;
        });
    });

    const hide = function () {
        lightbox.hidden = true;
        lightboxImage.removeAttribute('src');
    };

    close.addEventListener('click', hide);
    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) hide();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !lightbox.hidden) hide();
    });
});
</script>
@endpush
