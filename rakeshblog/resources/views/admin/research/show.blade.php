@extends('admin.layouts.app')

@section('title', 'View Research · Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white flex items-center gap-3">
                <i class="fas fa-eye text-[#D4AF37]"></i>
                {{ $research->title }}
            </h1>
            <p class="text-gray-400 text-sm mt-1">View research item details</p>
        </div>
        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="{{ route('admin.research.edit', $research) }}" class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2 font-medium">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.research.index') }}" class="px-4 py-2 border border-white/20 text-white/70 rounded-lg hover:bg-white/5 hover:text-white transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        <div class="p-6">
            <!-- Basic Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Category</h3>
                    <p class="mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1
                            {{ $research->category == 'Vision' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                            {{ $research->category == 'Research Papers' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                            {{ $research->category == 'Media' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}">
                            <i class="fas 
                                {{ $research->category == 'Vision' ? 'fa-eye' : '' }}
                                {{ $research->category == 'Research Papers' ? 'fa-book' : '' }}
                                {{ $research->category == 'Media' ? 'fa-video' : '' }}
                                mr-1"></i>
                            {{ $research->category }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Status</h3>
                    <p class="mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1
                            {{ $research->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full inline-block
                                {{ $research->is_active ? 'bg-green-400' : 'bg-red-400' }}"></span>
                            {{ $research->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Order</h3>
                    <p class="mt-1 text-white">{{ $research->order }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Created</h3>
                    <p class="mt-1 text-white">{{ $research->created_at->format('F d, Y h:i A') }}</p>
                </div>
                @if($research->updated_at && $research->updated_at != $research->created_at)
                <div class="md:col-span-2">
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Last Updated</h3>
                    <p class="mt-1 text-white">{{ $research->updated_at->format('F d, Y h:i A') }}</p>
                </div>
                @endif
            </div>

            <hr class="border-white/10 my-6">

            <!-- Description -->
            <div>
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                <div class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $research->description }}</div>
            </div>

            @if($research->content)
                <div class="mt-6">
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Detailed Content</h3>
                    <div class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $research->content }}</div>
                </div>
            @endif

            <!-- Media & Links -->
            @if($research->image_url || $research->video_url || $research->video_file || $research->link_url)
                <hr class="border-white/10 my-6">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-4">Media & Links</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($research->image_url)
                        <div>
                            <h4 class="text-sm font-medium text-gray-400 mb-2">Image</h4>
                            <img src="{{ $research->image_url }}" alt="{{ $research->title }}" class="max-w-full rounded-lg border border-white/10 shadow-lg max-h-64 object-contain bg-[#0b0e12]">
                        </div>
                    @endif

                    @if($research->video_url || $research->video_file)
                        <div>
                            <h4 class="text-sm font-medium text-gray-400 mb-2">Video</h4>
                            <div class="rounded-lg overflow-hidden border border-white/10 bg-[#0b0e12]">
                                @if($research->video_file)
                                    <video controls class="w-full max-h-64">
                                        <source src="{{ asset($research->video_file) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif($research->video_url)
                                    <div class="aspect-video">
                                        @php
                                            $embedUrl = $research->video_embed_url;
                                        @endphp
                                        @if($embedUrl)
                                            <iframe src="{{ $embedUrl }}" class="w-full h-full" allowfullscreen></iframe>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-[#0b0e12]">
                                                <div class="text-center">
                                                    <i class="fas fa-video text-4xl mb-2 opacity-20"></i>
                                                    <p>Video URL not supported</p>
                                                    <a href="{{ $research->video_url }}" target="_blank" class="text-[#D4AF37] text-sm hover:underline">
                                                        Open video in new tab
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="w-full h-48 flex items-center justify-center text-gray-400 bg-[#0b0e12]">
                                        <div class="text-center">
                                            <i class="fas fa-video text-4xl mb-2 opacity-20"></i>
                                            <p>No video available</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($research->link_url)
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-400 mb-2">External Link</h4>
                            <a href="{{ $research->link_url }}" target="_blank" rel="noopener noreferrer" class="text-[#D4AF37] hover:text-[#c4a030] transition flex items-center gap-2">
                                <i class="fas fa-external-link-alt"></i>
                                {{ $research->link_url }}
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <hr class="border-white/10 my-6">
                <div class="text-center text-gray-400 py-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    No media or links available for this item.
                </div>
            @endif

            <!-- Additional Info -->
            <hr class="border-white/10 my-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Slug</h3>
                    <p class="mt-1 text-gray-300 text-sm font-mono">{{ $research->slug }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">ID</h3>
                    <p class="mt-1 text-gray-300 text-sm font-mono">#{{ $research->id }}</p>
                </div>
            </div>

            <!-- Action Buttons at Bottom -->
            <div class="mt-8 pt-6 border-t border-white/10 flex flex-wrap gap-4">
                <a href="{{ route('admin.research.edit', $research) }}" class="px-6 py-2.5 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2 font-medium">
                    <i class="fas fa-edit"></i> Edit Research Item
                </a>
                <button onclick="if(confirm('Are you sure you want to delete this research item?')) document.getElementById('delete-form').submit();" 
                        class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2 font-medium">
                    <i class="fas fa-trash"></i> Delete
                </button>
                <form id="delete-form" action="{{ route('admin.research.destroy', $research) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
                <a href="{{ route('admin.research.index') }}" class="px-6 py-2.5 border border-white/20 text-white/70 rounded-lg hover:bg-white/5 hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
/* Smooth transitions */
.transition {
    transition: all 0.2s ease;
}

/* Video player styling */
video {
    background: #0b0e12;
    max-width: 100%;
}

video:focus {
    outline: none;
}

/* Image hover effect */
img {
    transition: transform 0.3s ease;
}

img:hover {
    transform: scale(1.02);
}

/* Link hover effect */
a.text-\\[\\#D4AF37\\] {
    transition: all 0.2s ease;
}

a.text-\\[\\#D4AF37\\]:hover {
    color: #c4a030;
    text-decoration: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .max-w-4xl {
        padding: 0 1rem;
    }
    
    .grid-cols-1.md\\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
}

/* Custom scrollbar for content */
.whitespace-pre-wrap {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 8px;
}

.whitespace-pre-wrap::-webkit-scrollbar {
    width: 6px;
}

.whitespace-pre-wrap::-webkit-scrollbar-track {
    background: #0b0e12;
    border-radius: 3px;
}

.whitespace-pre-wrap::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 3px;
}

.whitespace-pre-wrap::-webkit-scrollbar-thumb:hover {
    background: #c4a030;
}
</style>