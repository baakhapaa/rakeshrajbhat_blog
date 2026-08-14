@extends('layouts.app')

@section('title', $blog->title . ' · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Back to Blog -->
        <a href="{{ route('blog') }}" class="inline-flex items-center text-[#D4AF37] hover:underline mb-6 group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Blog
        </a>

        <!-- Blog Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">{{ $blog->title }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                <span>{{ $blog->created_at->format('F d, Y') }}</span>
                <span>•</span>
                <span class="text-[#D4AF37] font-semibold">{{ $blog->category ?? 'General' }}</span>
                <span>•</span>
                <span>{{ $blog->reading_time ?? '3 min read' }}</span>
            </div>
        </div>

        <!-- Featured Image -->
        @if($blog->featured_image)
            <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full rounded-xl mb-8">
        @endif

        <!-- Blog Content -->
        <div class="bg-white rounded-xl p-8 shadow-md">
            <div class="blog-content prose prose-lg max-w-none">
                {!! $blog->content !!}
            </div>
        </div>

        <!-- Tags -->
        @if($blog->tags && count($blog->tags) > 0)
            <div class="flex flex-wrap gap-2 mt-8">
                @foreach($blog->tags as $tag)
                    <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-sm">{{ $tag }}</span>
                @endforeach
            </div>
        @endif

        <!-- Related Posts -->
        @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-serif font-bold mb-6">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedBlogs as $related)
                        <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all group">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 group-hover:text-[#D4AF37] transition-colors">
                                    <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                                </h3>
                                <p class="text-gray-600 text-sm">{!! Str::limit(strip_tags($related->content), 100) !!}</p>
                                <a href="{{ route('blog.show', $related->slug) }}" class="inline-block mt-2 text-sm text-[#D4AF37] hover:underline">Read More →</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Add styles for blog content -->
<style>
    .blog-content {
        font-family: 'Inter', sans-serif;
        line-height: 1.8;
        color: #1e1e1a;
    }
    
    .blog-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .blog-content h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-top: 1.8rem;
        margin-bottom: 0.8rem;
        font-family: 'Playfair Display', serif;
    }
    
    .blog-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.6rem;
        font-family: 'Playfair Display', serif;
    }
    
    .blog-content h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .blog-content p {
        margin-bottom: 1rem;
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .blog-content ul, .blog-content ol {
        margin: 1rem 0 1rem 2rem;
    }
    
    .blog-content ul {
        list-style-type: disc;
    }
    
    .blog-content ol {
        list-style-type: decimal;
    }
    
    .blog-content li {
        margin-bottom: 0.5rem;
        font-size: 1.05rem;
    }
    
    .blog-content a {
        color: #D4AF37;
        text-decoration: underline;
    }
    
    .blog-content a:hover {
        color: #b8922a;
    }
    
    .blog-content blockquote {
        border-left: 4px solid #D4AF37;
        padding: 0.5rem 1.5rem;
        margin: 1.5rem 0;
        background: #f8f6f0;
        border-radius: 0 8px 8px 0;
        font-style: italic;
        font-size: 1.1rem;
    }
    
    .blog-content blockquote p {
        margin-bottom: 0;
    }
    
    .blog-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
    }
    
    .blog-content table th {
        background: #f2f2f2;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 600;
        border: 1px solid #ddd;
    }
    
    .blog-content table td {
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
    }
    
    .blog-content table tr:nth-child(even) {
        background: #f9f9f9;
    }
    
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    
    .blog-content code {
        background: #f4f4f4;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.9rem;
    }
    
    .blog-content pre {
        background: #1e1e1a;
        color: #f0efe7;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1.5rem 0;
    }
    
    .blog-content pre code {
        background: transparent;
        color: inherit;
        padding: 0;
    }
    
    @media (max-width: 768px) {
        .blog-content h1 {
            font-size: 2rem;
        }
        .blog-content h2 {
            font-size: 1.6rem;
        }
        .blog-content h3 {
            font-size: 1.3rem;
        }
        .blog-content p {
            font-size: 1rem;
        }
        .blog-content table {
            font-size: 0.9rem;
        }
        .blog-content table th,
        .blog-content table td {
            padding: 0.5rem;
        }
    }
</style>
@endsection