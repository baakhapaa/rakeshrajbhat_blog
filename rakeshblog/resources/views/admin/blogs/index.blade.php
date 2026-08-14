@extends('admin.layouts.app')

@section('title', 'Blogs · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-serif font-bold text-white">Blogs</h1>
        <a href="{{ route('admin.blogs.create') }}" class="bg-[#D4AF37] text-[#0b0e12] px-4 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
            + New Blog
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        @if(isset($blogs) && $blogs->count() > 0)
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/5 text-left text-white/60 text-sm">
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="px-6 py-4 text-white">{{ $blog->title }}</td>
                            <td class="px-6 py-4 text-white/60 text-sm">{{ $blog->category ?? 'General' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $blog->is_published ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-white/60 text-sm">{{ $blog->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-[#D4AF37] hover:underline text-sm mr-3">Edit</a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-white/5">
                {{ $blogs->links() }}
            </div>
        @else
            <div class="p-6 text-center text-white/40 py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                </svg>
                <p>No blogs found. Create your first blog post!</p>
            </div>
        @endif
    </div>
</div>
@endsection