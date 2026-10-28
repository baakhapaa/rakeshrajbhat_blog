<article class="news-card flex h-full flex-col overflow-hidden rounded-3xl bg-[#fbf9f6] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]">
    <div class="relative h-[233px] overflow-hidden bg-[#eae8e5]">
        @if($item->image_url)
            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="h-full w-full cursor-pointer object-cover" onclick="openNewsDetail({{ $item->id }})">
        @else
            <div class="flex h-full w-full cursor-pointer items-center justify-center" onclick="openNewsDetail({{ $item->id }})">
                <i class="fas fa-newspaper text-5xl text-[#89351d]/20"></i>
            </div>
        @endif
        <div class="absolute left-4 top-4 rounded-full bg-[#fbf9f6]/90 px-3 py-1 backdrop-blur-md">
            <p class="font-grotesk text-[10px] font-bold uppercase leading-[14px] tracking-[1.4px] text-[#89351d]">{{ $item->badgeLabel() }}</p>
        </div>
    </div>
    <div class="flex flex-1 flex-col p-6">
        @if($item->displayDate())
            <p class="font-grotesk text-[10px] font-medium uppercase leading-[14px] tracking-[0.5px] text-[#5f5e5e]">{{ $item->displayDate() }}</p>
        @endif
        <h3 class="mt-[11px] cursor-pointer font-jakarta text-[21px] font-semibold leading-7 text-[#1b1c1a]" onclick="openNewsDetail({{ $item->id }})">{{ $item->title }}</h3>
        @if(filled($item->excerpt))
            <p class="mt-[11px] line-clamp-3 font-jakarta text-sm leading-[21px] text-[#5f5e5e]">{{ $item->excerpt }}</p>
        @endif
        <div class="mt-auto pt-7">
            <button type="button" onclick="openNewsDetail({{ $item->id }})" class="inline-flex items-center gap-2 font-grotesk text-[11px] font-bold uppercase leading-4 tracking-[1.32px] text-[#89351d]">
                <span>Read more</span>
                <img src="{{ asset('images/news-read-arrow.svg') }}" alt="" width="10.6667" height="10.6667">
            </button>
        </div>
    </div>
</article>
