@extends('admin.layouts.app')

@section('title', 'Manage Research · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
                    <i class="fas fa-flask text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-serif font-bold text-white">Research & Resources</h1>
                    <p class="text-gray-400 text-sm mt-0.5">Manage vision, research papers, and media content</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="{{ route('admin.research.create') }}" 
               class="px-5 py-2.5 bg-gradient-to-r from-[#D4AF37] to-[#c4a030] text-[#0b0e12] rounded-xl hover:shadow-lg hover:shadow-[#D4AF37]/25 transition-all duration-300 flex items-center gap-2 font-medium hover:-translate-y-0.5">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/20 text-green-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3 backdrop-blur-sm animate-slideDown">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-green-400"></i>
            </div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-gradient-to-r from-red-500/10 to-rose-500/10 border border-red-500/20 text-red-400 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3 backdrop-blur-sm animate-slideDown">
            <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-[#1a1f26] rounded-2xl border border-white/5 p-5 mb-6 backdrop-blur-sm">
        <form method="GET" action="{{ route('admin.research.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by title, category..."
                           class="w-full pl-10 pr-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-xl text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition-all duration-300 focus:shadow-lg focus:shadow-[#D4AF37]/5">
                </div>
            </div>
            <div class="min-w-[180px]">
                <select name="category" class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-xl text-gray-200 focus:border-[#D4AF37] focus:outline-none transition-all duration-300 cursor-pointer appearance-none">
                    <option value="">All Categories</option>
                    <option value="Vision" {{ request('category') == 'Vision' ? 'selected' : '' }}>Vision</option>
                    <option value="Research Papers" {{ request('category') == 'Research Papers' ? 'selected' : '' }}>Research Papers</option>
                    <option value="Media" {{ request('category') == 'Media' ? 'selected' : '' }}>Media</option>
                </select>
            </div>
            <div class="min-w-[150px]">
                <select name="status" class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-xl text-gray-200 focus:border-[#D4AF37] focus:outline-none transition-all duration-300 cursor-pointer appearance-none">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>❌ Inactive</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-[#D4AF37] text-[#0b0e12] rounded-xl hover:bg-[#c4a030] transition-all duration-300 flex items-center gap-2 font-medium hover:shadow-lg hover:shadow-[#D4AF37]/25 hover:-translate-y-0.5">
                <i class="fas fa-search"></i> Search
            </button>
            @if(request()->has('search') || request()->has('category') || request()->has('status'))
                <a href="{{ route('admin.research.index') }}" class="px-5 py-2.5 border border-white/10 text-gray-400 rounded-xl hover:bg-white/5 hover:text-white transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-[#1a1f26] to-[#141920] rounded-2xl p-5 border border-white/5 hover:border-[#D4AF37]/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#D4AF37]/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-medium">Total Items</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Research::count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
                    <i class="fas fa-flask text-xl"></i>
                </div>
            </div>
            <div class="w-full h-1 bg-white/5 rounded-full mt-3 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[#D4AF37] to-[#c4a030] rounded-full" style="width: 100%"></div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-[#1a1f26] to-[#141920] rounded-2xl p-5 border border-white/5 hover:border-[#D4AF37]/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#D4AF37]/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-medium">Active</p>
                    <p class="text-3xl font-bold text-green-400 mt-1">{{ \App\Models\Research::where('is_active', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-green-500/10 flex items-center justify-center text-green-400">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            <div class="w-full h-1 bg-white/5 rounded-full mt-3 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full" style="width: {{ \App\Models\Research::count() > 0 ? (\App\Models\Research::where('is_active', true)->count() / \App\Models\Research::count()) * 100 : 0 }}%"></div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-[#1a1f26] to-[#141920] rounded-2xl p-5 border border-white/5 hover:border-[#D4AF37]/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#D4AF37]/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-medium">Featured</p>
                    <p class="text-3xl font-bold text-[#D4AF37] mt-1">{{ \App\Models\Research::where('is_featured', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
                    <i class="fas fa-star text-xl"></i>
                </div>
            </div>
            <div class="w-full h-1 bg-white/5 rounded-full mt-3 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[#D4AF37] to-[#c4a030] rounded-full" style="width: {{ \App\Models\Research::count() > 0 ? (\App\Models\Research::where('is_featured', true)->count() / \App\Models\Research::count()) * 100 : 0 }}%"></div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-[#1a1f26] to-[#141920] rounded-2xl p-5 border border-white/5 hover:border-[#D4AF37]/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#D4AF37]/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider font-medium">Categories</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Research::distinct('category')->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400">
                    <i class="fas fa-tags text-xl"></i>
                </div>
            </div>
            <div class="w-full h-1 bg-white/5 rounded-full mt-3 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-400 to-pink-500 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Research Table -->
    <div class="bg-[#1a1f26] rounded-2xl border border-white/5 overflow-hidden backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/5 bg-[#0f1419]">
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.research.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center gap-1 hover:text-white transition-all duration-200 group">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs text-[#D4AF37]"></i>
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
                               class="flex items-center gap-1 hover:text-white transition-all duration-200 group">
                                Order
                                @if(request('sort') == 'order')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs text-[#D4AF37]"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.research.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center gap-1 hover:text-white transition-all duration-200 group">
                                Created
                                @if(request('sort') == 'created_at')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs text-[#D4AF37]"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($researchItems as $item)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-all duration-200 group">
                            <td class="py-4 px-4 text-sm text-gray-400 font-mono">#{{ $item->id }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    @if($item->image_url)
                                        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-[#0b0e12] border border-white/10 group-hover:border-[#D4AF37]/30 transition-all duration-300">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-xl flex-shrink-0 bg-gradient-to-br from-[#0b0e12] to-[#141a21] border border-white/10 flex items-center justify-center text-[#D4AF37] group-hover:border-[#D4AF37]/30 transition-all duration-300">
                                            <i class="fas fa-file-alt text-sm"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white text-sm font-medium group-hover:text-[#D4AF37] transition-colors duration-200">{{ $item->title }}</p>
                                        <p class="text-xs text-gray-400 truncate max-w-xs">{{ Str::limit($item->description, 60) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center gap-1.5
                                    {{ $item->category == 'Vision' ? 'bg-amber-500/15 text-amber-400 border border-amber-500/20' : '' }}
                                    {{ $item->category == 'Research Papers' ? 'bg-blue-500/15 text-blue-400 border border-blue-500/20' : '' }}
                                    {{ $item->category == 'Media' ? 'bg-purple-500/15 text-purple-400 border border-purple-500/20' : '' }}">
                                    <i class="fas 
                                        {{ $item->category == 'Vision' ? 'fa-eye' : '' }}
                                        {{ $item->category == 'Research Papers' ? 'fa-book' : '' }}
                                        {{ $item->category == 'Media' ? 'fa-video' : '' }}
                                        text-[10px]"></i>
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    @if($item->video_url || $item->video_file)
                                        <span class="inline-flex items-center gap-1 text-green-400 text-xs bg-green-500/10 px-2 py-1 rounded-full" title="Has Video">
                                            <i class="fas fa-video text-[10px]"></i>
                                            <span class="font-medium">Video</span>
                                        </span>
                                    @endif
                                    @if($item->image_url)
                                        <span class="inline-flex items-center gap-1 text-blue-400 text-xs bg-blue-500/10 px-2 py-1 rounded-full" title="Has Image">
                                            <i class="fas fa-image text-[10px]"></i>
                                            <span class="font-medium">Image</span>
                                        </span>
                                    @endif
                                    @if($item->link_url)
                                        <span class="inline-flex items-center gap-1 text-purple-400 text-xs bg-purple-500/10 px-2 py-1 rounded-full" title="Has Link">
                                            <i class="fas fa-link text-[10px]"></i>
                                            <span class="font-medium">Link</span>
                                        </span>
                                    @endif
                                    @if(!$item->video_url && !$item->video_file && !$item->image_url && !$item->link_url)
                                        <span class="text-gray-500 text-xs">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <button onclick="toggleStatus({{ $item->id }})" class="status-toggle">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 transition-all duration-300 hover:scale-105
                                        {{ $item->is_active ? 'bg-green-500/15 text-green-400 border border-green-500/20' : 'bg-red-500/15 text-red-400 border border-red-500/20' }}">
                                        <span class="w-1.5 h-1.5 rounded-full inline-block
                                            {{ $item->is_active ? 'bg-green-400 animate-pulse' : 'bg-red-400' }}"></span>
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </button>
                            </td>
                            <td class="py-4 px-4">
                                <button onclick="toggleFeatured({{ $item->id }})" class="featured-toggle">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 transition-all duration-300 hover:scale-105
                                        {{ $item->is_featured ? 'bg-[#D4AF37]/15 text-[#D4AF37] border border-[#D4AF37]/30 shadow-lg shadow-[#D4AF37]/10' : 'bg-gray-500/10 text-gray-400 border border-gray-500/20' }}">
                                        <i class="fas fa-star {{ $item->is_featured ? 'text-[#D4AF37]' : '' }} text-[10px]"></i>
                                        {{ $item->is_featured ? 'Featured' : 'Not Featured' }}
                                    </span>
                                </button>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-400">
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-white/5 rounded-full text-xs">
                                    <i class="fas fa-sort text-[10px] text-gray-500"></i>
                                    {{ $item->order }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-400">
                                <span title="{{ $item->created_at->format('M d, Y h:i A') }}" class="inline-flex items-center gap-1">
                                    <i class="far fa-calendar-alt text-[10px] text-gray-500"></i>
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.research.show', $item) }}" 
                                       class="p-2 text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 rounded-xl transition-all duration-200 group/btn" 
                                       title="View">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.research.edit', $item) }}" 
                                       class="p-2 text-[#D4AF37] hover:text-[#c4a030] hover:bg-[#D4AF37]/10 rounded-xl transition-all duration-200 group/btn" 
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button onclick="if(confirm('Are you sure you want to delete this research item?')) document.getElementById('delete-form-{{ $item->id }}').submit();" 
                                            class="p-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition-all duration-200 group/btn" 
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
                            <td colspan="9" class="py-16 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 rounded-full bg-white/5 flex items-center justify-center mb-4">
                                        <i class="fas fa-flask text-4xl text-white/10"></i>
                                    </div>
                                    <p class="text-lg font-medium text-white/60">No research items found</p>
                                    <p class="text-sm text-gray-500 mt-1">Create your first research item to get started</p>
                                    <a href="{{ route('admin.research.create') }}" class="inline-block mt-4 px-5 py-2.5 bg-[#D4AF37] text-[#0b0e12] rounded-xl hover:bg-[#c4a030] transition-all duration-300 hover:shadow-lg hover:shadow-[#D4AF37]/25 hover:-translate-y-0.5">
                                        <i class="fas fa-plus mr-2"></i> Add Research Item
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($researchItems) && method_exists($researchItems, 'hasPages') && $researchItems->hasPages())
            <div class="px-6 py-4 border-t border-white/5 bg-[#0f1419]">
                {{ $researchItems->links() }}
            </div>
        @endif
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
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ _method: 'POST' })
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
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ _method: 'POST' })
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
/* Animations */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideDown {
    animation: slideDown 0.5s ease forwards;
}

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
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #c4a030;
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
.group\/btn {
    transition: all 0.2s ease;
}

.group\/btn:hover {
    transform: scale(1.1);
}

/* Empty state icon animation */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.text-white\/10 .fa-flask {
    animation: float 3s ease-in-out infinite;
}

/* Select dropdown custom styling */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

/* Input focus glow */
input:focus, select:focus {
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
}

/* Stats cards hover effect */
.bg-gradient-to-br {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Progress bar animation */
.h-full {
    transition: width 1s ease-in-out;
}

/* Table header sort icons */
th a {
    position: relative;
}

th a:hover i {
    opacity: 1;
}

/* Featured badge pulse */
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid-cols-2 {
        grid-template-columns: 1fr 1fr;
    }
    
    .max-w-7xl {
        padding: 0 1rem;
    }
}
</style>
@endsection