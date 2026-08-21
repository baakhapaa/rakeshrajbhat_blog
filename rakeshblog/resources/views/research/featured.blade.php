@extends('layouts.app')

@section('title', 'Research & Resources · Rakesh Rajbhat')

@section('content')
<section class="py-20 md:py-28 bg-gradient-to-b from-[#f8f6f1] to-[#f2efe8]">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm border border-[#D4AF37]/10 mb-5">
                <i class="fas fa-sparkles text-[#D4AF37] text-sm"></i>
                <span class="text-xs font-medium text-[#8a8a82] tracking-widest uppercase">Knowledge Hub</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold text-[#1e1e1a] leading-tight">
                All Research &amp; <br class="hidden sm:block">
                <span class="text-[#D4AF37]">Resources</span>
            </h1>
            <p class="text-[#5a5a52] mt-4 text-lg leading-relaxed max-w-2xl mx-auto">
                Explore ideas, frameworks, and stories from the ground — 
                <span class="text-[#1e1e1a] font-medium">shaping Nepal's future together.</span>
            </p>
        </div>

        <!-- Stats Bar -->
        @php
            $totalItems = 0;
            foreach($featuredResearch as $items) {
                $totalItems += $items->count();
            }
        @endphp
        <div class="flex flex-wrap justify-center gap-6 mb-12">
            <div class="text-center">
                <span class="text-2xl font-bold text-[#1e1e1a]">{{ $totalItems }}</span>
                <p class="text-xs text-[#8a8a82]">Total Resources</p>
            </div>
            @foreach($featuredResearch as $category => $items)
                <div class="text-center px-4 border-l border-gray-200">
                    <span class="text-2xl font-bold text-[#1e1e1a]">{{ $items->count() }}</span>
                    <p class="text-xs text-[#8a8a82]">{{ $category }}</p>
                </div>
            @endforeach
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-2 md:gap-3 mb-12">
            <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 bg-[#D4AF37] text-[#0b0e12] shadow-lg shadow-[#D4AF37]/20 hover:shadow-[#D4AF37]/30" data-filter="all">
                <i class="fas fa-th-list mr-2"></i> All
            </button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 bg-white/70 text-[#4a4a42] hover:bg-[#D4AF37] hover:text-[#0b0e12] hover:shadow-lg hover:shadow-[#D4AF37]/20" data-filter="Vision">
                <i class="fas fa-eye mr-2"></i> Vision
            </button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 bg-white/70 text-[#4a4a42] hover:bg-[#D4AF37] hover:text-[#0b0e12] hover:shadow-lg hover:shadow-[#D4AF37]/20" data-filter="Research Papers">
                <i class="fas fa-book mr-2"></i> Research
            </button>
            <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 bg-white/70 text-[#4a4a42] hover:bg-[#D4AF37] hover:text-[#0b0e12] hover:shadow-lg hover:shadow-[#D4AF37]/20" data-filter="Media">
                <i class="fas fa-video mr-2"></i> Media
            </button>
        </div>

        <!-- Research Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8" id="researchGrid">
            @forelse($featuredResearch as $category => $items)
                @foreach($items as $item)
                    <div class="research-card group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1.5 border border-gray-100/60 hover:border-[#D4AF37]/20" data-category="{{ $category }}">
                        
                        <!-- Card Image -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100 cursor-pointer" onclick="openResearchDetail({{ $item->id }})">
                            @if($item->video_url || $item->video_file)
                                <!-- Video Play Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-center justify-center z-10 group-hover:bg-black/40 transition-all duration-500" onclick="event.stopPropagation(); playVideo(this, '{{ $item->id }}')">
                                    <div class="w-14 h-14 bg-[#D4AF37] rounded-full flex items-center justify-center shadow-2xl transform group-hover:scale-110 group-hover:shadow-[#D4AF37]/30 transition-all duration-300">
                                        <i class="fas fa-play text-white text-xl ml-1"></i>
                                    </div>
                                </div>
                                @if($item->video_file)
                                    <video class="w-full h-full object-cover" preload="metadata">
                                        <source src="{{ $item->video_file }}#t=0.1" type="video/mp4">
                                    </video>
                                @elseif($item->video_url)
                                    <img src="{{ $item->video_thumbnail ?: $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @endif
                            @elseif($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#D4AF37]/5 to-[#D4AF37]/10">
                                    <i class="fas 
                                        @if($category == 'Vision') fa-eye
                                        @elseif($category == 'Research Papers') fa-book-open
                                        @else fa-film
                                        @endif 
                                        text-6xl text-[#D4AF37]/20"></i>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute bottom-3 left-3 z-10">
                                <span class="px-3 py-1.5 bg-black/60 backdrop-blur-sm text-white text-[11px] font-medium rounded-full flex items-center gap-1.5 border border-white/10">
                                    <i class="fas 
                                        @if($category == 'Vision') fa-eye
                                        @elseif($category == 'Research Papers') fa-book
                                        @else fa-video
                                        @endif 
                                        text-[10px]"></i>
                                    {{ $category }}
                                </span>
                            </div>

                            <!-- Featured Badge -->
                            @if($item->is_featured)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="px-2.5 py-1 bg-[#D4AF37] text-[#0b0e12] text-[10px] font-bold rounded-full flex items-center gap-1 shadow-lg shadow-[#D4AF37]/20">
                                        <i class="fas fa-star text-[9px]"></i> Featured
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs text-[#8a8a82] flex items-center gap-1">
                                    <i class="far fa-calendar-alt text-[10px]"></i>
                                    {{ $item->created_at ? $item->created_at->format('M d, Y') : 'Recent' }}
                                </span>
                                <span class="w-1 h-1 rounded-full bg-[#8a8a82]/30"></span>
                                <span class="text-xs text-[#8a8a82] flex items-center gap-1">
                                    <i class="far fa-clock text-[10px]"></i>
                                    {{ rand(3, 8) }} min read
                                </span>
                                @if($item->is_featured)
                                    <span class="ml-auto text-[10px] text-[#D4AF37] font-medium">
                                        <i class="fas fa-star text-[8px]"></i> Featured
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-serif font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors duration-300 line-clamp-2 cursor-pointer" onclick="openResearchDetail({{ $item->id }})">
                                {{ $item->title }}
                            </h3>

                            <p class="text-sm text-[#5a5a52] leading-relaxed line-clamp-2">
                                {{ $item->description }}
                            </p>

                            <div class="mt-4 pt-4 border-t border-gray-100/80 flex items-center justify-between">
                                <button onclick="openResearchDetail({{ $item->id }})" 
                                        class="text-[#D4AF37] text-sm font-medium hover:text-[#c4a030] transition flex items-center gap-2 group/btn">
                                    <span>Read story</span>
                                    <i class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                                </button>
                                
                                <div class="flex items-center gap-1.5">
                                    @if($item->link_url)
                                        <a href="{{ $item->link_url }}" target="_blank" rel="noopener noreferrer" 
                                           class="w-8 h-8 rounded-full bg-gray-100/70 hover:bg-[#D4AF37]/10 flex items-center justify-center text-[#8a8a82] hover:text-[#D4AF37] transition-all duration-300 hover:scale-110" 
                                           title="Visit link">
                                            <i class="fas fa-external-link-alt text-xs"></i>
                                        </a>
                                    @endif
                                    @if($item->video_url || $item->video_file)
                                        <button onclick="event.stopPropagation(); playVideo(this, '{{ $item->id }}')" 
                                                class="w-8 h-8 rounded-full bg-gray-100/70 hover:bg-[#D4AF37]/10 flex items-center justify-center text-[#8a8a82] hover:text-[#D4AF37] transition-all duration-300 hover:scale-110" 
                                                title="Watch video">
                                            <i class="fas fa-play text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="col-span-3 text-center py-16">
                    <div class="w-24 h-24 rounded-full bg-white/80 flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <i class="fas fa-flask text-4xl text-[#D4AF37]/30"></i>
                    </div>
                    <p class="text-lg font-medium text-[#1e1e1a]">No research items yet</p>
                    <p class="text-sm text-[#8a8a82] mt-1">Check back soon for new stories and insights.</p>
                </div>
            @endforelse
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-16">
            <a href="{{ route('home') }}#research" 
               class="inline-flex items-center gap-2 text-[#8a8a82] hover:text-[#D4AF37] transition font-medium">
                <i class="fas fa-arrow-left text-xs"></i>
                Back to Home
            </a>
            <p class="text-xs text-[#8a8a82] mt-2 flex items-center justify-center gap-2">
                <i class="fas fa-heart text-[#D4AF37] text-[10px]"></i>
                Made with care for Nepal's future
                <i class="fas fa-heart text-[#D4AF37] text-[10px]"></i>
            </p>
        </div>
    </div>
</section>

<!-- Research Detail Modal -->
<div id="researchModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeResearchDetail()"></div>
        <div class="relative bg-white rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <button onclick="closeResearchDetail()" class="sticky top-4 right-4 float-right z-10 text-[#8a8a82] hover:text-[#D4AF37] bg-white/95 backdrop-blur-sm rounded-full p-2.5 shadow-lg transition-all duration-300 hover:scale-110 ml-4 border border-gray-100/80">
                <i class="fas fa-times text-lg"></i>
            </button>

            <div class="px-6 md:px-8 pb-8 pt-4" id="researchDetailContent">
                <div class="text-center py-12">
                    <div class="inline-block">
                        <i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i>
                    </div>
                    <p class="mt-3 text-[#8a8a82]">Loading story...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeVideoModal()"></div>
    <div class="relative max-w-4xl w-full bg-black rounded-2xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
        <button onclick="closeVideoModal()" class="absolute top-4 right-4 z-10 text-white/70 hover:text-[#D4AF37] bg-black/50 rounded-full p-2 transition-all duration-300 hover:scale-110">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div id="videoContainer" class="aspect-video">
            <!-- Video will be loaded here -->
        </div>
    </div>
</div>

<script>
// Category Filter
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const researchCards = document.querySelectorAll('.research-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-[#D4AF37]', 'text-[#0b0e12]', 'shadow-lg', 'shadow-[#D4AF37]/20');
                btn.classList.add('bg-white/70', 'text-[#4a4a42]');
            });
            this.classList.remove('bg-white/70', 'text-[#4a4a42]');
            this.classList.add('bg-[#D4AF37]', 'text-[#0b0e12]', 'shadow-lg', 'shadow-[#D4AF37]/20');

            const filter = this.dataset.filter;

            researchCards.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
});

// Open Research Detail
function openResearchDetail(id) {
    const modal = document.getElementById('researchModal');
    const content = document.getElementById('researchDetailContent');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    content.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block">
                <i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i>
            </div>
            <p class="mt-3 text-[#8a8a82]">Loading story...</p>
        </div>
    `;

    fetch(`/research/${id}/detail`)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const item = data.data;
                const categoryIcons = {
                    'Vision': 'fa-eye',
                    'Research Papers': 'fa-book',
                    'Media': 'fa-video'
                };
                const categoryColors = {
                    'Vision': 'bg-amber-50 text-amber-700 border-amber-200',
                    'Research Papers': 'bg-blue-50 text-blue-700 border-blue-200',
                    'Media': 'bg-purple-50 text-purple-700 border-purple-200'
                };

                const escapeHtml = (str) => {
                    if (!str) return '';
                    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                };

                content.innerHTML = `
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <span class="px-3 py-1.5 rounded-full text-xs font-medium inline-flex items-center gap-1.5 border
                            ${categoryColors[item.category] || 'bg-gray-50 text-gray-700 border-gray-200'}">
                            <i class="fas ${categoryIcons[item.category] || 'fa-file-alt'} text-[10px]"></i>
                            ${escapeHtml(item.category)}
                        </span>
                        ${item.is_featured ? '<span class="px-3 py-1.5 bg-[#D4AF37]/10 text-[#D4AF37] text-xs font-medium rounded-full flex items-center gap-1 border border-[#D4AF37]/20"><i class="fas fa-star text-[9px]"></i> Featured</span>' : ''}
                        ${item.created_at ? `<span class="text-xs text-[#8a8a82] flex items-center gap-1"><i class="far fa-calendar-alt text-[10px]"></i> ${new Date(item.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</span>` : ''}
                    </div>

                    <h2 class="text-2xl md:text-3xl font-serif font-bold text-[#1e1e1a] mb-4 leading-tight">${escapeHtml(item.title)}</h2>

                    ${item.image_url ? `
                        <div class="mb-6 rounded-2xl overflow-hidden shadow-md">
                            <img src="${item.image_url}" alt="${escapeHtml(item.title)}" class="w-full max-h-80 object-cover">
                        </div>
                    ` : ''}

                    ${item.video_url || item.video_file ? `
                        <div class="mb-6 rounded-2xl overflow-hidden bg-black shadow-md">
                            ${item.video_file ? 
                                `<video controls class="w-full h-full"><source src="${item.video_file}" type="video/mp4">Your browser does not support the video tag.</video>` :
                                item.video_embed_url ? 
                                `<iframe src="${item.video_embed_url}" class="w-full h-full aspect-video" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>` :
                                `<div class="w-full h-full aspect-video flex items-center justify-center text-white"><p>No video available</p></div>`
                            }
                        </div>
                    ` : ''}

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-[#8a8a82] uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="w-8 h-0.5 bg-[#D4AF37]"></span>
                            About
                        </h4>
                        <p class="text-[#3a3a34] leading-relaxed text-base">${escapeHtml(item.description)}</p>
                    </div>

                    ${item.content ? `
                        <div class="mb-5">
                            <h4 class="text-xs font-semibold text-[#8a8a82] uppercase tracking-wider mb-2 flex items-center gap-2">
                                <span class="w-8 h-0.5 bg-[#D4AF37]"></span>
                                Full Story
                            </h4>
                            <div class="text-[#3a3a34] leading-relaxed whitespace-pre-wrap prose prose-sm max-w-none">${escapeHtml(item.content)}</div>
                        </div>
                    ` : ''}

                    ${item.link_url ? `
                        <div class="mt-5 pt-4 border-t border-gray-100">
                            <a href="${item.link_url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] hover:text-[#c4a030] transition font-medium">
                                <i class="fas fa-external-link-alt text-xs"></i>
                                Visit Link
                            </a>
                        </div>
                    ` : ''}
                `;
            } else {
                content.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-exclamation-circle text-5xl text-[#D4AF37]/30 mb-4"></i>
                        <p class="text-[#5a5a52]">${data.message || 'Could not load this story'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-triangle text-5xl text-[#D4AF37]/30 mb-4"></i>
                    <p class="text-[#5a5a52]">Oops! Something went wrong.</p>
                    <p class="text-sm text-[#8a8a82] mt-1">Please try again later.</p>
                </div>
            `;
        });
}

function closeResearchDetail() {
    const modal = document.getElementById('researchModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function playVideo(element, researchId) {
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');
    
    container.innerHTML = `
        <div class="w-full h-full flex items-center justify-center text-white">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin text-4xl text-[#D4AF37]"></i>
                <p class="mt-2 text-gray-400 text-sm">Loading video...</p>
            </div>
        </div>
    `;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    fetch(`/research/${researchId}/video`)
        .then(response => response.json())
        .then(data => {
            if (data.video_file) {
                container.innerHTML = `
                    <video controls autoplay class="w-full h-full">
                        <source src="${data.video_file}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                `;
            } else if (data.video_embed_url) {
                container.innerHTML = `
                    <iframe src="${data.video_embed_url}" class="w-full h-full" allowfullscreen></iframe>
                `;
            } else {
                container.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center text-white">
                        <div class="text-center">
                            <i class="fas fa-video text-4xl opacity-20"></i>
                            <p class="mt-2">No video available</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading video:', error);
            container.innerHTML = `
                <div class="w-full h-full flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="fas fa-exclamation-circle text-4xl text-red-400"></i>
                        <p class="mt-2">Error loading video</p>
                    </div>
                </div>
            `;
        });
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');
    modal.classList.add('hidden');
    container.innerHTML = '';
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeResearchDetail();
        closeVideoModal();
    }
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.research-card {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.research-card:nth-child(1) { animation-delay: 0.05s; }
.research-card:nth-child(2) { animation-delay: 0.1s; }
.research-card:nth-child(3) { animation-delay: 0.15s; }
.research-card:nth-child(4) { animation-delay: 0.2s; }
.research-card:nth-child(5) { animation-delay: 0.25s; }
.research-card:nth-child(6) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#researchModal {
    animation: fadeIn 0.25s ease;
}

#videoModal {
    animation: fadeIn 0.25s ease;
}

#researchModal .relative {
    animation: scaleIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes scaleIn {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

#researchDetailContent::-webkit-scrollbar {
    width: 5px;
}

#researchDetailContent::-webkit-scrollbar-track {
    background: #f5f5f5;
    border-radius: 10px;
}

#researchDetailContent::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 10px;
}

#researchDetailContent::-webkit-scrollbar-thumb:hover {
    background: #c4a030;
}

.filter-btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.filter-btn:hover {
    transform: translateY(-2px);
}

.prose {
    font-size: 1rem;
    line-height: 1.75;
    color: #3a3a34;
}

.prose p {
    margin-bottom: 1rem;
}

.fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection