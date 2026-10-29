@extends('admin.layouts.app')

@section('title', 'Home · Admin')

@section('content')
@php
    $homeTab = old('_tab', request('tab', 'hero'));
    if (! in_array($homeTab, ['hero', 'about', 'mission'], true)) {
        $homeTab = 'hero';
    }
@endphp
<div class="max-w-4xl mx-auto" id="homeEditor" data-home-tab="{{ $homeTab }}">
    <h1 class="text-3xl font-serif font-bold text-white mb-2">Home</h1>
    <p class="text-white/50 text-sm mb-6">Edit each homepage section from its own tab. New sections can be added here later.</p>

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

    <div class="flex flex-wrap gap-2 mb-6 border-b border-white/10">
        <button type="button" onclick="switchHomeTab('hero')" id="tabHero" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $homeTab === 'hero' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            Hero
        </button>
        <button type="button" onclick="switchHomeTab('about')" id="tabAbout" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $homeTab === 'about' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            About me
        </button>
        <button type="button" onclick="switchHomeTab('mission')" id="tabMission" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $homeTab === 'mission' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            Missions
        </button>
    </div>

    <form action="{{ route('admin.home-content.update') }}" method="POST" enctype="multipart/form-data" id="heroTab" class="space-y-6 {{ $homeTab === 'hero' ? '' : 'hidden' }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="_tab" value="hero">

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Hero text</h2>

            <div class="mb-4">
                <label for="eyebrow" class="block text-white/70 text-sm font-medium mb-2">Eyebrow <span class="text-white/40 font-normal">(optional)</span></label>
                <input type="text" id="eyebrow" name="eyebrow" value="{{ old('eyebrow', $home['eyebrow'] ?? '') }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('eyebrow')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="headline_line_1" class="block text-white/70 text-sm font-medium mb-2">Headline line 1 <span class="text-white/40 font-normal">(optional)</span></label>
                <input type="text" id="headline_line_1" name="headline_line_1" value="{{ old('headline_line_1', $home['headline_line_1'] ?? '') }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('headline_line_1')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="headline_line_2" class="block text-white/70 text-sm font-medium mb-2">Headline line 2 <span class="text-white/40 font-normal">(optional, shown in italic)</span></label>
                <input type="text" id="headline_line_2" name="headline_line_2" value="{{ old('headline_line_2', $home['headline_line_2'] ?? '') }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('headline_line_2')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="headline_line_3" class="block text-white/70 text-sm font-medium mb-2">Headline line 3 <span class="text-white/40 font-normal">(optional)</span></label>
                <input type="text" id="headline_line_3" name="headline_line_3" value="{{ old('headline_line_3', $home['headline_line_3'] ?? '') }}"
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
            Save hero
        </button>
    </form>

    <form action="{{ route('admin.home-content.update-about') }}" method="POST" enctype="multipart/form-data" id="aboutTab" class="space-y-6 {{ $homeTab === 'about' ? '' : 'hidden' }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="_tab" value="about">

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">About me</h2>

            <div class="mb-4">
                <label for="about_label" class="block text-white/70 text-sm font-medium mb-2">Eyebrow</label>
                <input type="text" id="about_label" name="about_label" value="{{ old('about_label', $about['label']) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('about_label')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="about_heading_line_1" class="block text-white/70 text-sm font-medium mb-2">Heading line 1</label>
                    <input type="text" id="about_heading_line_1" name="about_heading_line_1" value="{{ old('about_heading_line_1', $about['heading_line_1']) }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('about_heading_line_1')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="about_heading_line_2" class="block text-white/70 text-sm font-medium mb-2">Heading line 2 (optional)</label>
                    <input type="text" id="about_heading_line_2" name="about_heading_line_2" value="{{ old('about_heading_line_2', $about['heading_line_2']) }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('about_heading_line_2')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="about_paragraph_1" class="block text-white/70 text-sm font-medium mb-2">Highlight</label>
                <textarea id="about_paragraph_1" name="about_paragraph_1" rows="3"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('about_paragraph_1', $about['paragraph_1']) }}</textarea>
                @error('about_paragraph_1')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="about_paragraph_2" class="block text-white/70 text-sm font-medium mb-2">Body</label>
                <textarea id="about_paragraph_2" name="about_paragraph_2" rows="5"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('about_paragraph_2', $about['paragraph_2']) }}</textarea>
                @error('about_paragraph_2')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="about_paragraph_3" class="block text-white/70 text-sm font-medium mb-2">Closing paragraph</label>
                <textarea id="about_paragraph_3" name="about_paragraph_3" rows="4"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('about_paragraph_3', $about['paragraph_3'] ?? '') }}</textarea>
                @error('about_paragraph_3')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="about_button_label" class="block text-white/70 text-sm font-medium mb-2">Button label</label>
                    <input type="text" id="about_button_label" name="about_button_label" value="{{ old('about_button_label', $about['button_label'] ?? '') }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('about_button_label')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="about_button_url" class="block text-white/70 text-sm font-medium mb-2">Button link</label>
                    <input type="text" id="about_button_url" name="about_button_url" value="{{ old('about_button_url', $about['button_url'] ?? '#projects') }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('about_button_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-2">Photo or video</h2>
            <p class="text-sm text-white/40 mb-4">Upload one image or one video. It replaces the portrait on the right of the About text.</p>
            <div class="mb-6 rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/70">
                <p class="text-white">Use a portrait, not a wide video. Best size is <span class="text-[#D4AF37]">1500 × 1800</span> pixels (5:6).</p>
                <ul class="mt-2 space-y-1 text-xs text-white/50">
                    <li>Phone: 4:5, for example 1200 × 1500</li>
                    <li>Laptop and desktop: 5:6, for example 1500 × 1800</li>
                    <li>Widest screens: about 1362 × 1476</li>
                </ul>
                <p class="mt-2 text-xs text-white/50">Keep the subject in the center. A 16:9 video is cropped and looks zoomed in this frame.</p>
            </div>

            @if(!empty($about['media_url']))
                <div id="aboutMediaCurrent" class="mb-4">
                    <p class="text-xs text-white/40 mb-2">Current file</p>
                    @if(($about['media_type'] ?? null) === 'video')
                        <video src="{{ $about['media_url'] }}" controls class="max-h-64 w-auto max-w-full rounded-lg border border-white/10"></video>
                    @else
                        <img src="{{ $about['media_url'] }}" alt="Current about media" class="max-h-64 w-auto max-w-full object-cover rounded-lg border border-white/10">
                    @endif
                </div>
                <label class="flex items-center gap-2 text-sm text-white/70 mb-4">
                    <input type="checkbox" name="remove_about_media" value="1" class="rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]" {{ old('remove_about_media') ? 'checked' : '' }}>
                    Remove the current file
                </label>
            @endif

            <div id="aboutMediaPreview" class="mb-4 hidden">
                <p class="text-xs text-white/40 mb-2">Preview</p>
                <img id="aboutMediaPreviewImage" alt="Selected image preview" class="hidden max-h-64 w-auto max-w-full object-cover rounded-lg border border-white/10">
                <video id="aboutMediaPreviewVideo" controls class="hidden max-h-64 w-auto max-w-full rounded-lg border border-white/10"></video>
            </div>

            <input type="file" id="about_media" name="about_media" accept="image/jpeg,image/png,image/gif,image/webp,image/svg+xml,video/mp4,video/webm,video/quicktime"
                class="block w-full text-white/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
            <p class="text-xs text-white/30 mt-1">Image up to 5MB, or MP4, WEBM, or MOV up to 100MB. Videos are compressed for faster loading. A new upload replaces the current file.</p>
            @error('about_media')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        @php
            $aboutFacts = $about['facts'];
            $oldFactTitles = old('about_fact_title');
            if (is_array($oldFactTitles)) {
                $oldFactCaptions = old('about_fact_caption', []);
                $aboutFacts = [];
                foreach ($oldFactTitles as $index => $title) {
                    $aboutFacts[] = [
                        'title' => $title,
                        'caption' => $oldFactCaptions[$index] ?? '',
                    ];
                }
            }
        @endphp
        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-2">Details</h2>
            <p class="text-sm text-white/40 mb-6">Add as many as you need, up to 12. Each one shows as a title with a short caption.</p>

            <div id="aboutFactRows" class="space-y-3">
                @foreach($aboutFacts as $fact)
                    <div class="about-fact-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
                        <input type="text" name="about_fact_title[]" value="{{ $fact['title'] }}" maxlength="80" placeholder="Title" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <input type="text" name="about_fact_caption[]" value="{{ $fact['caption'] }}" maxlength="80" placeholder="Caption" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <button type="button" class="remove-about-fact px-3 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
                    </div>
                @endforeach
            </div>

            @error('about_fact_title')
                <p class="text-red-400 text-sm mt-3">{{ $message }}</p>
            @enderror
            @error('about_fact_title.*')
                <p class="text-red-400 text-sm mt-3">{{ $message }}</p>
            @enderror
            @error('about_fact_caption.*')
                <p class="text-red-400 text-sm mt-3">{{ $message }}</p>
            @enderror

            <button type="button" id="addAboutFact" class="mt-4 px-4 py-2 rounded-lg border border-white/10 text-white/80 hover:text-white">Add detail</button>
        </div>

        <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
            Save about me
        </button>
    </form>

    <form action="{{ route('admin.home-content.update-mission') }}" method="POST" id="missionTab" class="space-y-6 {{ $homeTab === 'mission' ? '' : 'hidden' }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="_tab" value="mission">

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Section</h2>

            <div class="mb-4">
                <label for="mission_label" class="block text-white/70 text-sm font-medium mb-2">Label</label>
                <input type="text" id="mission_label" name="mission_label" value="{{ old('mission_label', $mission['label']) }}" maxlength="80"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('mission_label')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="mission_button_label" class="block text-white/70 text-sm font-medium mb-2">Learn More button label</label>
                <input type="text" id="mission_button_label" name="mission_button_label" value="{{ old('mission_button_label', $mission['button_label']) }}" maxlength="40"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('mission_button_label')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @php
            $missionItems = $mission['items'];
            $oldMissionTitles = old('mission_title');
            if (is_array($oldMissionTitles)) {
                $oldMissionBodies = old('mission_body', []);
                $oldMissionDescriptions = old('mission_description', []);
                $missionItems = [];
                foreach ($oldMissionTitles as $index => $title) {
                    $missionItems[] = [
                        'title' => $title,
                        'body' => $oldMissionBodies[$index] ?? '',
                        'description' => $oldMissionDescriptions[$index] ?? '',
                    ];
                }
            }
        @endphp
        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-2">Mission items</h2>
            <p class="text-sm text-white/40 mb-6">Open one mission at a time to edit it. Use the arrows to change the order shown on the homepage. Add 2 to 12 missions.</p>

            <div id="missionItemRows" class="space-y-3">
                @foreach($missionItems as $index => $item)
                    <div class="mission-item-row rounded-xl border border-white/10 overflow-hidden" data-open="false">
                        <div class="mission-item-header flex flex-wrap items-center gap-2 px-4 py-3 bg-white/[0.03]">
                            <button type="button" class="mission-item-toggle flex min-w-0 flex-1 items-center gap-3 text-left">
                                <i class="fa-solid fa-chevron-down mission-item-chevron text-xs text-white/40 transition-transform" aria-hidden="true"></i>
                                <span class="shrink-0 text-sm font-medium text-[#D4AF37]">Mission <span class="mission-item-number">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span></span>
                                <span class="mission-item-summary truncate text-sm text-white/70">{{ $item['title'] !== '' ? $item['title'] : 'Untitled mission' }}</span>
                            </button>
                            <div class="flex items-center gap-1">
                                <button type="button" class="mission-item-up inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 hover:text-white hover:border-white/20" aria-label="Move mission up" title="Move up">
                                    <i class="fa-solid fa-arrow-up text-xs" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="mission-item-down inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 hover:text-white hover:border-white/20" aria-label="Move mission down" title="Move down">
                                    <i class="fa-solid fa-arrow-down text-xs" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="remove-mission-item px-3 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
                            </div>
                        </div>
                        <div class="mission-item-body hidden space-y-3 border-t border-white/10 px-4 py-4">
                            <div>
                                <label class="block text-white/70 text-sm font-medium mb-2">Title</label>
                                <input type="text" name="mission_title[]" value="{{ $item['title'] }}" maxlength="80" placeholder="Title" class="mission-item-title w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-white/70 text-sm font-medium mb-2">Short description</label>
                                <textarea name="mission_body[]" rows="4" maxlength="90" placeholder="Shown on the homepage dial" class="mission-item-body-input min-h-[6.5rem] w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">{{ $item['body'] }}</textarea>
                                <p class="mt-1 text-xs text-white/40">Keep this short for the dial. Best around <span class="text-white/60">60 characters</span>. Maximum <span class="text-white/60">90 characters</span> so it still fits on phones. Longer text belongs in the long description. <span class="mission-body-count text-white/50">0/90</span></p>
                            </div>
                            <div>
                                <label class="block text-white/70 text-sm font-medium mb-2">Long description</label>
                                <p class="mb-2 text-xs text-white/40">Style headings, bold text, lists, and colours. Use the image button to add multiple photos for the Learn More modal.</p>
                                <textarea id="mission_description_{{ $index }}" name="mission_description[]" rows="8" class="mission-item-description w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">{{ $item['description'] }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @error('mission_title')
                <p class="text-red-400 text-sm mt-3">{{ $message }}</p>
            @enderror
            @error('mission_title.*')
                <p class="text-red-400 text-sm mt-3">{{ $message }}</p>
            @enderror
            @error('mission_body.*')
                <p class="text-red-400 text-sm mt-3">{{ $message }}</p>
            @enderror
            @error('mission_description.*')
                <p class="text-red-400 text-sm mt-3">{{ $message }}</p>
            @enderror

            <button type="button" id="addMissionItem" class="mt-4 px-4 py-2 rounded-lg border border-white/10 text-white/80 hover:text-white">Add mission</button>
        </div>

        <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
            Save missions
        </button>
    </form>
</div>

<template id="aboutFactTemplate">
    <div class="about-fact-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
        <input type="text" name="about_fact_title[]" value="" maxlength="80" placeholder="Title" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <input type="text" name="about_fact_caption[]" value="" maxlength="80" placeholder="Caption" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <button type="button" class="remove-about-fact px-3 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
    </div>
</template>

<template id="missionItemTemplate">
    <div class="mission-item-row rounded-xl border border-white/10 overflow-hidden" data-open="false">
        <div class="mission-item-header flex flex-wrap items-center gap-2 px-4 py-3 bg-white/[0.03]">
            <button type="button" class="mission-item-toggle flex min-w-0 flex-1 items-center gap-3 text-left">
                <i class="fa-solid fa-chevron-down mission-item-chevron text-xs text-white/40 transition-transform" aria-hidden="true"></i>
                <span class="shrink-0 text-sm font-medium text-[#D4AF37]">Mission <span class="mission-item-number">01</span></span>
                <span class="mission-item-summary truncate text-sm text-white/70">Untitled mission</span>
            </button>
            <div class="flex items-center gap-1">
                <button type="button" class="mission-item-up inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 hover:text-white hover:border-white/20" aria-label="Move mission up" title="Move up">
                    <i class="fa-solid fa-arrow-up text-xs" aria-hidden="true"></i>
                </button>
                <button type="button" class="mission-item-down inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/60 hover:text-white hover:border-white/20" aria-label="Move mission down" title="Move down">
                    <i class="fa-solid fa-arrow-down text-xs" aria-hidden="true"></i>
                </button>
                <button type="button" class="remove-mission-item px-3 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
            </div>
        </div>
        <div class="mission-item-body hidden space-y-3 border-t border-white/10 px-4 py-4">
            <div>
                <label class="block text-white/70 text-sm font-medium mb-2">Title</label>
                <input type="text" name="mission_title[]" value="" maxlength="80" placeholder="Title" class="mission-item-title w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
            </div>
            <div>
                <label class="block text-white/70 text-sm font-medium mb-2">Short description</label>
                <textarea name="mission_body[]" rows="4" maxlength="90" placeholder="Shown on the homepage dial" class="mission-item-body-input min-h-[6.5rem] w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none"></textarea>
                <p class="mt-1 text-xs text-white/40">Keep this short for the dial. Best around <span class="text-white/60">60 characters</span>. Maximum <span class="text-white/60">90 characters</span> so it still fits on phones. Longer text belongs in the long description. <span class="mission-body-count text-white/50">0/90</span></p>
            </div>
            <div>
                <label class="block text-white/70 text-sm font-medium mb-2">Long description</label>
                <p class="mb-2 text-xs text-white/40">Style headings, bold text, lists, and colours. Use the image button to add multiple photos for the Learn More modal.</p>
                <textarea id="mission_description_new" name="mission_description[]" rows="8" class="mission-item-description w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
    function switchHomeTab(tab) {
        const panels = {
            hero: [document.getElementById('heroTab'), document.getElementById('tabHero')],
            about: [document.getElementById('aboutTab'), document.getElementById('tabAbout')],
            mission: [document.getElementById('missionTab'), document.getElementById('tabMission')],
        };

        Object.values(panels).forEach(function (pair) {
            pair[0].classList.add('hidden');
            pair[1].classList.remove('border-[#D4AF37]', 'text-[#D4AF37]');
            pair[1].classList.add('border-transparent', 'text-white/60');
        });

        if (!panels[tab]) {
            tab = 'hero';
        }

        panels[tab][0].classList.remove('hidden');
        panels[tab][1].classList.add('border-[#D4AF37]', 'text-[#D4AF37]');
        panels[tab][1].classList.remove('border-transparent', 'text-white/60');

        const url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        history.replaceState({}, '', url);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const editor = document.getElementById('homeEditor');
        switchHomeTab(editor ? editor.dataset.homeTab : 'hero');

        const factRows = document.getElementById('aboutFactRows');
        const factTemplate = document.getElementById('aboutFactTemplate');

        function bindFactRow(row) {
            row.querySelector('.remove-about-fact').addEventListener('click', function () {
                if (factRows.querySelectorAll('.about-fact-row').length === 1) {
                    return;
                }
                row.remove();
            });
        }

        factRows.querySelectorAll('.about-fact-row').forEach(bindFactRow);

        document.getElementById('addAboutFact').addEventListener('click', function () {
            if (factRows.querySelectorAll('.about-fact-row').length >= 12) {
                return;
            }
            const row = factTemplate.content.firstElementChild.cloneNode(true);
            factRows.appendChild(row);
            bindFactRow(row);
        });

        const missionRows = document.getElementById('missionItemRows');
        const missionTemplate = document.getElementById('missionItemTemplate');
        const missionForm = document.getElementById('missionTab');
        const missionUploadUrl = @json(route('admin.upload-image'));
        const missionCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            || document.querySelector('input[name="_token"]')?.value
            || '';
        let missionEditorSeq = 0;
        const hasMissionErrors = {{ ($errors->has('mission_title') || $errors->has('mission_title.*') || $errors->has('mission_body.*') || $errors->has('mission_description.*')) ? 'true' : 'false' }};

        function updateMissionSummary(row) {
            const titleInput = row.querySelector('.mission-item-title');
            const summary = row.querySelector('.mission-item-summary');
            if (!titleInput || !summary) {
                return;
            }
            const value = titleInput.value.trim();
            summary.textContent = value !== '' ? value : 'Untitled mission';
        }

        function updateMissionBodyCount(row) {
            const bodyInput = row.querySelector('.mission-item-body-input');
            const count = row.querySelector('.mission-body-count');
            if (!bodyInput || !count) {
                return;
            }
            count.textContent = bodyInput.value.length + '/90';
        }

        function missionDescriptionField(row) {
            return row.querySelector('.mission-item-description');
        }

        function saveMissionEditor(row) {
            const field = missionDescriptionField(row);
            if (!field || typeof tinymce === 'undefined') {
                return;
            }
            const editor = tinymce.get(field.id);
            if (editor) {
                editor.save();
            }
        }

        function destroyMissionEditor(row) {
            const field = missionDescriptionField(row);
            if (!field || typeof tinymce === 'undefined') {
                return;
            }
            const editor = tinymce.get(field.id);
            if (editor) {
                editor.save();
                editor.remove();
            }
        }

        function ensureMissionDescriptionId(row) {
            const field = missionDescriptionField(row);
            if (!field) {
                return null;
            }
            if (!field.id || field.id === 'mission_description_new' || document.querySelectorAll('#' + CSS.escape(field.id)).length > 1) {
                missionEditorSeq += 1;
                field.id = 'mission_description_' + Date.now() + '_' + missionEditorSeq;
            }
            return field;
        }

        function initMissionEditor(row) {
            if (typeof tinymce === 'undefined') {
                return;
            }
            const field = ensureMissionDescriptionId(row);
            if (!field || tinymce.get(field.id)) {
                return;
            }

            tinymce.init({
                target: field,
                base_url: 'https://cdn.jsdelivr.net/npm/tinymce@8.8.2',
                suffix: '.min',
                license_key: 'gpl',
                width: '100%',
                height: 360,
                menubar: false,
                branding: false,
                promotion: false,
                skin: 'oxide-dark',
                toolbar_mode: 'wrap',
                plugins: 'lists link image',
                toolbar: 'blocks | bold italic underline strikethrough | fontsize forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image blockquote | undo redo',
                block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4',
                font_size_formats: '14px 16px 18px 20px 24px 28px',
                automatic_uploads: true,
                images_reuse_filename: false,
                images_upload_handler: function (blobInfo) {
                    return new Promise(function (resolve, reject) {
                        const formData = new FormData();
                        formData.append('image', blobInfo.blob(), blobInfo.filename());
                        formData.append('folder', 'mission');

                        fetch(missionUploadUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': missionCsrf,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        })
                            .then(function (response) {
                                return response.json().then(function (data) {
                                    if (!response.ok || !data.success || !data.path) {
                                        throw new Error(data.message || 'Image upload failed');
                                    }
                                    return data.path;
                                });
                            })
                            .then(resolve)
                            .catch(function (error) {
                                reject(error.message || 'Image upload failed');
                            });
                    });
                },
                content_style: [
                    'body { background:#1a1f26; color:#e5e7eb; font-family: Inter, Helvetica, Arial, sans-serif; font-size:16px; line-height:1.65; margin:1rem; }',
                    'h2,h3,h4 { color:#f8fafc; font-weight:700; line-height:1.25; margin:0.85em 0 0.4em; }',
                    'h2 { font-size:1.5rem; } h3 { font-size:1.25rem; } h4 { font-size:1.1rem; }',
                    'a { color:#D4AF37; }',
                    'ul,ol { padding-left:1.4rem; }',
                    'blockquote { border-left:3px solid #D4AF37; margin-left:0; padding-left:1rem; color:#d1d5db; }',
                    'img { max-width:100%; height:auto; border-radius:12px; margin:0.85rem 0; display:block; }'
                ].join(' '),
            });
        }

        function setMissionOpen(row, open) {
            const body = row.querySelector('.mission-item-body');
            const chevron = row.querySelector('.mission-item-chevron');
            row.dataset.open = open ? 'true' : 'false';
            if (body) {
                body.classList.toggle('hidden', !open);
            }
            if (chevron) {
                chevron.classList.toggle('rotate-180', open);
            }
            if (open) {
                initMissionEditor(row);
            } else {
                destroyMissionEditor(row);
            }
        }

        function closeAllMissions(except) {
            missionRows.querySelectorAll('.mission-item-row').forEach(function (row) {
                if (row !== except) {
                    setMissionOpen(row, false);
                }
            });
        }

        function renumberMissionRows() {
            const rows = missionRows.querySelectorAll('.mission-item-row');
            rows.forEach(function (row, index) {
                const label = row.querySelector('.mission-item-number');
                if (label) {
                    label.textContent = String(index + 1).padStart(2, '0');
                }
                const up = row.querySelector('.mission-item-up');
                const down = row.querySelector('.mission-item-down');
                if (up) {
                    up.disabled = index === 0;
                    up.classList.toggle('opacity-30', index === 0);
                    up.classList.toggle('pointer-events-none', index === 0);
                }
                if (down) {
                    down.disabled = index === rows.length - 1;
                    down.classList.toggle('opacity-30', index === rows.length - 1);
                    down.classList.toggle('pointer-events-none', index === rows.length - 1);
                }
            });
        }

        function bindMissionRow(row) {
            const toggle = row.querySelector('.mission-item-toggle');
            const titleInput = row.querySelector('.mission-item-title');
            const up = row.querySelector('.mission-item-up');
            const down = row.querySelector('.mission-item-down');
            const remove = row.querySelector('.remove-mission-item');

            toggle.addEventListener('click', function () {
                const willOpen = row.dataset.open !== 'true';
                closeAllMissions(row);
                setMissionOpen(row, willOpen);
            });

            titleInput.addEventListener('input', function () {
                updateMissionSummary(row);
            });

            const bodyInput = row.querySelector('.mission-item-body-input');
            if (bodyInput) {
                bodyInput.addEventListener('input', function () {
                    updateMissionBodyCount(row);
                });
            }

            up.addEventListener('click', function () {
                const wasOpen = row.dataset.open === 'true';
                destroyMissionEditor(row);
                const previous = row.previousElementSibling;
                if (!previous) {
                    return;
                }
                missionRows.insertBefore(row, previous);
                renumberMissionRows();
                if (wasOpen) {
                    setMissionOpen(row, true);
                }
            });

            down.addEventListener('click', function () {
                const wasOpen = row.dataset.open === 'true';
                destroyMissionEditor(row);
                const next = row.nextElementSibling;
                if (!next) {
                    return;
                }
                missionRows.insertBefore(next, row);
                renumberMissionRows();
                if (wasOpen) {
                    setMissionOpen(row, true);
                }
            });

            remove.addEventListener('click', function () {
                if (missionRows.querySelectorAll('.mission-item-row').length <= 2) {
                    return;
                }
                destroyMissionEditor(row);
                row.remove();
                renumberMissionRows();
            });

            updateMissionSummary(row);
            updateMissionBodyCount(row);
            setMissionOpen(row, false);
        }

        missionRows.querySelectorAll('.mission-item-row').forEach(bindMissionRow);
        renumberMissionRows();

        if (hasMissionErrors) {
            const firstRow = missionRows.querySelector('.mission-item-row');
            if (firstRow) {
                setMissionOpen(firstRow, true);
            }
        }

        document.getElementById('addMissionItem').addEventListener('click', function () {
            if (missionRows.querySelectorAll('.mission-item-row').length >= 12) {
                return;
            }
            const row = missionTemplate.content.firstElementChild.cloneNode(true);
            missionRows.appendChild(row);
            ensureMissionDescriptionId(row);
            bindMissionRow(row);
            renumberMissionRows();
            closeAllMissions(row);
            setMissionOpen(row, true);
            const titleInput = row.querySelector('.mission-item-title');
            if (titleInput) {
                titleInput.focus();
            }
        });

        if (missionForm) {
            missionForm.addEventListener('submit', function () {
                missionRows.querySelectorAll('.mission-item-row').forEach(saveMissionEditor);
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }
            });
        }

        const mediaInput = document.getElementById('about_media');
        const mediaPreview = document.getElementById('aboutMediaPreview');
        const previewImage = document.getElementById('aboutMediaPreviewImage');
        const previewVideo = document.getElementById('aboutMediaPreviewVideo');
        const currentMedia = document.getElementById('aboutMediaCurrent');
        let previewUrl = null;

        mediaInput.addEventListener('change', function () {
            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
                previewUrl = null;
            }

            previewImage.classList.add('hidden');
            previewVideo.classList.add('hidden');
            previewImage.removeAttribute('src');
            previewVideo.removeAttribute('src');
            previewVideo.load();

            const file = mediaInput.files && mediaInput.files[0];
            if (!file) {
                mediaPreview.classList.add('hidden');
                if (currentMedia) {
                    currentMedia.classList.remove('hidden');
                }
                return;
            }

            previewUrl = URL.createObjectURL(file);
            const isVideo = file.type.startsWith('video/') || /\.(mp4|webm|mov)$/i.test(file.name);
            const target = isVideo ? previewVideo : previewImage;
            target.src = previewUrl;
            target.classList.remove('hidden');
            mediaPreview.classList.remove('hidden');
            if (currentMedia) {
                currentMedia.classList.add('hidden');
            }
        });
    });
</script>
@endsection
