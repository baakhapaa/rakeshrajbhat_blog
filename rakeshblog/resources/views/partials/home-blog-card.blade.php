<a href="{{ route('blog.show', $blog->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20 block">
    <div class="relative aspect-video bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden">
        @if($blog->featured_image_url)
            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-newspaper text-5xl text-[#D4AF37]/20"></i>
            </div>
        @endif
        <div class="absolute top-3 right-3 z-10">
            <span class="px-2.5 py-1 bg-[#D4AF37] text-[#0b0e12] text-[10px] font-bold rounded-full">Featured</span>
        </div>
        <div class="absolute bottom-3 left-3 z-10">
            <span class="px-2.5 py-1 bg-black/60 backdrop-blur-sm text-white text-[10px] font-medium rounded-full flex items-center gap-1 border border-white/10">
                <i class="fas fa-newspaper text-[8px]"></i>
                Blog
            </span>
        </div>
    </div>
    <div class="p-5">
        <h3 class="text-lg font-serif font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors duration-300 line-clamp-2">{{ $blog->title }}</h3>
        <p class="text-sm text-[#5a5a52] leading-relaxed line-clamp-2">{{ $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content ?? ''), 120) }}</p>
        <div class="mt-4 pt-4 border-t border-gray-100 text-[#D4AF37] text-sm font-medium">Read the story →</div>
    </div>
</a>
