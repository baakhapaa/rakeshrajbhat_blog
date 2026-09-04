@extends('layouts.app')

@section('title', 'Rakesh Rajbhat · Portfolio')

@section('title', 'Rakesh Rajbhat | Technology Entrepreneur & Youth Development Builder')
@section('meta_description', 'Official website of Rakesh Rajbhat, founder of Baakhapaa and builder of Skill Sikka, Hillychilly, Future Builders and AI & ICT programs in Nepal.')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen pt-20 flex items-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ asset('images/rakeshrajbhat.jpg') }}"
                class="w-full h-full object-cover opacity-50 saturate-[1.1]"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0e12] via-[#0b0e12]/70 to-transparent"></div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-end">
                <div>
                    <p class="text-[#D4AF37] tracking-[0.25em] text-xs font-bold mb-4 uppercase">Founder · Builder · Future Maker</p>
                    <h1 class="text-5xl lg:text-7xl font-serif leading-[1.1] mb-8 text-balance text-white">
                        Building Opportunities <br/>
                        <span class="italic">for Youth, Communities,</span><br/>
                        and Future Generations.
                    </h1>
                    <p class="text-gray-300 text-lg max-w-lg mb-10 leading-relaxed">
                        Founder of Baakhapaa, Skill Sikka, HillyChilly and Future Builders. Transforming education, tourism, technology, and local economies in Nepal.
                    </p>
                    <div class="flex flex-wrap items-center gap-6">
                        <a href="#projects" class="bg-[#D4AF37] text-[#0b0e12] px-8 py-3 font-bold text-sm tracking-wide rounded-sm hover:brightness-110 transition-all shadow-lg shadow-[#D4AF37]/20">
                            Explore My Projects
                        </a>
                        <a href="{{ route('work-with-me') }}" class="border border-white/30 text-white px-8 py-3 font-bold text-sm tracking-wide rounded-sm hover:bg-white/10 transition-all">
                            Work With Me
                        </a>
                        <a href="#about" class="text-[#D4AF37] text-sm font-bold flex items-center gap-2 group">
                            Read My Vision <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                </div>
                <div class="lg:text-right pb-4">
                    <div class="font-serif italic text-5xl lg:text-7xl mb-2 drop-shadow-lg text-[#D4AF37]">Rakesh Rajbhat</div>
                    <p class="text-xs tracking-[0.35em] font-medium text-white/70 uppercase">For the root. For the youth. For the nation.</p>
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
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">What I'm Building</p>
                    <h2 class="text-4xl font-serif font-bold text-[#1e1e1a]">Projects &amp; Initiatives</h2>
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

                {{-- SECOND SET (DUPLICATED FOR SEAMLESS INFINITE LOOP) --}}
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
                <!-- Stats items -->
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0 stat-item">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">
                        <span class="counter" data-target="115">0</span>
                        <span class="text-4xl text-white">+</span>
                    </div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Students Trained<br/>AI &amp; ICT Bootcamp</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0 stat-item">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">
                        <span class="counter" data-target="4">0</span>
                    </div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Days<br/>Intensive Bootcamp</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0 stat-item">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">
                        <span class="counter" data-target="2">0</span>
                    </div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Municipalities<br/>Actively Engaged</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0 stat-item">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">
                        <span class="counter" data-target="15">0</span>
                        <span class="text-4xl text-white">+</span>
                    </div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Team Members<br/>Passionate Builders</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0 stat-item">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">
                        <span class="counter" data-target="5">0</span>
                        <span class="text-4xl text-white"> M+</span>
                    </div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">NPR Budget<br/>Invested in Youth</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] stat-item">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">
                        <span class="counter" data-target="1000">0</span>
                        <span class="text-4xl text-white">+</span>
                    </div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Future Builders<br/>And Growing</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Research Section -->
<section id="research" class="py-24 bg-gradient-to-b from-[#f2efe8] to-[#faf8f5] text-[#1e1e1a] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Section Title -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-[#D4AF37]/10 px-4 py-2 rounded-full mb-4">
                <span class="text-[#D4AF37]">✦</span>
                <span class="text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">Knowledge & Insights</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#1e1e1a] leading-tight">
                Stories, Ideas &amp; <br class="hidden sm:block">
                <span class="text-[#D4AF37]">Research</span> That Matters
            </h2>
            <p class="text-[#5a5a52] mt-4 max-w-2xl mx-auto text-lg leading-relaxed">
                Exploring ideas, frameworks, and stories that shape Nepal's future — 
                <span class="text-[#1e1e1a] font-medium">one insight at a time.</span>
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @php
                $categories = [
                    'vision' => [
                        'label' => 'Vision for Nepal', 
                        'button_text' => 'Explore the Vision', 
                        'icon' => 'fa-eye',
                        'color' => 'amber',
                        'emoji' => '🌟',
                        'description' => 'Big ideas for a better tomorrow'
                    ],
                    'research' => [
                        'label' => 'Research & Papers', 
                        'button_text' => 'Explore Research', 
                        'icon' => 'fa-book',
                        'color' => 'blue',
                        'emoji' => '📚',
                        'description' => 'Evidence-based insights'
                    ],
                    'media' => [
                        'label' => 'Media & Stories', 
                        'button_text' => 'Watch & Listen', 
                        'icon' => 'fa-video',
                        'color' => 'purple',
                        'emoji' => '🎬',
                        'description' => 'Inspiring stories from the field'
                    ]
                ];
            @endphp

            @foreach($categories as $key => $category)
                <div class="space-y-5">
                    <!-- Category Header -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
                            <i class="fas {{ $category['icon'] }} text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold tracking-widest uppercase text-[#4a4a42]">
                                {{ $category['label'] }}
                            </p>
                            <p class="text-[10px] text-[#8a8a82]">{{ $category['description'] }}</p>
                        </div>
                        @if(isset($featuredResearch[$key]) && $featuredResearch[$key]->isNotEmpty())
                            <span class="ml-auto px-2.5 py-1 text-[9px] font-medium bg-gradient-to-r from-[#D4AF37]/20 to-[#D4AF37]/10 text-[#D4AF37] rounded-full flex items-center gap-1">
                                <i class="fas fa-star text-[8px]"></i> Featured
                            </span>
                        @endif
                    </div>

                    @if(isset($featuredResearch[$key]) && $featuredResearch[$key]->isNotEmpty())
                        @foreach($featuredResearch[$key] as $item)
                            <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                                <!-- Image/Video Section -->
                                <div class="relative aspect-video bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden cursor-pointer" onclick="openResearchDetail({{ $item->id }})">
                                    @if($item->video_url || $item->video_file)
                                        <!-- Video Play Button -->
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
                                    
                                    <!-- Featured Badge -->
                                    <div class="absolute top-3 right-3 z-10">
                                        <span class="px-2.5 py-1 bg-[#D4AF37] text-[#0b0e12] text-[10px] font-bold rounded-full flex items-center gap-1 shadow-lg shadow-[#D4AF37]/20">
                                            <i class="fas fa-star text-[8px]"></i> Featured
                                        </span>
                                    </div>
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute bottom-3 left-3 z-10">
                                        <span class="px-2.5 py-1 bg-black/60 backdrop-blur-sm text-white text-[10px] font-medium rounded-full flex items-center gap-1 border border-white/10">
                                            <i class="fas {{ $category['icon'] }} text-[8px]"></i>
                                            {{ $category['label'] }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-5">
                                    <h3 class="text-lg font-serif font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors duration-300 line-clamp-2 cursor-pointer" onclick="openResearchDetail({{ $item->id }})">
                                        {{ $item->title }}
                                    </h3>
                                    
                                    <p class="text-sm text-[#5a5a52] leading-relaxed line-clamp-2">
                                        {{ $item->description }}
                                    </p>
                                    
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                                        <button onclick="openResearchDetail({{ $item->id }})" 
                                                class="text-[#D4AF37] text-sm font-medium hover:text-[#c4a030] transition flex items-center gap-2 group/btn">
                                            <span>Read the story</span>
                                            <span class="group-hover/btn:translate-x-1 transition-transform">→</span>
                                        </button>
                                        
                                        <div class="flex items-center gap-2">
                                            @if($item->link_url)
                                                <a href="{{ $item->link_url }}" target="_blank" rel="noopener noreferrer" 
                                                   class="w-8 h-8 rounded-full bg-gray-100 hover:bg-[#D4AF37]/10 flex items-center justify-center text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">
                                                    <i class="fas fa-external-link-alt text-xs"></i>
                                                </a>
                                            @endif
                                            @if($item->video_url || $item->video_file)
                                                <button onclick="event.stopPropagation(); playVideo(this, '{{ $item->id }}')" 
                                                        class="w-8 h-8 rounded-full bg-gray-100 hover:bg-[#D4AF37]/10 flex items-center justify-center text-gray-400 hover:text-[#D4AF37] transition-colors duration-300">
                                                    <i class="fas fa-play text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Empty State -->
                        <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50 hover:shadow-md transition-all duration-300">
                            <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl overflow-hidden mb-4 flex items-center justify-center">
                                <span class="text-5xl opacity-20">{{ $category['emoji'] }}</span>
                            </div>
                            <p class="text-sm text-[#5a5a52] font-medium">No featured content yet</p>
                            <p class="text-xs text-[#8a8a82] mt-1">Check back soon for updates</p>
                        </div>
                    @endif
                </div>
            @endforeach
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
                            <div class="text-[#3a3a34] leading-relaxed whitespace-pre-wrap prose prose-sm max-w-none">${escapeHtml(item.content)}</div>
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

    <!-- FEATURED BLOGS SECTION -->
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
                                    <span>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}</span>
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
    animation: infiniteScroll 30s linear infinite;
    will-change: transform;
}

.carousel-track:hover {
    animation-play-state: paused;
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

.tooltip-container:hover {
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
    transform: translate(-50%, -50%) scale(0.85);
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.tooltip-container:hover .tooltip-popup {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translate(-50%, -50%) scale(1);
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
        
        updateCounter();
    });
});
</script>
