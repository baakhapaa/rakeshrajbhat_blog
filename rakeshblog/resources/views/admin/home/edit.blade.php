@extends('admin.layouts.app')

@section('title', 'Home · Admin')

@section('content')
@php
    $homeTab = old('_tab', request('tab', 'hero'));
    if (! in_array($homeTab, ['hero', 'about'], true)) {
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
                    <label for="about_heading_line_2" class="block text-white/70 text-sm font-medium mb-2">Heading line 2</label>
                    <input type="text" id="about_heading_line_2" name="about_heading_line_2" value="{{ old('about_heading_line_2', $about['heading_line_2']) }}"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('about_heading_line_2')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="about_paragraph_1" class="block text-white/70 text-sm font-medium mb-2">First paragraph</label>
                <textarea id="about_paragraph_1" name="about_paragraph_1" rows="3"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('about_paragraph_1', $about['paragraph_1']) }}</textarea>
                @error('about_paragraph_1')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="about_paragraph_2" class="block text-white/70 text-sm font-medium mb-2">Second paragraph</label>
                <textarea id="about_paragraph_2" name="about_paragraph_2" rows="5"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('about_paragraph_2', $about['paragraph_2']) }}</textarea>
                @error('about_paragraph_2')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-2">Photo or video</h2>
            <p class="text-sm text-white/40 mb-6">Upload one image or one video. It is stored with the other site media, in the about folder.</p>

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
            <p class="text-xs text-white/30 mt-1">Image up to 5MB, or MP4, WEBM, or MOV up to 100MB. A new upload replaces the current file.</p>
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
</div>

<template id="aboutFactTemplate">
    <div class="about-fact-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
        <input type="text" name="about_fact_title[]" value="" maxlength="80" placeholder="Title" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <input type="text" name="about_fact_caption[]" value="" maxlength="80" placeholder="Caption" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <button type="button" class="remove-about-fact px-3 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
    </div>
</template>

<script>
    function switchHomeTab(tab) {
        const panels = {
            hero: [document.getElementById('heroTab'), document.getElementById('tabHero')],
            about: [document.getElementById('aboutTab'), document.getElementById('tabAbout')],
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
