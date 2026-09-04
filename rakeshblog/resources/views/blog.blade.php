@extends('layouts.app')

@section('title', 'Blog · Rakesh Rajbhat')

@section('title', 'Blog & Insights | Rakesh Rajbhat')
@section('meta_description', 'Articles and field reflections from Rakesh Rajbhat on AI, education, entrepreneurship, tourism, Palungtar and Nepal’s future.')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-12">
            <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-4 uppercase">Latest Articles</p>
            <h1 class="text-5xl font-serif font-bold mb-4">Blog &amp; Insights</h1>
            <p class="text-[#3a3a34] max-w-2xl mx-auto">Thoughts, stories and ideas from my journey in building opportunities for Nepal.</p>
        </div>

        <!-- Search & Filter -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <form action="{{ route('blog') }}" method="GET" class="flex-1 flex gap-3">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search blogs..." 
                       class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:border-[#D4AF37] focus:outline-none focus:ring-2 focus:ring-[#D4AF37]/20 transition">
                <button type="submit" class="px-6 py-2 bg-[#D4AF37] text-[#0b0e12] font-semibold rounded-lg hover:bg-[#c4a030] transition">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                @if(request('search') || request('category'))
                    <a href="{{ route('blog') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-times mr-1"></i>Clear
                    </a>
                @endif
            </form>
            
            @if(isset($categories) && $categories->count() > 0)
                <div class="flex gap-2 overflow-x-auto pb-2 md:pb-0">
                    <a href="{{ route('blog') }}" 
                       class="px-4 py-2 rounded-lg border border-gray-300 hover:border-[#D4AF37] transition whitespace-nowrap {{ !request('category') ? 'bg-[#D4AF37] text-[#0b0e12] border-[#D4AF37]' : 'bg-white hover:bg-gray-50' }}">
                        All
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('blog.category', $category) }}" 
                           class="px-4 py-2 rounded-lg border border-gray-300 hover:border-[#D4AF37] transition whitespace-nowrap {{ request('category') == $category ? 'bg-[#D4AF37] text-[#0b0e12] border-[#D4AF37]' : 'bg-white hover:bg-gray-50' }}">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Blog Grid -->
        @if(isset($blogs) && $blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($blogs as $blog)
                    <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="block">
                            <div class="relative overflow-hidden h-48">
                                @if($blog->featured_image)
                                    <img src="{{ $blog->featured_image_url }}" 
                                         alt="{{ $blog->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-[#D4AF37]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($blog->is_featured)
                                    <div class="absolute top-3 right-3">
                                        <span class="px-3 py-1 bg-[#D4AF37] text-[#0b0e12] text-xs font-bold rounded-full shadow-lg">
                                            <i class="fas fa-star mr-1"></i>Featured
                                        </span>
                                    </div>
                                @endif
                                
                                @if($blog->category)
                                    <div class="absolute bottom-3 left-3">
                                        <span class="px-3 py-1 bg-black/60 text-white text-xs font-medium rounded-full backdrop-blur-sm">
                                            {{ $blog->category }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                    <span><i class="far fa-calendar-alt mr-1"></i>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-clock mr-1"></i>{{ $blog->reading_time ?? '5 min read' }}
                                    </span>
                                    @if($blog->comments_count > 0)
                                        <span>•</span>
                                        <span class="flex items-center gap-1">
                                            <i class="far fa-comment mr-1"></i>{{ $blog->comments_count }}
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="text-xl font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors line-clamp-2">
                                    {{ $blog->title }}
                                </h3>
                                
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content ?? ''), 120) }}
                                </p>
                                
                                <div class="mt-4 flex items-center gap-2 text-sm text-[#D4AF37] font-medium">
                                    Read More 
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($blogs->hasPages())
                <div class="mt-12">
                    {{ $blogs->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12 bg-white rounded-xl shadow-md">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                </svg>
                <p class="text-gray-500">No blog posts found.</p>
                @if(request('search') || request('category'))
                    <a href="{{ route('blog') }}" class="inline-block mt-4 text-[#D4AF37] hover:underline">
                        <i class="fas fa-arrow-left mr-1"></i>Clear filters and view all blogs
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.pagination .page-item {
    display: inline-block;
}

.pagination .page-link {
    padding: 0.5rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    color: #1e1e1a;
    background: white;
    transition: all 0.2s ease;
    text-decoration: none;
}

.pagination .page-link:hover {
    background: #f3f4f6;
    border-color: #D4AF37;
}

.pagination .active .page-link {
    background: #D4AF37;
    color: #0b0e12;
    border-color: #D4AF37;
    font-weight: 600;
}

.pagination .disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
@endsection
