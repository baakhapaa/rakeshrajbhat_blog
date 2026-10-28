<article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
    <div class="relative aspect-video bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden cursor-pointer" onclick="openNewsDetail({{ $item->id }})">
        @if($item->image_url)
            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-newspaper text-5xl text-[#D4AF37]/20"></i>
            </div>
        @endif
        <div class="absolute bottom-3 left-3 z-10">
            <span class="px-2.5 py-1 bg-black/60 backdrop-blur-sm text-white text-[10px] font-medium rounded-full flex items-center gap-1 border border-white/10">
                <i class="fas fa-newspaper text-[8px]"></i>
                {{ $item->source_name ?: 'News' }}
            </span>
        </div>
    </div>
    <div class="p-5">
        <h3 class="text-lg font-serif font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors duration-300 line-clamp-2 cursor-pointer" onclick="openNewsDetail({{ $item->id }})">{{ $item->title }}</h3>
        <p class="text-sm text-[#5a5a52] leading-relaxed line-clamp-2">{{ $item->excerpt }}</p>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <button type="button" onclick="openNewsDetail({{ $item->id }})" class="text-[#D4AF37] text-sm font-medium hover:text-[#c4a030] transition">Read the story →</button>
        </div>
    </div>
</article>
