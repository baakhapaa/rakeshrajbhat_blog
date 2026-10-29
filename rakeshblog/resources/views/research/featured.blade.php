@extends('layouts.app')

@section('title', 'Research & Resources · Rakesh Rajbhat')

@section('content')
@php
    $featuredPage = \App\Models\Setting::getResearchFeaturedPage();
    $categoryOrder = collect($featuredPage['filters'])->pluck('key')->flip();
    $featuredResearch = collect($featuredResearch)->sortBy(function ($items, $category) use ($categoryOrder) {
        return $categoryOrder->has($category) ? $categoryOrder[$category] : 100;
    });
@endphp
<section class="library-page">
    <div class="library-wrap">
        <div class="text-center">
            <div class="site-kicker center">
                <span aria-hidden="true"></span>
                <p>Studies</p>
            </div>
            <h1>
                {{ $featuredPage['title_line'] }}
                @if($featuredPage['title_accent'] !== '')
                    <br>{{ $featuredPage['title_accent'] }}
                @endif
            </h1>
            <p class="library-lead">{{ $featuredPage['paragraph'] }}</p>
        </div>

        <div class="library-pills">
            @foreach($featuredPage['filters'] as $filter)
                @if($filter['key'] === 'blog')
                    <a href="{{ route('blog') }}" class="library-pill">{{ $filter['label'] }}</a>
                @else
                    <button type="button" class="library-pill filter-btn {{ $filter['key'] === 'all' ? 'is-active' : '' }}" data-filter="{{ $filter['key'] }}">{{ $filter['label'] }}</button>
                @endif
            @endforeach
        </div>

        <div class="library-grid cols-3" id="researchGrid">
            @forelse($featuredResearch as $category => $items)
                @foreach($items as $item)
                    @php
                        $cardLabel = match ($category) {
                            'Research Papers' => 'Research',
                            default => $category,
                        };
                        $cardText = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($item->description ?: $item->content ?: ''))));
                    @endphp
                    <article class="library-card research-card" data-category="{{ $category }}">
                        <div class="library-media" @unless($item->video_url || $item->video_file) onclick="openResearchDetail({{ $item->id }})" @endunless>
                            <p class="library-chip">{{ $cardLabel }}</p>
                            @if($item->is_featured)
                                <span class="library-flag">Featured</span>
                            @endif
                            @if($item->video_url || $item->video_file)
                                <button type="button" class="library-play" onclick="playVideo(this, '{{ $item->id }}')" aria-label="Play {{ $item->title }}">
                                    <span aria-hidden="true"><i class="fas fa-play"></i></span>
                                </button>
                                @if($item->video_file)
                                    <video muted playsinline preload="metadata">
                                        <source src="{{ $item->video_file }}#t=0.1" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ $item->video_thumbnail ?: $item->image_url }}" alt="{{ $item->title }}">
                                @endif
                            @elseif($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                            @endif
                        </div>
                        <div class="library-body">
                            <p class="library-date">{{ $item->created_at ? strtoupper($item->created_at->format('M d, Y')) : 'Recent' }}</p>
                            <h3 onclick="openResearchDetail({{ $item->id }})" style="cursor:pointer">{{ $item->title }}</h3>
                            @if($cardText !== '')
                                <p class="library-excerpt">{{ $cardText }}</p>
                            @endif
                            <div class="library-actions">
                                <button type="button" class="library-read" onclick="openResearchDetail({{ $item->id }})">
                                    Read more
                                    <img src="{{ asset('images/studies/read-more-arrow.svg') }}" alt="" width="10.6667" height="10.6667">
                                </button>
                                <span>
                                    @if($item->link_url)
                                        <a href="{{ $item->link_url }}" target="_blank" rel="noopener noreferrer" class="library-icon" title="Visit link">
                                            <i class="fas fa-external-link-alt text-xs"></i>
                                        </a>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            @empty
                <div class="library-empty">
                    <p>No research items yet. Check back soon for new stories and insights.</p>
                </div>
            @endforelse
        </div>

        <div class="library-back">
            <a href="{{ route('home') }}#research">Back to home</a>
        </div>
    </div>
</section>

<!-- Research Detail Modal -->
<div id="researchModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeResearchDetail()"></div>
        <div class="relative research-modal-panel max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <button type="button" onclick="closeResearchDetail()" class="research-close" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>

            <div id="researchDetailContent">
                <div class="text-center py-12">
                    <div class="inline-block">
                        <i class="fas fa-spinner fa-spin text-3xl" style="color:#b36855"></i>
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
            filterButtons.forEach(btn => btn.classList.remove('is-active'));
            this.classList.add('is-active');

            const filter = this.dataset.filter;

            researchCards.forEach(card => {
                const show = filter === 'all' || card.dataset.category === filter;
                card.classList.toggle('is-hidden', !show);
                if (show) {
                    card.style.display = '';
                    card.style.opacity = '1';
                    card.style.transform = 'none';
                } else {
                    card.style.display = 'none';
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
                const escapeHtml = (str) => {
                    if (!str) return '';
                    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                };

                const formatResearchContent = (value) => {
                    if (!value) return '';
                    if (!/<\/?[a-z][\s\S]*>/i.test(value)) {
                        return `<div class="research-detail-copy" style="white-space:pre-wrap">${escapeHtml(value)}</div>`;
                    }
                    return `<div class="research-detail-copy research-rich">${value}</div>`;
                };

                const categoryLabel = item.category === 'Research Papers' ? 'Research' : (item.category || '');
                const storyDate = item.created_at ? new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).toUpperCase() : '';

                content.innerHTML = `
                    <div class="research-detail">
                        <h2 class="research-detail-title">${escapeHtml(item.title)}</h2>
                        ${item.image_url ? `<div class="research-detail-media"><img src="${item.image_url}" alt="${escapeHtml(item.title)}"></div>` : ''}
                        ${item.video_url || item.video_file ? `
                            <div class="research-detail-media">
                                ${item.video_file ?
                                    `<video controls class="w-full"><source src="${item.video_file}" type="video/mp4"></video>` :
                                    item.video_embed_url ?
                                    `<iframe src="${item.video_embed_url}" class="w-full aspect-video" allowfullscreen></iframe>` :
                                    `<div class="aspect-video flex items-center justify-center text-white">No video available</div>`
                                }
                            </div>
                        ` : ''}
                        <div class="research-detail-meta">
                            ${categoryLabel ? `<span class="research-chip">${escapeHtml(categoryLabel)}</span>` : ''}
                            ${item.is_featured ? '<span class="research-chip">Featured</span>' : ''}
                            ${storyDate ? `<span class="library-date">${storyDate}</span>` : ''}
                        </div>
                        <div class="research-block">
                            <h4 class="research-kicker"><span></span>About</h4>
                            <p class="research-detail-copy">${escapeHtml(item.description || '')}</p>
                        </div>
                        ${item.content ? `
                            <div class="research-block">
                                <h4 class="research-kicker"><span></span>Full story</h4>
                                ${formatResearchContent(item.content)}
                            </div>
                        ` : ''}
                        ${item.link_url ? `<div class="research-link"><a class="library-cta" href="${item.link_url}" target="_blank" rel="noopener noreferrer">Visit link</a></div>` : ''}
                    </div>
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
    background: #b36855;
    border-radius: 10px;
}

#researchDetailContent::-webkit-scrollbar-thumb:hover {
    background: #89351d;
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