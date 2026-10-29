@extends('layouts.app')

@section('title', 'Blog · Rakesh Rajbhat')

@section('title', 'Blog & Insights | Rakesh Rajbhat')
@section('meta_description', 'Articles and field reflections from Rakesh Rajbhat on AI, education, entrepreneurship, tourism, Palungtar and Nepal’s future.')

@section('content')
@php
    $blogPage = \App\Models\Setting::getBlogPage();
@endphp
<section class="library-page">
    <div class="library-wrap">
        <div class="text-center">
            <div class="site-kicker center">
                <span aria-hidden="true"></span>
                <p>{{ $blogPage['eyebrow'] }}</p>
            </div>
            <h1>{{ $blogPage['title'] }}</h1>
            <p class="library-lead">{{ $blogPage['paragraph'] }}</p>
        </div>

        <form action="{{ route('blog') }}" method="GET" class="library-search" style="margin-top:32px">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search blogs...">
            <button type="submit" class="library-cta">Search</button>
            @if(request('search') || request('category'))
                <a href="{{ route('blog') }}" class="library-ghost">Clear</a>
            @endif
        </form>

        @if(isset($categories) && $categories->count() > 0)
            <div class="library-pills">
                <a href="{{ route('blog') }}" class="library-pill {{ !request('category') ? 'is-active' : '' }}">All</a>
                @foreach($categories as $category)
                    <a href="{{ route('blog.category', $category) }}" class="library-pill {{ request('category') == $category ? 'is-active' : '' }}">{{ $category }}</a>
                @endforeach
            </div>
        @endif

        @if(isset($blogs) && $blogs->count() > 0)
            <div class="library-grid cols-3">
                @foreach($blogs as $blog)
                    <a href="{{ route('blog.show', $blog->slug) }}" class="library-card">
                        <div class="library-media">
                            @if($blog->featured_image)
                                <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" loading="lazy" decoding="async">
                            @endif
                            @if($blog->is_featured)
                                <span class="library-flag">Featured</span>
                            @endif
                            @if($blog->category)
                                <p class="library-chip">{{ $blog->category }}</p>
                            @endif
                        </div>
                        <div class="library-body">
                            <p class="library-date">{{ $blog->short_date }}@if($blog->reading_time) · {{ $blog->reading_time }}@endif</p>
                            <h3>{{ $blog->title }}</h3>
                            <p class="library-excerpt">{{ $blog->excerpt ?? Str::limit(strip_tags($blog->content ?? ''), 140) }}</p>
                            <span class="library-read">
                                Read more
                                <img src="{{ asset('images/studies/read-more-arrow.svg') }}" alt="" width="10.6667" height="10.6667">
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($blogs->hasPages())
                <div>{{ $blogs->appends(request()->query())->links() }}</div>
            @endif
        @else
            <div class="library-empty">
                <p>No blog posts found.</p>
                @if(request('search') || request('category'))
                    <a href="{{ route('blog') }}" class="library-read" style="margin-top:16px">Clear filters</a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
