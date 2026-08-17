@extends('admin.layouts.app')

@section('title', 'Comments · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-serif font-bold text-white">Comments</h1>
        <span class="text-white/60 text-sm">Total: {{ $comments->total() }} comments</span>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        @if(isset($comments) && $comments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/5 text-left text-white/60 text-sm">
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Blog</th>
                            <th class="px-6 py-3">Comment</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-[#D4AF37]/20 text-[#D4AF37] flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-white">{{ $comment->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-white/60 text-sm">
                                    <a href="{{ route('blog.show', $comment->blog->slug) }}" class="hover:text-[#D4AF37] transition" target="_blank">
                                        {{ Str::limit($comment->blog->title, 30) }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-white/80 text-sm">
                                    {{ Str::limit($comment->content, 60) }}
                                </td>
                                <td class="px-6 py-4 text-white/60 text-sm">
                                    {{ $comment->created_at->format('M d, Y') }}
                                    <span class="block text-xs text-white/30">{{ $comment->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition px-3 py-1 rounded border border-red-400/30 hover:bg-red-500/10" 
                                                onclick="return confirm('Are you sure you want to delete this comment?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/5">
                {{ $comments->links() }}
            </div>
        @else
            <div class="p-6 text-center text-white/40 py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 10h8M8 14h5m7 7H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z"/>
                </svg>
                <p>No comments found.</p>
            </div>
        @endif
    </div>
</div>
@endsection