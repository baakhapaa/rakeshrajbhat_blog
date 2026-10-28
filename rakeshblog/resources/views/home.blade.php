@extends('layouts.app')

@section('title', 'Rakesh Rajbhat · Portfolio')

@section('title', 'Rakesh Rajbhat | Technology Entrepreneur & Youth Development Builder')
@section('meta_description', 'Official website of Rakesh Rajbhat, founder of Baakhapaa and builder of Skill Sikka, Hillychilly, Future Builders and AI & ICT programs in Nepal.')

@section('content')
    @php
        $homeContent = $homeContent ?? \App\Models\Setting::getHomeContent();
        $aboutContent = \App\Models\Setting::getAboutContent();
    @endphp
    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen pt-20 flex items-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img
                src="{{ $homeContent['background_image'] ?: asset('images/rakeshrajbhat.jpg') }}"
                alt="{{ $homeContent['name'] }}"
                class="w-full h-full object-cover opacity-50 saturate-[1.1]"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0e12] via-[#0b0e12]/70 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-end">
                <div>
                    <p class="text-[#D4AF37] tracking-[0.25em] text-xs font-bold mb-4 uppercase">{{ $homeContent['eyebrow'] }}</p>
                    <h1 class="text-5xl lg:text-7xl font-serif leading-[1.1] mb-8 text-balance text-white">
                        {{ $homeContent['headline_line_1'] }} <br/>
                        <span class="italic">{{ $homeContent['headline_line_2'] }}</span><br/>
                        {{ $homeContent['headline_line_3'] }}
                    </h1>
                    <p class="text-gray-300 text-lg max-w-lg mb-10 leading-relaxed">
                        {{ $homeContent['intro'] }}
                    </p>
                    <div class="flex flex-wrap items-center gap-6">
                        <a href="{{ \App\Models\Setting::linkHref($homeContent['primary_button_url']) }}" @if(str_starts_with($homeContent['primary_button_url'], 'http')) target="_blank" rel="noopener noreferrer" @endif class="bg-[#D4AF37] text-[#0b0e12] px-8 py-3 font-bold text-sm tracking-wide rounded-sm hover:brightness-110 transition-all shadow-lg shadow-[#D4AF37]/20">
                            {{ $homeContent['primary_button_label'] }}
                        </a>
                        <button type="button" data-open-work="education" class="notranslate inline-flex border border-[#D4AF37] text-[#D4AF37] px-8 py-3 font-bold text-sm tracking-wide rounded-sm hover:bg-[#D4AF37] hover:text-[#0b0e12] transition-all" translate="no">
                            Work With Me
                        </button>
                        <a href="{{ \App\Models\Setting::linkHref($homeContent['text_link_url']) }}" @if(str_starts_with($homeContent['text_link_url'], 'http')) target="_blank" rel="noopener noreferrer" @endif class="text-[#D4AF37] text-sm font-bold flex items-center gap-2 group">
                            {{ $homeContent['text_link_label'] }} <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                </div>
                <div class="lg:text-right pb-4">
                    <div class="font-serif italic text-5xl lg:text-7xl mb-2 drop-shadow-lg text-[#D4AF37]">{{ $homeContent['name'] }}</div>
                    <p class="text-xs tracking-[0.35em] font-medium text-white/70 uppercase">{{ $homeContent['tagline'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Me -->
    <section id="about-me" class="py-24 bg-white text-[#1e1e1a] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                <div class="lg:col-span-5">
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-5 uppercase">{{ $aboutContent['label'] }}</p>
                    <h2 class="text-5xl lg:text-6xl font-serif font-bold leading-[1.05]">
                        {{ $aboutContent['heading_line_1'] }}<br>{{ $aboutContent['heading_line_2'] }}
                    </h2>
                </div>
                <div class="lg:col-span-7">
                    <div class="max-w-lg lg:pt-2">
                        <div class="space-y-6 text-[#3a3a34] leading-relaxed">
                            <p>{{ $aboutContent['paragraph_1'] }}</p>
                            <p>{{ $aboutContent['paragraph_2'] }}</p>
                        </div>
                        @if(!empty($aboutContent['facts']))
                            <div class="mt-10 grid grid-cols-2 gap-x-8 gap-y-6">
                                @foreach($aboutContent['facts'] as $fact)
                                    <div>
                                        <p class="font-bold text-[#1e1e1a]">{{ $fact['title'] }}</p>
                                        <p class="text-sm text-[#6a6a62] mt-1">{{ $fact['caption'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About/Mission Section -->
    <section id="about" class="py-24 bg-[#f2f2f2] text-[#1e1e1a] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                <div class="lg:col-span-5">
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-4 uppercase">My Mission</p>
                    <h2 class="text-4xl font-serif font-bold mb-6 leading-tight">I believe in building systems that create lasting impact.</h2>
                    <p class="text-[#3a3a34] mb-8 leading-relaxed">
                        I grew up in Nepal. Studied Civil Engineering. Worked in Texas. Explored the world. And I returned home with a simple belief – that we can build a better future for our people with the right knowledge, technology and opportunities.
                    </p>
                    <blockquote class="border-l-4 border-[#D4AF37] pl-6 py-2 italic text-xl text-[#2a2a24]">
                        "I am not in politics to play politics. <br/> I am here to build opportunities."
                    </blockquote>
                </div>
                <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                    <div class="flex gap-4">
                        <div class="text-[#D4AF37] shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Education</h4>
                            <p class="text-sm text-[#4a4a42]">Making learning practical, accessible and future-ready.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-[#D4AF37] shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Youth Empowerment</h4>
                            <p class="text-sm text-[#4a4a42]">Equipping young minds with skills, confidence and purpose.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-[#D4AF37] shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Technology</h4>
                            <p class="text-sm text-[#4a4a42]">Using technology to solve real problems in communities.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-[#D4AF37] shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Local Economy</h4>
                            <p class="text-sm text-[#4a4a42]">Creating opportunities that strengthen local communities.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-[#D4AF37] shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Sustainability</h4>
                            <p class="text-sm text-[#4a4a42]">Building projects that respect nature and culture.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-[#D4AF37] shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Nation First</h4>
                            <p class="text-sm text-[#4a4a42]">Every step I take is for Nepal and her future.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-28 bg-[#fff6e0] scroll-mt-20 overflow-visible">
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 mb-8">
            <div class="flex justify-between items-end">
                <div>
                    @php
                        $projectsSection = \App\Models\Setting::getProjectsSection();
                    @endphp
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">{{ $projectsSection['label'] }}</p>
                    <h2 class="text-4xl font-serif font-bold text-[#1e1e1a]">{{ $projectsSection['title'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Infinite Carousel Outer Container -->
        <div class="carousel-container relative w-full py-16">
            <!-- Scrolling Track -->
            <div class="carousel-track flex items-center gap-8 w-max">

                {{-- FIRST SET --}}
                @forelse($projects ?? [] as $project)
                    <div class="tooltip-container w-[300px] shrink-0 bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all">
                        <!-- Normal Card Content -->
                        <div class="project-default w-full flex flex-col items-center">
                            <div class="project-image w-20 h-20 rounded-full flex items-center justify-center mb-5 overflow-hidden border-2 border-[#D4AF37]/20 bg-white">
                                @if($project->image)
                                    <img src="{{ $project->image_url }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background-color: {{ $project->color ?? '#D4AF37' }}20;">
                                        <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                    </div>
                                @endif
                            </div>
                            <h4 class="font-bold text-[#1e1e1a] mb-2 text-lg"> {{ $project->name }} </h4>
                            <p class="text-xs text-gray-600 mb-4 flex-grow line-clamp-2"> {{ $project->short_description ?? 'Hover to learn more' }} </p>
                            <span class="text-[#D4AF37] text-xs font-bold flex items-center gap-1"> Learn More →</span>
                        </div>

                        <!-- Popup Content -->
                        <div class="tooltip-popup">
                            <div class="project-popup-content flex flex-col justify-between h-full">
                                <div>
                                    <div class="popup-image">
                                        @if($project->image)
                                            <img src="{{ $project->image_url }}" alt="{{ $project->name }}">
                                        @else
                                            <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                        @endif
                                    </div>
                                    <h5 class="font-bold text-xl text-[#1e1e1a] mb-2"> {{ $project->name }} </h5>

                                    <p class="text-sm text-gray-700 leading-relaxed max-h-[140px] overflow-y-auto pr-1">
                                        {{ $project->description ?? $project->long_description ?? $project->short_description }}
                                    </p>
                                </div>

                                @if($project->url)
                                    <div class="pt-4 mt-2 border-t border-gray-100">
                                        <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] font-semibold text-sm hover:underline">
                                            Visit Website <span>→</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No projects available yet.</p>
                @endforelse

                {{-- Only one project set is rendered so the homepage DOM remains unique. --}}
                @if(false)
                @foreach($projects ?? [] as $project)
                    <div class="tooltip-container w-[300px] shrink-0 bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all">
                        <!-- Normal Card Content -->
                        <div class="project-default w-full flex flex-col items-center">
                            <div class="project-image w-20 h-20 rounded-full flex items-center justify-center mb-5 overflow-hidden border-2 border-[#D4AF37]/20 bg-white">
                                @if($project->image)
                                    <img src="{{ $project->image_url }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background-color: {{ $project->color ?? '#D4AF37' }}20;">
                                        <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                    </div>
                                @endif
                            </div>
                            <h4 class="font-bold text-[#1e1e1a] mb-2 text-lg"> {{ $project->name }} </h4>
                            <p class="text-xs text-gray-600 mb-4 flex-grow line-clamp-2"> {{ $project->short_description ?? 'Hover to learn more' }} </p>
                            <span class="text-[#D4AF37] text-xs font-bold flex items-center gap-1"> Learn More →</span>
                        </div>

                        <!-- Popup Content -->
                        <div class="tooltip-popup">
                            <div class="project-popup-content flex flex-col justify-between h-full">
                                <div>
                                    <div class="popup-image">
                                        @if($project->image)
                                            <img src="{{ $project->image_url }}" alt="{{ $project->name }}">
                                        @else
                                            <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                        @endif
                                    </div>
                                    <h5 class="font-bold text-xl text-[#1e1e1a] mb-2"> {{ $project->name }} </h5>

                                    <p class="text-sm text-gray-700 leading-relaxed max-h-[140px] overflow-y-auto pr-1">
                                        {{ $project->description ?? $project->long_description ?? $project->short_description }}
                                    </p>
                                </div>

                                @if($project->url)
                                    <div class="pt-4 mt-2 border-t border-gray-100">
                                        <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] font-semibold text-sm hover:underline">
                                            Visit Website <span>→</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Impact Stats -->
    <section id="impact" class="py-20 bg-[#0c1016] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12">
                <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">What I've done so far</p>
                <h2 class="text-4xl font-serif font-bold text-white/95">Turning Ideas Into Impact</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 border border-white/5 rounded-xl overflow-hidden divide-y divide-white/5 sm:divide-y-0 sm:divide-x divide-white/5">
                @forelse($stats ?? [] as $stat)
                    @php
                        $number = trim((string) $stat->number);
                        preg_match('/^([0-9]+(?:\\.[0-9]+)?)(.*)$/', $number, $numberParts);
                        $numericValue = $numberParts[1] ?? '0';
                        $numberSuffix = trim($numberParts[2] ?? '');
                    @endphp
                    <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] {{ $loop->last ? '' : 'border-b border-white/5 sm:border-b-0' }} stat-item">
                        @if($stat->icon)
                            <i class="{{ $stat->icon }} h-8 w-8 text-[#D4AF37] mb-4" aria-hidden="true"></i>
                        @else
                            <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 3v18h18M7 16l3-4 3 2 5-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                            </svg>
                        @endif
                        <div class="text-4xl font-serif font-bold text-white mb-1">
                            <span class="counter" data-target="{{ $numericValue }}">
                                    {{ $numericValue }}
                    </span>@if($numberSuffix) <span class="text-4xl text-white">{{ $numberSuffix }}</span>@endif
                        </div>
                        <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">
                            {{ $stat->label }}@if($stat->sub_label)<br/>{{ $stat->sub_label }}@endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center text-gray-400 stat-item">No impact stats available.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Research Section -->
<section id="research" class="py-24 bg-gradient-to-b from-[#f2efe8] to-[#faf8f5] text-[#1e1e1a] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Section Title -->
        @php
            $researchSection = \App\Models\Setting::getResearchSection();
        @endphp
        <div class="text-center mb-10">
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#1e1e1a] leading-tight">{{ $researchSection['title'] }}</h2>
            <p class="text-[#5a5a52] mt-4 max-w-2xl mx-auto text-lg leading-relaxed">{{ $researchSection['paragraph'] }}</p>
        </div>

        <div class="mb-12 flex flex-wrap items-center justify-center gap-3" id="researchFilters">
            <button type="button" data-research-filter="all" class="research-pill inline-flex items-center gap-2 rounded-full bg-[#D4AF37] px-4 py-2 text-sm font-semibold text-[#1e1e1a] shadow-sm transition" aria-pressed="true">
                <i class="fa-solid fa-table-cells text-[#1e1e1a]" aria-hidden="true"></i>
                All
            </button>
            <button type="button" data-research-filter="vision" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-eye text-[#D4AF37]" aria-hidden="true"></i>
                Vision
            </button>
            <button type="button" data-research-filter="research" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-file-lines text-[#D4AF37]" aria-hidden="true"></i>
                Research
            </button>
            <button type="button" data-research-filter="media" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-video text-[#D4AF37]" aria-hidden="true"></i>
                Media
            </button>
            <button type="button" data-research-filter="blog" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-newspaper text-[#D4AF37]" aria-hidden="true"></i>
                Blog
            </button>
        </div>

        @php
            $categories = [
                'vision' => [
                    'label' => 'Vision for Nepal',
                    'icon' => 'fa-eye',
                    'emoji' => '🌟',
                    'description' => 'Big ideas for a better tomorrow',
                ],
                'research' => [
                    'label' => 'Research & Papers',
                    'icon' => 'fa-book',
                    'emoji' => '📚',
                    'description' => 'Evidence-based insights',
                ],
                'media' => [
                    'label' => 'Media & Stories',
                    'icon' => 'fa-video',
                    'emoji' => '🎬',
                    'description' => 'Inspiring stories from the field',
                ],
                'blog' => [
                    'label' => 'Blog',
                    'icon' => 'fa-newspaper',
                    'emoji' => '📰',
                    'description' => 'Three featured stories',
                ],
            ];
            $homeBlogs = isset($featuredBlogs) ? $featuredBlogs->take(3) : collect();
            $spotlightResearch = $spotlightResearch ?? collect();
        @endphp

        <div data-research-panel="all" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach(['vision', 'research'] as $key)
                @php $category = $categories[$key]; @endphp
                <div class="space-y-5">
                    @include('partials.home-study-heading', ['category' => $category])
                    @if(isset($spotlightResearch[$key]) && $spotlightResearch[$key]->isNotEmpty())
                        @include('partials.home-research-card', ['item' => $spotlightResearch[$key]->first(), 'category' => $category])
                    @else
                        <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                            <p class="text-sm text-[#5a5a52] font-medium">No featured item yet</p>
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="space-y-5">
                @include('partials.home-study-heading', ['category' => $categories['blog']])
                @if($homeBlogs->isNotEmpty())
                    @include('partials.home-blog-card', ['blog' => $homeBlogs->first()])
                @else
                    <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                        <p class="text-sm text-[#5a5a52] font-medium">No featured blogs yet</p>
                    </div>
                @endif
            </div>
        </div>

        @foreach(['vision', 'research', 'media'] as $key)
            @php $category = $categories[$key]; @endphp
            <div data-research-panel="{{ $key }}" class="hidden">
                <div class="mb-5">
                    @include('partials.home-study-heading', ['category' => $category])
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @if(isset($featuredResearch[$key]) && $featuredResearch[$key]->isNotEmpty())
                        @foreach($featuredResearch[$key]->take(3) as $item)
                            @include('partials.home-research-card', ['item' => $item, 'category' => $category])
                        @endforeach
                    @else
                        <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                            <p class="text-sm text-[#5a5a52] font-medium">Nothing added to home yet</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div data-research-panel="blog" class="hidden">
            <div class="mb-5">
                @include('partials.home-study-heading', ['category' => $categories['blog']])
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @forelse($homeBlogs as $blog)
                    @include('partials.home-blog-card', ['blog' => $blog])
                @empty
                    <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                        <p class="text-sm text-[#5a5a52] font-medium">No featured blogs yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-16">
            <a href="{{ route('research.featured') }}"
                class="inline-flex items-center gap-3 px-8 py-3.5 bg-gradient-to-r from-[#D4AF37] to-[#c4a030] text-[#0b0e12] font-medium rounded-2xl hover:shadow-xl hover:shadow-[#D4AF37]/25 transition-all duration-300 hover:-translate-y-0.5 group">
                    <span>Explore All Research</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
            <p class="text-xs text-[#8a8a82] mt-3">Discover insights, stories, and ideas that inspire change</p>
        </div>
    </div>
    <script>
        document.querySelectorAll('[data-research-filter]').forEach(function (button) {
            button.addEventListener('click', function () {
                const filter = button.getAttribute('data-research-filter');
                document.querySelectorAll('[data-research-filter]').forEach(function (item) {
                    const active = item === button;
                    item.classList.toggle('bg-[#D4AF37]', active);
                    item.classList.toggle('text-[#1e1e1a]', active);
                    item.classList.toggle('bg-white', !active);
                    item.classList.toggle('text-[#4a4a42]', !active);
                    item.setAttribute('aria-pressed', active ? 'true' : 'false');
                    const icon = item.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('text-[#1e1e1a]', active);
                        icon.classList.toggle('text-[#D4AF37]', !active);
                    }
                });
                document.querySelectorAll('[data-research-panel]').forEach(function (panel) {
                    panel.classList.toggle('hidden', panel.getAttribute('data-research-panel') !== filter);
                });
            });
        });
    </script>
</section>

<!-- Research Detail Modal -->
<div id="researchModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeResearchDetail()"></div>
        <div class="relative bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button onclick="closeResearchDetail()" class="sticky top-4 right-4 float-right z-10 text-gray-400 hover:text-[#D4AF37] bg-white/95 backdrop-blur-sm rounded-full p-2.5 shadow-lg transition-all duration-300 hover:scale-110 ml-4 border border-gray-100">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Content -->
            <div class="px-8 pb-8 pt-4" id="researchDetailContent">
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
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeVideoModal()"></div>
    <div class="relative max-w-4xl w-full bg-black rounded-2xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
        <button onclick="closeVideoModal()" class="absolute top-4 right-4 z-10 text-white hover:text-[#D4AF37] bg-black/50 rounded-full p-2 transition-all duration-300 hover:scale-110">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div id="videoContainer" class="aspect-video">
            <!-- Video will be loaded here -->
        </div>
    </div>
</div>

<script>
function openResearchDetail(id) {
    const modal = document.getElementById('researchModal');
    const content = document.getElementById('researchDetailContent');

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = '0px';

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
                const categoryEmojis = {
                    'Vision': '🌟',
                    'Research Papers': '📚',
                    'Media': '🎬'
                };

                const escapeHtml = (str) => {
                    if (!str) return '';
                    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                };

                const formatResearchContent = (value) => {
                    if (!value) return '';
                    if (!/<\/?[a-z][\s\S]*>/i.test(value)) {
                        return `<div class="text-[#3a3a34] leading-relaxed whitespace-pre-wrap">${escapeHtml(value)}</div>`;
                    }
                    return `<div class="text-[#3a3a34] leading-relaxed [&_h2]:mb-2 [&_h2]:font-serif [&_h2]:text-2xl [&_h2]:font-bold [&_h3]:mb-2 [&_h3]:text-xl [&_h3]:font-bold [&_p]:mb-3 [&_strong]:font-bold [&_ul]:mb-3 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:mb-3 [&_ol]:list-decimal [&_ol]:pl-5">${value}</div>`;
                };

                content.innerHTML = `
                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 border
                            ${categoryColors[item.category] || 'bg-gray-50 text-gray-700 border-gray-200'}">
                            <span>${categoryEmojis[item.category] || '📄'}</span>
                            ${escapeHtml(item.category)}
                        </span>
                        ${item.is_featured ? '<span class="px-3 py-1.5 bg-[#D4AF37]/10 text-[#D4AF37] text-xs font-semibold rounded-full flex items-center gap-1 border border-[#D4AF37]/20"><i class="fas fa-star text-[10px]"></i> Featured</span>' : ''}
                        ${item.created_at ? `<span class="text-xs text-[#8a8a82] flex items-center gap-1"><i class="far fa-calendar-alt"></i> ${new Date(item.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</span>` : ''}
                    </div>

                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#1e1e1a] mb-4 leading-tight">${escapeHtml(item.title)}</h2>

                    ${item.image_url ? `
                        <div class="mb-6 rounded-2xl overflow-hidden shadow-md">
                            <img src="${item.image_url}" alt="${escapeHtml(item.title)}" class="w-full max-h-96 object-cover">
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

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-[#8a8a82] uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="w-6 h-0.5 bg-[#D4AF37]"></span>
                            About
                        </h4>
                        <p class="text-[#3a3a34] leading-relaxed text-base">${escapeHtml(item.description)}</p>
                    </div>

                    ${item.content ? `
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-[#8a8a82] uppercase tracking-wider mb-2 flex items-center gap-2">
                                <span class="w-6 h-0.5 bg-[#D4AF37]"></span>
                                Full Story
                            </h4>
                            ${formatResearchContent(item.content)}
                        </div>
                    ` : ''}

                    ${item.link_url ? `
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <a href="${item.link_url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] hover:text-[#c4a030] transition font-medium">
                                <i class="fas fa-external-link-alt"></i>
                                Visit Link
                            </a>
                        </div>
                    ` : ''}
                `;
            } else {
                content.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">😕</div>
                        <p class="text-[#5a5a52]">${data.message || 'Failed to load research details'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-12">
                    <div class="text-5xl mb-4">😕</div>
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
                            <p>No video available</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading video:', error);
            container.innerHTML = `
                <div class="w-full h-full flex items-center justify-center text-white">
                    <p>Error loading video. Please try again.</p>
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

#videoModal {
    animation: fadeIn 0.25s ease;
}

#researchModal {
    animation: fadeIn 0.3s ease;
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
    width: 6px;
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

/* Prose styling for content */
.prose {
    font-size: 1rem;
    line-height: 1.75;
    color: #3a3a34;
}

.prose p {
    margin-bottom: 1rem;
}

/* Hover effects */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

/* Smooth transitions */
.transition-all {
    transition-duration: 300ms;
}
</style>

    {{-- FEATURED BLOGS SECTION
    <section id="featured-blogs" class="py-24 bg-[#fff6e0] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
                <div>
                    <h2 class="text-4xl font-serif font-bold text-[#1e1e1a]">Featured Blogs</h2>
                    <p class="text-[#3a3a34] mt-2 max-w-lg">Explore insights, stories, and ideas from my journey.</p>
                </div>
            </div>

            @if(isset($featuredBlogs) && $featuredBlogs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredBlogs as $blog)
                        <a href="{{ route('blog.show', $blog->slug) }}"
                        class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative overflow-hidden h-52">
                                @if($blog->featured_image_url)
                                    <img src="{{ $blog->featured_image_url }}"
                                        alt="{{ $blog->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-[#D4AF37]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 bg-[#D4AF37] text-[#0b0e12] text-xs font-bold rounded-full">
                                        Featured
                                    </span>
                                </div>
                                @if($blog->category)
                                    <div class="absolute bottom-3 left-3">
                                        <span class="px-3 py-1 bg-black/60 text-white text-xs font-medium rounded-full backdrop-blur-sm">
                                            {{ $blog->category }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                    <span>{{ $blog->short_date }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-13h-2v6l5.25 3.15L17 12.23l-4-2.37V7z"/>
                                        </svg>
                                        {{ $blog->reading_time ?? '5 min read' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors line-clamp-2">
                                    {{ $blog->title }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content ?? ''), 120) }}
                                </p>
                                <div class="mt-4 flex items-center gap-2 text-sm text-[#D4AF37] font-medium">
                                    Read More
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('blog') }}"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-[#D4AF37] text-[#0b0e12] font-bold rounded-lg hover:bg-[#c4a030] transition-all shadow-lg shadow-[#D4AF37]/20 hover:shadow-[#D4AF37]/40 hover:-translate-y-0.5">
                        View All Blogs
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-white/50 rounded-xl">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                    </svg>
                    <p class="text-gray-500">No featured blogs yet. Check back soon!</p>
                </div>
            @endif
        </div>
    </section>
    --}}

    <section id="news" class="py-24 bg-gradient-to-b from-[#f2efe8] to-[#faf8f5] text-[#1e1e1a] scroll-mt-20">
        @php
            $newsContent = \App\Models\Setting::getNewsContent();
            $newsItems = $newsItems ?? collect();
        @endphp
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-3 uppercase">{{ $newsContent['label'] }}</p>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#1e1e1a] leading-tight">{{ $newsContent['heading'] }}</h2>
                <p class="text-[#5a5a52] mt-4 max-w-2xl mx-auto text-lg leading-relaxed">{{ $newsContent['intro'] }}</p>
            </div>

            @if($newsItems->isNotEmpty())
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @foreach($newsItems as $item)
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
                    @endforeach
                </div>
            @else
                <p class="text-center text-sm text-[#8a8a82]">News will appear here once a link is added.</p>
            @endif
        </div>
    </section>

    <div id="newsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="min-h-screen px-4 py-8 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeNewsDetail()"></div>
            <div class="relative bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
                <button type="button" onclick="closeNewsDetail()" class="sticky top-4 right-4 float-right z-10 text-gray-400 hover:text-[#D4AF37] bg-white/95 backdrop-blur-sm rounded-full p-2.5 shadow-lg transition-all duration-300 hover:scale-110 ml-4 border border-gray-100">
                    <i class="fas fa-times text-lg"></i>
                </button>
                <div class="px-8 pb-8 pt-4" id="newsDetailContent">
                    <div class="text-center py-12">
                        <i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i>
                        <p class="mt-3 text-[#8a8a82]">Loading story...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openNewsDetail(id) {
            const modal = document.getElementById('newsModal');
            const content = document.getElementById('newsDetailContent');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            content.innerHTML = '<div class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i><p class="mt-3 text-[#8a8a82]">Loading story...</p></div>';

            fetch('/news/' + id + '/detail')
                .then(function (response) {
                    if (!response.ok) throw new Error('Unable to load news');
                    return response.json();
                })
                .then(function (payload) {
                    const item = payload.data || {};
                    const escapeHtml = function (value) {
                        return String(value || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                    };
                    const mainImage = item.image_url || (Array.isArray(item.images) ? item.images[0] : '');
                    const date = item.published_at ? new Date(item.published_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : '';

                    content.innerHTML = `
                        <div class="flex items-center gap-3 mb-4 flex-wrap">
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 border bg-amber-50 text-amber-700 border-amber-200">
                                <i class="fas fa-newspaper text-[10px]"></i>
                                ${escapeHtml(item.source_name || 'News')}
                            </span>
                            ${date ? '<span class="text-xs text-[#8a8a82]"><i class="far fa-calendar-alt"></i> ' + escapeHtml(date) + '</span>' : ''}
                        </div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#1e1e1a] mb-4 leading-tight">${escapeHtml(item.title)}</h2>
                        ${mainImage ? '<div class="mb-6 overflow-hidden rounded-2xl"><img src="' + escapeHtml(mainImage) + '" alt="' + escapeHtml(item.title) + '" class="block w-full aspect-video object-cover object-center"></div>' : ''}
                        ${item.excerpt ? '<p class="text-[#3a3a34] leading-relaxed text-base mb-6">' + escapeHtml(item.excerpt) + '</p>' : ''}
                        ${item.content ? '<div class="text-[#3a3a34] leading-relaxed [&_h3]:mb-2 [&_h3]:mt-6 [&_h3]:font-serif [&_h3]:text-2xl [&_h3]:font-bold [&_p]:mb-3 [&_blockquote]:mb-3 [&_blockquote]:border-l-2 [&_blockquote]:border-[#D4AF37] [&_blockquote]:pl-4">' + item.content + '</div>' : ''}
                        ${item.source_url ? '<div class="mt-6 pt-4 border-t border-gray-100"><a href="' + escapeHtml(item.source_url) + '" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] hover:text-[#c4a030] transition font-medium"><i class="fas fa-external-link-alt"></i> Read at source</a></div>' : ''}
                    `;
                })
                .catch(function () {
                    content.innerHTML = '<div class="text-center py-12"><p class="text-[#5a5a52]">This story could not be opened.</p></div>';
                });
        }

        function closeNewsDetail() {
            document.getElementById('newsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>

    <section id="gallery" class="gallery-section py-24 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            @php
                $gallerySection = \App\Models\Setting::getGallerySection();
            @endphp
            <div class="gallery-head">
                <div>
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-3 uppercase">{{ $gallerySection['label'] }}</p>
                    <h2 class="gallery-title font-serif font-bold text-[#1e1e1a] leading-tight">{{ $gallerySection['title'] }}</h2>
                </div>
                <p class="gallery-intro text-[#5a5a52] leading-relaxed">
                    {{ $gallerySection['paragraph'] }}
                </p>
            </div>

            @if($galleryCollections->isNotEmpty())
                <div class="gallery-scroller" tabindex="0" aria-label="Photo collections">
                    @foreach($galleryCollections as $collection)
                        @php
                            $previewImages = $collection->images->take(4);
                            $lead = $previewImages->first();
                            $sideImages = $previewImages->slice(1, 3);
                        @endphp
                        <a href="{{ route('gallery.show', $collection) }}" class="gallery-card {{ $sideImages->isEmpty() ? 'gallery-card-single' : '' }}" aria-label="View {{ $collection->title }}">
                            <div class="gallery-card-lead">
                                <img src="{{ $lead->url }}" alt="{{ $collection->title }}" draggable="false">
                                <span class="gallery-card-count">{{ $collection->images->count() }} {{ \Illuminate\Support\Str::plural('photograph', $collection->images->count()) }}</span>
                                <div class="gallery-card-lead-copy">
                                    <span class="gallery-card-date">{{ $collection->created_at->format('M Y') }}</span>
                                    <h3>{{ $collection->title }}</h3>
                                </div>
                            </div>
                            @if($sideImages->isNotEmpty())
                                <div class="gallery-card-side">
                                    @foreach($sideImages as $image)
                                        <div class="gallery-card-thumb">
                                            <img src="{{ $image->url }}" alt="" draggable="false">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
                <p class="mt-4 text-xs text-[#8a8a82]">Drag or scroll sideways to move through the collections. Select a collection to see every photograph.</p>
            @else
                <p class="text-sm text-[#8a8a82]">{{ $gallerySection['empty'] }}</p>
            @endif
        </div>
    </section>

    {{-- <section class="py-24 bg-gradient-to-b from-[#f2efe8] to-[#faf8f5] text-[#1e1e1a]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-[#D4AF37]/10 px-4 py-2 rounded-full mb-4">
                    <span class="text-[#D4AF37]">✦</span>
                    <span class="text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">Join the work</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#1e1e1a] leading-tight">
                    Let's Build the <span class="text-[#D4AF37]">Future</span> Together
                </h2>
                <p class="text-[#5a5a52] mt-4 max-w-2xl mx-auto text-lg leading-relaxed">
                    Whether you are a municipality, school, organization, investor or a passionate individual, there is a place for you in this journey.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                <a href="{{ route('bootcamp') }}" class="group bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Municipalities</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Book Bootcamp</p>
                </a>

                <a href="https://skillsikka.com/" target="_blank" rel="noopener noreferrer" class="group bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Schools</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Skill Sikka</p>
                </a>

                <a href="https://hillychilly.com/" target="_blank" rel="noopener noreferrer" class="group bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Tourism</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">HillyChilly</p>
                </a>

                <button type="button" data-open-work="investor" class="group w-full bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Investors</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Meet</p>
                </button>

                <button type="button" data-open-work="builder" class="group col-span-2 md:col-span-1 w-full bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 20c4.478 0 8.268-2.943 9.542-7-1.274-4.057-5.064-7-9.542-7-4.477 0-8.268 2.943-9.542 7"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Volunteers</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Join Future</p>
                </button>
            </div>
        </div>
    </section> --}}
@endsection

<style>
#projects {
    overflow: hidden !important;
}

.carousel-container {
    mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
    -webkit-mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
}

.carousel-track {
    animation: none;
    will-change: transform;
    touch-action: pan-y;
    user-select: none;
}

.carousel-track:hover {
    animation-play-state: paused;
}

/* Pointer dragging is enabled by the scoped script below. */
.carousel-track.carousel-drag-ready {
    animation: none;
    cursor: grab;
}

.carousel-track.carousel-drag-ready.is-dragging {
    cursor: grabbing;
    transition: none !important;
}

.carousel-track.carousel-drag-ready.is-settling {
    transition: transform 180ms ease-out;
}

.gallery-section {
    background: #f7f4ee;
    color: #1e1e1a;
}

.gallery-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 2rem;
    margin-bottom: 2.5rem;
}

.gallery-head > div {
    flex: 1 0 auto;
}

.gallery-title {
    font-size: clamp(2rem, 3.1vw, 3.15rem);
}

.gallery-intro {
    flex: 0 1 280px;
    max-width: 280px;
    text-align: right;
}

@media (max-width: 760px) {
    .gallery-head {
        flex-direction: column;
        align-items: flex-start;
    }

    .gallery-intro {
        flex-basis: auto;
        max-width: 28rem;
        text-align: left;
    }
}

.gallery-scroller {
    display: flex;
    gap: 1.25rem;
    overflow-x: auto;
    padding-bottom: 1.35rem;
    cursor: grab;
    user-select: none;
    scrollbar-width: none;
    scroll-snap-type: x proximity;
}

.gallery-scroller.is-dragging {
    cursor: grabbing;
    scroll-snap-type: none;
}

.gallery-card {
    scroll-snap-align: start;
    flex: 0 0 auto;
    display: flex;
    width: min(82vw, 460px);
    height: 320px;
    border-radius: 0.75rem;
    overflow: hidden;
    border: 1px solid rgba(30, 30, 26, 0.08);
    box-shadow: 0 1px 2px rgba(30, 30, 26, 0.06);
    background: #e7e1d6;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}

.gallery-card:hover {
    box-shadow: 0 10px 24px rgba(30, 30, 26, 0.12);
}

.gallery-card-single .gallery-card-lead {
    width: 100%;
}

.gallery-card-lead {
    position: relative;
    flex: 1 1 auto;
    min-width: 0;
}

.gallery-card-lead img,
.gallery-card-thumb img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
}

.gallery-card-lead::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(30, 30, 26, 0.58), rgba(30, 30, 26, 0.05) 46%, transparent);
}

.gallery-card-count,
.gallery-card-lead-copy {
    position: absolute;
    z-index: 1;
}

.gallery-card-count {
    top: 1rem;
    left: 1rem;
    padding: 0.3rem 0.7rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.86);
    color: #735A12;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.gallery-card-lead-copy {
    left: 0;
    right: 0;
    bottom: 0;
    padding: 1.25rem;
}

.gallery-card-date {
    margin: 0 0 0.3rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.04em;
}

.gallery-card-lead-copy h3 {
    color: #fff;
    font-family: "Playfair Display", serif;
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1.15;
}

.gallery-card-side {
    display: flex;
    flex-direction: column;
    flex: 0 0 124px;
    width: 124px;
    overflow: hidden;
}

.gallery-card-thumb {
    position: relative;
    flex: 1 1 0;
    min-height: 0;
    border-left: 1px solid rgba(255, 255, 255, 0.7);
}

.gallery-card-thumb + .gallery-card-thumb {
    border-top: 1px solid rgba(255, 255, 255, 0.7);
}

.gallery-scroller::-webkit-scrollbar {
    display: none;
}

@media (max-width: 640px) {
    .gallery-card {
        height: 280px;
    }

    .gallery-card-side {
        flex-basis: 104px;
        width: 104px;
    }
}

@keyframes infiniteScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.tooltip-container {
    position: relative;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 16px;
    border: 1px solid rgba(212, 175, 55, 0.18);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
}

.tooltip-container:hover,
.tooltip-container.is-open {
    z-index: 100;
}

.project-default {
    opacity: 1;
    transition: opacity 0.25s ease, transform 0.35s ease;
}

.tooltip-container:hover .project-default {
    opacity: 0;
    transform: scale(0.95);
    pointer-events: none;
}

.tooltip-popup {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 400px;
    min-height: 380px;
    padding: 24px;
    background: #ffffff;
    color: #1e1e1a;
    border-radius: 20px;
    border: 1.5px solid rgba(212, 175, 55, 0.4);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    text-align: left;
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    overflow: auto;
    transform: translate(-50%, -50%) scale(0.85);
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.tooltip-container:hover .tooltip-popup,
.tooltip-container.is-open .tooltip-popup {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translate(-50%, -50%) scale(1);
}

.tooltip-container.is-open .project-default {
    opacity: 0;
    transform: scale(0.95);
    pointer-events: none;
}

.project-popup-content {
    height: 100%;
    min-height: 0;
}

.project-popup-content > div:first-child {
    min-height: 0;
    overflow: auto;
}

.tooltip-popup a {
    position: relative;
    z-index: 2;
}

.popup-image {
    width: 100%;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    padding: 12px;
    overflow: hidden;
    border-radius: 12px;
    background: #ffffff;
    border: 1px solid rgba(212, 175, 55, 0.2);
}

.popup-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.tooltip-popup p::-webkit-scrollbar {
    width: 4px;
}

.tooltip-popup p::-webkit-scrollbar-thumb {
    background: rgba(212, 175, 55, 0.5);
    border-radius: 4px;
}

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

/* Video Modal Styles */
#videoModal {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

#videoModal .relative {
    animation: scaleIn 0.3s ease;
}

@keyframes scaleIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
    .carousel-track {
        animation: none;
    }
    #videoModal {
        animation: none;
    }
    #videoModal .relative {
        animation: none;
    }
}
</style>

<script>
function playVideo(element, researchId) {
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');

    // Get video data from server
    fetch(`/research/${researchId}/video`)
        .then(response => response.json())
        .then(data => {
            if (data.video_file) {
                // Play uploaded video
                container.innerHTML = `
                    <video controls autoplay class="w-full h-full">
                        <source src="${data.video_file}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                `;
            } else if (data.video_embed_url) {
                // Play embedded video
                container.innerHTML = `
                    <iframe src="${data.video_embed_url}" class="w-full h-full" allowfullscreen></iframe>
                `;
            } else {
                container.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center text-white">
                        <p>No video available</p>
                    </div>
                `;
            }
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error loading video:', error);
            container.innerHTML = `
                <div class="w-full h-full flex items-center justify-center text-white">
                    <p>Error loading video. Please try again.</p>
                </div>
            `;
            modal.classList.remove('hidden');
        });
}

function closeVideoModal(event) {
    if (event && event.target !== event.currentTarget) return;
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');
    modal.classList.add('hidden');
    container.innerHTML = '';
    document.body.style.overflow = 'auto';
}

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal({ target: document.getElementById('videoModal') });
    }
});

// Counter animation for stats
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const updateCounter = () => {
            const target = parseInt(counter.getAttribute('data-target'));
            const current = parseInt(counter.innerText);
            const increment = Math.ceil(target / speed);

            if (current < target) {
                counter.innerText = Math.min(current + increment, target);
                setTimeout(updateCounter, 1);
            } else {
                counter.innerText = target;
            }
        };

        // Keep the real value in server-rendered HTML, then animate in the browser.
        counter.innerText = '0';
        updateCounter();
    });
});
</script>

<script>
/* Projects-only pointer carousel: supports mouse dragging and touch swipes. */
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('#projects .carousel-container');
    const track = carousel?.querySelector('.carousel-track');

    if (!carousel || !track || track.children.length < 2) return;

    track.classList.add('carousel-drag-ready');

    let maxPosition = 0;
    let position = 0;
    let lastFrame = 0;
    let pointerId = null;
    let startX = 0;
    let startPosition = 0;
    let dragged = false;
    let suppressClick = false;
    let paused = false;
    let direction = 1;
    const autoSpeed = 30; // pixels per second, matching the existing 30s carousel rhythm

    const measure = () => {
        maxPosition = Math.max(0, track.scrollWidth - carousel.clientWidth);
        position = Math.min(Math.max(position, 0), maxPosition);
    };

    const render = () => {
        track.style.transform = `translate3d(${-position}px, 0, 0)`;
    };

    const animate = (timestamp) => {
        if (!lastFrame) lastFrame = timestamp;
        const elapsed = Math.min(timestamp - lastFrame, 50);
        lastFrame = timestamp;

        if (pointerId === null && !paused && maxPosition) {
            position += direction * (elapsed / 1000) * autoSpeed;
            if (position >= maxPosition) {
                position = maxPosition;
                direction = -1;
            } else if (position <= 0) {
                position = 0;
                direction = 1;
            }
            render();
        }

        requestAnimationFrame(animate);
    };

    const finishDrag = () => {
        if (pointerId === null) return;

        const activePointerId = pointerId;
        pointerId = null;
        track.releasePointerCapture?.(activePointerId);
        track.classList.remove('is-dragging');

        if (dragged) {
            suppressClick = true;
            track.classList.add('is-settling');
            window.setTimeout(() => track.classList.remove('is-settling'), 190);
            window.setTimeout(() => { suppressClick = false; }, 0);
        }

        lastFrame = performance.now();
    };

    const isProjectLink = (event) => Boolean(event.target.closest('a, button'));

    carousel.addEventListener('pointerenter', () => { paused = true; });
    carousel.addEventListener('pointerleave', () => { paused = false; });

    track.querySelectorAll('.tooltip-container').forEach((card) => {
        card.addEventListener('mouseenter', () => card.classList.add('is-open'));
        card.addEventListener('mouseleave', () => card.classList.remove('is-open'));
    });

    track.addEventListener('pointerdown', (event) => {
        if (event.pointerType === 'mouse' && event.button !== 0) return;
        if (isProjectLink(event)) return;

        measure();
        pointerId = event.pointerId;
        startX = event.clientX;
        startPosition = position;
        dragged = false;
        track.classList.add('is-dragging');
        track.setPointerCapture?.(pointerId);
    });

    track.addEventListener('pointermove', (event) => {
        if (event.pointerId !== pointerId) return;

        const delta = event.clientX - startX;
        if (Math.abs(delta) > 5) dragged = true;
        if (!dragged) return;

        position = Math.min(Math.max(startPosition - delta, 0), maxPosition);
        render();
        event.preventDefault();
    });

    track.addEventListener('pointerup', finishDrag);
    track.addEventListener('pointercancel', finishDrag);
    track.addEventListener('lostpointercapture', finishDrag);

    track.addEventListener('click', (event) => {
        if (isProjectLink(event)) return;
        if (suppressClick) {
            event.preventDefault();
            event.stopPropagation();
        }
    }, true);

    window.addEventListener('resize', () => {
        measure();
        render();
    });

    measure();
    render();
    requestAnimationFrame(animate);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const scroller = document.querySelector('#gallery .gallery-scroller');
    if (!scroller) return;

    let pointerId = null;
    let startX = 0;
    let startScroll = 0;
    let dragged = false;

    const canScroll = () => scroller.scrollWidth > scroller.clientWidth + 4;

    scroller.addEventListener('pointerdown', function (event) {
        if (event.pointerType !== 'mouse' || event.button !== 0) return;
        pointerId = event.pointerId;
        startX = event.clientX;
        startScroll = scroller.scrollLeft;
        dragged = false;
    });

    scroller.addEventListener('pointermove', function (event) {
        if (event.pointerId !== pointerId) return;
        const delta = event.clientX - startX;
        if (!dragged && Math.abs(delta) <= 8) return;
        if (!dragged) {
            dragged = true;
            scroller.classList.add('is-dragging');
            try { scroller.setPointerCapture(pointerId); } catch (error) {}
        }
        scroller.scrollLeft = startScroll - delta;
        event.preventDefault();
    });

    const finishDrag = function (event) {
        if (pointerId === null) return;
        if (event && event.pointerId !== undefined && event.pointerId !== pointerId) return;
        const activePointerId = pointerId;
        pointerId = null;
        scroller.classList.remove('is-dragging');
        try { scroller.releasePointerCapture(activePointerId); } catch (error) {}
    };

    scroller.addEventListener('pointerup', finishDrag);
    scroller.addEventListener('pointercancel', finishDrag);
    scroller.addEventListener('lostpointercapture', finishDrag);

    scroller.addEventListener('click', function (event) {
        if (!dragged) return;
        event.preventDefault();
        event.stopPropagation();
        dragged = false;
    }, true);

    scroller.addEventListener('wheel', function (event) {
        if (!canScroll()) return;
        if (Math.abs(event.deltaY) <= Math.abs(event.deltaX)) return;
        scroller.scrollLeft += event.deltaY;
        event.preventDefault();
    }, { passive: false });
});
</script>
