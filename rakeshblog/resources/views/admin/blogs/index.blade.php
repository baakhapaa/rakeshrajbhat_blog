@extends('admin.layouts.app')

@section('title', 'Blogs · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-serif font-bold text-white">Blogs</h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.blogs.create') }}" class="bg-[#D4AF37] text-[#0b0e12] px-4 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                + New Blog
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- ========================================== -->
    <!-- FILTER TABS                                -->
    <!-- ========================================== -->
    <div class="mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.blogs.index') }}" 
               class="px-4 py-2 rounded-lg text-sm font-semibold transition-all
               {{ !request('filter') ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white' }}">
                All Blogs
            </a>
            <a href="{{ route('admin.blogs.index', ['filter' => 'featured']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-semibold transition-all flex items-center gap-2
               {{ request('filter') == 'featured' ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white' }}">
                <span>⭐</span> Featured
            </a>
            <a href="{{ route('admin.blogs.index', ['filter' => 'published']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-semibold transition-all
               {{ request('filter') == 'published' ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white' }}">
                Published
            </a>
            <a href="{{ route('admin.blogs.index', ['filter' => 'draft']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-semibold transition-all
               {{ request('filter') == 'draft' ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white' }}">
                Draft
            </a>
            <a href="{{ route('admin.blogs.index', ['filter' => 'has_quiz']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-semibold transition-all
               {{ request('filter') == 'has_quiz' ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white' }}">
                Has Quiz
            </a>
        </div>
        
        <!-- Stats -->
        <div class="flex flex-wrap gap-6 mt-4 text-sm">
            <span class="text-white/40">Total: <span class="text-white font-semibold">{{ $totalBlogs ?? $blogs->total() }}</span></span>
            <span class="text-white/40">Featured: <span class="text-[#D4AF37] font-semibold">{{ $featuredCount ?? 0 }}</span></span>
            <span class="text-white/40">Published: <span class="text-green-400 font-semibold">{{ $publishedCount ?? 0 }}</span></span>
            <span class="text-white/40">Drafts: <span class="text-yellow-400 font-semibold">{{ $draftCount ?? 0 }}</span></span>
        </div>
    </div>

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        @if(isset($blogs) && $blogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead>
                        <tr class="border-b border-white/5 text-left text-white/60 text-sm">
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3">Category</th>
                            <th class="px-6 py-3 text-center">Featured</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($blog->featured_image)
                                            <img src="{{ $blog->featured_image_url }}" 
                                                 alt="{{ $blog->title }}" 
                                                 class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-[#D4AF37]/10 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#D4AF37]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="text-white font-medium">{{ $blog->title }}</span>
                                            @if($blog->has_quiz)
                                                <span class="ml-2 text-[10px] bg-[#D4AF37]/20 text-[#D4AF37] px-2 py-0.5 rounded-full">Quiz</span>
                                            @endif
                                            @if($blog->is_featured)
                                                <span class="ml-2 text-[10px] bg-[#D4AF37]/20 text-[#D4AF37] px-2 py-0.5 rounded-full">⭐ Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-white/60 text-sm bg-white/5 px-2 py-1 rounded-full">
                                        {{ $blog->category ?? 'General' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.blogs.toggle-featured', $blog->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="px-3 py-1 rounded-full text-xs font-semibold transition-all duration-200
                                                {{ $blog->is_featured ? 'bg-[#D4AF37]/20 text-[#D4AF37] border border-[#D4AF37]/30 hover:bg-[#D4AF37]/30' : 'bg-gray-500/20 text-gray-400 border border-gray-500/30 hover:bg-gray-500/30 hover:text-white' }}">
                                            {{ $blog->is_featured ? '⭐ Featured' : 'Not Featured' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.blogs.toggle-publish', $blog->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-3 py-1 rounded-full text-xs font-semibold transition-all duration-200
                                                {{ $blog->is_published ? 'bg-green-500/20 text-green-400 border border-green-500/30 hover:bg-green-500/30' : 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 hover:bg-yellow-500/30' }}">
                                            {{ $blog->is_published ? 'Published' : 'Draft' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-white/60 text-sm">
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View Button -->
                                        <a href="{{ route('blog.show', $blog->slug) }}" 
                                           target="_blank" 
                                           class="text-blue-400 hover:text-blue-300 transition-colors" 
                                           title="View Blog">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                                           class="text-[#D4AF37] hover:text-[#c4a030] transition-colors" 
                                           title="Edit Blog">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-400 hover:text-red-300 transition-colors" 
                                                    title="Delete Blog"
                                                    onclick="return confirm('Are you sure you want to delete "{{ $blog->title }}"? This action cannot be undone.')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/5 flex items-center justify-between">
                <div class="text-white/40 text-sm">
                    Showing {{ $blogs->firstItem() ?? 0 }} to {{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }} entries
                </div>
                <div>
                    {{ $blogs->links() }}
                </div>
            </div>
        @else
            <div class="p-6 text-center text-white/40 py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                </svg>
                <p>No blogs found.</p>
                @if(request('filter') == 'featured')
                    <p class="text-sm text-white/30 mt-1">No featured blogs yet. Mark a blog as featured to see it here.</p>
                @endif
                <a href="{{ route('admin.blogs.create') }}" class="inline-block mt-4 text-[#D4AF37] hover:underline">
                    Create Blog →
                </a>
            </div>
        @endif
    </div>
</div>
@endsection