@extends('admin.layouts.app')

@section('title', 'Manage Research · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white flex items-center gap-3">
                <i class="fas fa-flask text-[#D4AF37]"></i>
                Research & Resources
            </h1>
            <p class="text-gray-400 text-sm mt-1">Manage vision, research papers, and media content</p>
        </div>
        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="{{ route('admin.research.create') }}" 
               class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2 font-medium">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-4 mb-6">
        <form method="GET" action="{{ route('admin.research.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by title, category..."
                       class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
            </div>
            <div class="min-w-[180px]">
                <select name="category" class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                    <option value="">All Categories</option>
                    <option value="Vision" {{ request('category') == 'Vision' ? 'selected' : '' }}>Vision</option>
                    <option value="Research Papers" {{ request('category') == 'Research Papers' ? 'selected' : '' }}>Research Papers</option>
                    <option value="Media" {{ request('category') == 'Media' ? 'selected' : '' }}>Media</option>
                </select>
            </div>
            <div class="min-w-[150px]">
                <select name="status" class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2 font-medium">
                <i class="fas fa-search"></i> Search
            </button>
            @if(request()->has('search') || request()->has('category') || request()->has('status'))
                <a href="{{ route('admin.research.index') }}" class="px-4 py-2 border border-white/20 text-white/70 rounded-lg hover:bg-white/5 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Research Table -->
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-[#0b0e12]">
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.research.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center gap-1 hover:text-white transition">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Title</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Media</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Featured</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.research.index', array_merge(request()->all(), ['sort' => 'order', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center gap-1 hover:text-white transition">
                                Order
                                @if(request('sort') == 'order')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.research.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center gap-1 hover:text-white transition">
                                Created
                                @if(request('sort') == 'created_at')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($researchItems as $item)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="py-4 px-4 text-sm text-gray-400">#{{ $item->id }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    @if($item->image_url)
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-[#0b0e12] border border-white/10">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-lg flex-shrink-0 bg-[#0b0e12] border border-white/10 flex items-center justify-center text-[#D4AF37]">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white text-sm font-medium">{{ $item->title }}</p>
                                        <p class="text-xs text-gray-400 truncate max-w-xs">{{ Str::limit($item->description, 60) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $item->category == 'Vision' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                                    {{ $item->category == 'Research Papers' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                                    {{ $item->category == 'Media' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}">
                                    <i class="fas 
                                        {{ $item->category == 'Vision' ? 'fa-eye' : '' }}
                                        {{ $item->category == 'Research Papers' ? 'fa-book' : '' }}
                                        {{ $item->category == 'Media' ? 'fa-video' : '' }}
                                        mr-1"></i>
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    @if($item->video_url || $item->video_file)
                                        <span class="text-green-400 text-sm" title="Has Video">
                                            <i class="fas fa-video"></i>
                                        </span>
                                    @endif
                                    @if($item->image_url)
                                        <span class="text-blue-400 text-sm" title="Has Image">
                                            <i class="fas fa-image"></i>
                                        </span>
                                    @endif
                                    @if($item->link_url)
                                        <span class="text-purple-400 text-sm" title="Has Link">
                                            <i class="fas fa-link"></i>
                                        </span>
                                    @endif
                                    @if(!$item->video_url && !$item->video_file && !$item->image_url && !$item->link_url)
                                        <span class="text-gray-500 text-xs">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <button onclick="toggleStatus({{ $item->id }})" class="status-toggle">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1
                                        {{ $item->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                        <span class="w-1.5 h-1.5 rounded-full inline-block
                                            {{ $item->is_active ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </button>
                            </td>
                            <td class="py-4 px-4">
                                <button onclick="toggleFeatured({{ $item->id }})" class="featured-toggle">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1
                                        {{ $item->is_featured ? 'bg-[#D4AF37]/20 text-[#D4AF37] border border-[#D4AF37]/30' : 'bg-gray-500/20 text-gray-400 border border-gray-500/30' }}">
                                        <i class="fas fa-star"></i>
                                        {{ $item->is_featured ? 'Featured' : 'Not Featured' }}
                                    </span>
                                </button>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-400">
                                {{ $item->order }}
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-400">
                                <span title="{{ $item->created_at->format('M d, Y h:i A') }}">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.research.show', $item) }}" 
                                       class="p-1.5 text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 rounded transition" 
                                       title="View">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.research.edit', $item) }}" 
                                       class="p-1.5 text-[#D4AF37] hover:text-[#c4a030] hover:bg-[#D4AF37]/10 rounded transition" 
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button onclick="if(confirm('Are you sure you want to delete this research item?')) document.getElementById('delete-form-{{ $item->id }}').submit();" 
                                            class="p-1.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded transition" 
                                            title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.research.destroy', $item) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-gray-400">
                                <i class="fas fa-flask text-5xl block mb-4 text-white/10"></i>
                                <p class="text-lg font-medium">No research items found</p>
                                <p class="text-sm text-gray-500 mt-1">Create your first research item to get started</p>
                                <a href="{{ route('admin.research.create') }}" class="inline-block mt-4 px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition">
                                    <i class="fas fa-plus mr-2"></i> Add Research Item
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($researchItems) && method_exists($researchItems, 'hasPages') && $researchItems->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $researchItems->links() }}
            </div>
        @endif
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">Total Items</p>
            <p class="text-2xl font-bold text-white">{{ \App\Models\Research::count() }}</p>
        </div>
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">Active</p>
            <p class="text-2xl font-bold text-white">{{ \App\Models\Research::where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">Featured</p>
            <p class="text-2xl font-bold text-white">{{ \App\Models\Research::where('is_featured', true)->count() }}</p>
        </div>
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">Categories</p>
            <p class="text-2xl font-bold text-white">
                {{ \App\Models\Research::distinct('category')->count() }}
            </p>
        </div>
    </div>
</div>

<script>
    function toggleStatus(id) {
    const button = document.querySelector(`[onclick*="toggleStatus(${id})"]`);
    if (button) {
        const span = button.querySelector('span');
        const originalHtml = span.innerHTML;
        span.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    
    fetch(`/admin/research/${id}/toggle-status`, {
        method: 'PUT',  // Changed to PUT
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(async response => {
        if (!response.ok) {
            const text = await response.text();
            throw new Error(`HTTP ${response.status}: ${text}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to toggle status: ' + (data.message || 'Unknown error'));
            if (button) {
                const span = button.querySelector('span');
                span.innerHTML = originalHtml;
                button.disabled = false;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while toggling status.');
        if (button) {
            const span = button.querySelector('span');
            span.innerHTML = originalHtml;
            button.disabled = false;
        }
    });
}

function toggleFeatured(id) {
    console.log('Toggling featured for ID:', id);
    
    const button = document.querySelector(`[onclick*="toggleFeatured(${id})"]`);
    let originalHtml = '';
    if (button) {
        const span = button.querySelector('span');
        originalHtml = span.innerHTML;
        span.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        button.disabled = true;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const url = `/admin/research/${id}/toggle-featured`;
    console.log('Sending POST request to:', url);

    fetch(url, {
        method: 'POST',  // Use POST
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            _method: 'POST'  // Override method
        })
    })
    .then(async response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            const text = await response.text();
            console.error('Error response:', text);
            throw new Error(`HTTP ${response.status}: ${text}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to toggle featured status: ' + (data.message || 'Unknown error'));
            if (button) {
                const span = button.querySelector('span');
                span.innerHTML = originalHtml;
                button.disabled = false;
            }
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        alert('An error occurred while toggling featured status.\n\nCheck the console for details (F12).');
        if (button) {
            const span = button.querySelector('span');
            span.innerHTML = originalHtml;
            button.disabled = false;
        }
    });
}

</script>

<style>
/* Smooth transitions */
.transition {
    transition: all 0.2s ease;
}

/* Custom scrollbar for table */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #0b0e12;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 3px;
}

/* Status toggle button hover effect */
.status-toggle {
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}

.status-toggle:hover span {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

/* Featured toggle button hover effect */
.featured-toggle {
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}

.featured-toggle:hover span {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

/* Table row hover effect */
tbody tr {
    transition: background-color 0.2s ease;
}

/* Action buttons hover */
.p-1\\.5 {
    transition: all 0.2s ease;
}

/* Empty state icon animation */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.text-white\/10 .fa-flask {
    animation: float 3s ease-in-out infinite;
}
</style>
@endsection