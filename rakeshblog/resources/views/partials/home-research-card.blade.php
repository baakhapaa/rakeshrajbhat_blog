<div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
    <div class="relative aspect-video bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden cursor-pointer" onclick="openResearchDetail({{ $item->id }})">
        @if($item->video_url || $item->video_file)
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-center justify-center cursor-pointer z-10 group-hover:bg-black/40 transition-all duration-500" onclick="event.stopPropagation(); playVideo(this, '{{ $item->id }}')">
                <div class="w-14 h-14 bg-[#D4AF37] rounded-full flex items-center justify-center shadow-2xl transform group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
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
                <span class="text-5xl opacity-20">{{ $category['emoji'] }}</span>
            </div>
        @endif

        <div class="absolute top-3 right-3 z-10">
            <span class="px-2.5 py-1 bg-[#D4AF37] text-[#0b0e12] text-[10px] font-bold rounded-full flex items-center gap-1 shadow-lg shadow-[#D4AF37]/20">
                <i class="fas fa-star text-[8px]"></i> Featured
            </span>
        </div>

        <div class="absolute bottom-3 left-3 z-10">
            <span class="px-2.5 py-1 bg-black/60 backdrop-blur-sm text-white text-[10px] font-medium rounded-full flex items-center gap-1 border border-white/10">
                <i class="fas {{ $category['icon'] }} text-[8px]"></i>
                {{ $category['label'] }}
            </span>
        </div>
    </div>

    <div class="p-5">
        <h3 class="text-lg font-serif font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors duration-300 line-clamp-2 cursor-pointer" onclick="openResearchDetail({{ $item->id }})">
            {{ $item->title }}
        </h3>
        <p class="text-sm text-[#5a5a52] leading-relaxed line-clamp-2">{{ $item->description }}</p>
        <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
            <button onclick="openResearchDetail({{ $item->id }})" class="text-[#D4AF37] text-sm font-medium hover:text-[#c4a030] transition flex items-center gap-2 group/btn">
                <span>Read the story</span>
                <span class="group-hover/btn:translate-x-1 transition-transform">→</span>
            </button>
            <div class="flex items-center gap-2">
                @if($item->link_url)
                    <a href="{{ $item->link_url }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-[#D4AF37]/10 flex items-center justify-center text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">
                        <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                @endif
                @if($item->video_url || $item->video_file)
                    <button onclick="event.stopPropagation(); playVideo(this, '{{ $item->id }}')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-[#D4AF37]/10 flex items-center justify-center text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">
                        <i class="fas fa-play text-xs"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
