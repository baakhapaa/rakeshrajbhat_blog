@extends('admin.layouts.app')

@section('title', 'Home · Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-serif font-bold text-white mb-2">Home</h1>
    <p class="text-white/50 text-sm mb-6">Edit the hero text, buttons, name, and background on the homepage.</p>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.home-content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Hero text</h2>

            <div class="mb-4">
                <label for="eyebrow" class="block text-white/70 text-sm font-medium mb-2">Eyebrow</label>
                <input type="text" id="eyebrow" name="eyebrow" value="{{ old('eyebrow', $home['eyebrow']) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('eyebrow')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="headline_line_1" class="block text-white/70 text-sm font-medium mb-2">Headline line 1</label>
                <input type="text" id="headline_line_1" name="headline_line_1" value="{{ old('headline_line_1', $home['headline_line_1']) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('headline_line_1')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="headline_line_2" class="block text-white/70 text-sm font-medium mb-2">Headline line 2 <span class="text-white/40">(shown in italic)</span></label>
                <input type="text" id="headline_line_2" name="headline_line_2" value="{{ old('headline_line_2', $home['headline_line_2']) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('headline_line_2')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="headline_line_3" class="block text-white/70 text-sm font-medium mb-2">Headline line 3</label>
                <input type="text" id="headline_line_3" name="headline_line_3" value="{{ old('headline_line_3', $home['headline_line_3']) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('headline_line_3')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="intro" class="block text-white/70 text-sm font-medium mb-2">Intro</label>
                <textarea id="intro" name="intro" rows="4"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('intro', $home['intro']) }}</textarea>
                @error('intro')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Buttons</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="primary_button_label" class="block text-white/70 text-sm font-medium mb-2">Primary button label</label>
                    <input type="text" id="primary_button_label" name="primary_button_label" value="{{ old('primary_button_label', $home['primary_button_label']) }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('primary_button_label')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="primary_button_url" class="block text-white/70 text-sm font-medium mb-2">Primary button link</label>
                    <input type="text" id="primary_button_url" name="primary_button_url" value="{{ old('primary_button_url', $home['primary_button_url']) }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition" placeholder="#projects">
                    @error('primary_button_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="text_link_label" class="block text-white/70 text-sm font-medium mb-2">Text link label</label>
                    <input type="text" id="text_link_label" name="text_link_label" value="{{ old('text_link_label', $home['text_link_label']) }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('text_link_label')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="text_link_url" class="block text-white/70 text-sm font-medium mb-2">Text link destination</label>
                    <input type="text" id="text_link_url" name="text_link_url" value="{{ old('text_link_url', $home['text_link_url']) }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition" placeholder="#about">
                    @error('text_link_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <p class="text-xs text-white/30 mt-3">Links can be a section anchor (#projects), a site path (/blog), or a full http(s) URL. Work With Me stays a fixed button.</p>
        </div>

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Name and tagline</h2>

            <div class="mb-4">
                <label for="name" class="block text-white/70 text-sm font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $home['name']) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tagline" class="block text-white/70 text-sm font-medium mb-2">Tagline</label>
                <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $home['tagline']) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('tagline')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Background image</h2>

            @if($home['background_image'])
                <div class="mb-4">
                    <img src="{{ $home['background_image'] }}" alt="Current hero background" class="h-32 w-auto max-w-full object-cover border border-white/10 rounded-lg">
                </div>
                <label class="flex items-center gap-2 text-sm text-white/70 mb-4">
                    <input type="checkbox" name="remove_background" value="1" class="rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]" {{ old('remove_background') ? 'checked' : '' }}>
                    Remove custom image and use the default photo
                </label>
            @else
                <p class="text-sm text-white/50 mb-4">Using the default photo. Upload a file to replace it.</p>
            @endif

            <input type="file" id="background_image" name="background_image" accept="image/*"
                class="block w-full text-white/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
            <p class="text-xs text-white/30 mt-1">JPG, PNG, WEBP, or SVG. Max 4MB.</p>
            @error('background_image')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
            Save home content
        </button>
    </form>
</div>
@endsection
