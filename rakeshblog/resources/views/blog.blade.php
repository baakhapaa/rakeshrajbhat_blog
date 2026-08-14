@extends('layouts.app')

@section('title', 'Blog · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-4 uppercase">Latest Articles</p>
            <h1 class="text-5xl font-serif font-bold mb-6">Blog &amp; Insights</h1>
            <p class="text-[#3a3a34] max-w-2xl mx-auto">Thoughts, stories and ideas from my journey in building opportunities for Nepal.</p>
        </div>

        @if(isset($blogs) && $blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($blogs as $blog)
                    <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1 group">
                        @if($blog->featured_image)
                            <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="h-48 bg-gradient-to-r from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center">
                                <span class="text-6xl">📚</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                                <span>{{ $blog->created_at->format('F d, Y') }}</span>
                                <span>•</span>
                                <span class="text-[#D4AF37] font-semibold">{{ $blog->category ?? 'General' }}</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2 group-hover:text-[#D4AF37] transition-colors">
                                <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>
                            <p class="text-gray-600 text-sm">{!! Str::limit(strip_tags($blog->content), 120) !!}</p>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="inline-block mt-4 text-sm font-semibold text-[#D4AF37] hover:underline">Read More →</a>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $blogs->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl shadow-md">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                </svg>
                <p class="text-gray-500">No blog posts available yet. Check back soon!</p>
            </div>
        @endif
    </div>
</section>
@endsection