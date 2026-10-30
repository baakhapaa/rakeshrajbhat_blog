@extends('admin.layouts.app')

@section('title', 'News & Updates · Admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
            <i class="fas fa-newspaper text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-serif font-bold text-white">News & Updates</h1>
            <p class="text-gray-400 text-sm mt-0.5">Paste a news link. The story and images are taken from that page and shown on the homepage. Hover a picture to replace it.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-5 py-4 rounded-2xl mb-6">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-5 py-4 rounded-2xl mb-6">{{ session('error') }}</div>
    @endif

    @error('image')
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-5 py-4 rounded-2xl mb-6">{{ $message }}</div>
    @enderror

    <div class="bg-[#1a1f26] rounded-2xl border border-white/5 p-6 mb-6">
        <h2 class="text-xl font-semibold text-white mb-1">Add a news link</h2>
        <p class="text-sm text-gray-400 mb-5">Use the address of one article. The card uses its title, pictures, and story. Opening the card shows them in a box, the same way Vision, Research, and Blog do.</p>
        <form action="{{ route('admin.news.store') }}" method="POST" class="flex flex-col md:flex-row gap-3">
            @csrf
            <input type="url" name="source_url" value="{{ old('source_url') }}" required maxlength="2048" placeholder="https://example.com/news/article" class="flex-1 px-4 py-3 bg-[#0b0e12] border border-white/10 rounded-xl text-white placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none">
            <button type="submit" class="px-6 py-3 bg-[#D4AF37] text-[#0b0e12] rounded-xl font-semibold hover:bg-[#c4a030] transition">Add news</button>
        </form>
        @error('source_url')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="bg-[#1a1f26] rounded-2xl border border-white/5 p-6 mb-6">
        <h2 class="text-xl font-semibold text-white mb-1">Section heading</h2>
        <p class="text-sm text-gray-400 mb-5">This is the title above the news cards on the homepage.</p>
        <form action="{{ route('admin.news.update-section') }}" method="POST" class="grid grid-cols-1 gap-4">
            @csrf
            @method('PUT')
            <div>
                <label for="news_label" class="block text-sm text-white/70 mb-2">Label</label>
                <input id="news_label" type="text" name="label" value="{{ old('label', $section['label']) }}" maxlength="80" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
            </div>
            <div>
                <label for="news_heading" class="block text-sm text-white/70 mb-2">Heading</label>
                <input id="news_heading" type="text" name="heading" value="{{ old('heading', $section['heading']) }}" maxlength="160" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
            </div>
            <div>
                <label for="news_intro" class="block text-sm text-white/70 mb-2">Short paragraph</label>
                <textarea id="news_intro" name="intro" rows="3" maxlength="400" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">{{ old('intro', $section['intro']) }}</textarea>
            </div>
            <div>
                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition">Save heading</button>
            </div>
        </form>
    </div>

    <div class="bg-[#1a1f26] rounded-2xl border border-white/5 overflow-hidden">
        @forelse($items as $item)
            <div class="flex flex-col md:flex-row md:items-center gap-4 p-5 border-b border-white/5 last:border-b-0">
                <div class="group relative w-full md:w-36 h-24 rounded-xl overflow-hidden bg-white/5 flex-shrink-0">
                    @if($item->image_url)
                        <img src="{{ $item->image_url }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[#D4AF37]/40">
                            <i class="fas fa-newspaper text-2xl"></i>
                        </div>
                    @endif
                    <form action="{{ route('admin.news.update-image', $item) }}" method="POST" enctype="multipart/form-data" class="absolute inset-0">
                        @csrf
                        <label class="absolute inset-0 flex cursor-pointer flex-col items-center justify-center gap-1 bg-[#0b0e12]/75 text-white opacity-0 transition-opacity duration-200 group-hover:opacity-100 focus-within:opacity-100">
                            <i class="fas fa-camera text-sm text-[#D4AF37]"></i>
                            <span class="text-[11px] font-semibold tracking-wide">Change image</span>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif" class="sr-only" aria-label="Change image for {{ $item->title }}" onchange="if (this.files.length) this.form.submit()">
                        </label>
                    </form>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-[#D4AF37] uppercase tracking-wider mb-1">{{ $item->source_name ?: 'News' }}</p>
                    <h3 class="text-white font-semibold leading-snug">{{ $item->title }}</h3>
                    <a href="{{ $item->source_url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-gray-500 hover:text-white break-all">{{ $item->source_url }}</a>
                    <form action="{{ route('admin.news.update-category', $item) }}" method="POST" class="mt-3 flex items-center gap-2">
                        @csrf
                        @method('PUT')
                        <label for="news-category-{{ $item->id }}" class="text-xs text-white/50">Category</label>
                        <select id="news-category-{{ $item->id }}" name="category" class="px-3 py-1.5 bg-[#0b0e12] border border-white/10 rounded-lg text-sm text-white focus:border-[#D4AF37] focus:outline-none">
                            <option value="">Uncategorized</option>
                            @foreach(\App\Models\NewsItem::CATEGORIES as $key => $category)
                                <option value="{{ $key }}" @selected($item->category === $key)>{{ $category['filter'] }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-3 py-1.5 text-sm text-white/80 border border-white/10 rounded-lg hover:text-white">Save</button>
                    </form>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.news.refresh', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3 py-2 text-sm text-white/80 border border-white/10 rounded-lg hover:text-white">Refresh</button>
                    </form>
                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove this news item from the homepage?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 text-sm text-red-300 border border-red-500/20 rounded-lg hover:text-red-200">Remove</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="p-6 text-gray-400">No news yet. Paste a link above and it will appear here and on the homepage.</p>
        @endforelse
    </div>
</div>
@endsection
