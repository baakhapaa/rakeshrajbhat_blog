@extends('layouts.app')

@section('title', 'Rakesh Rajbhat · Portfolio')

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
                    <!-- Mission items -->
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
        <div class="max-w-8xl mx-auto px-6 mb-10">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">What I'm Building</p>
                    <h2 class="text-4xl font-serif font-bold text-[#1e1e1a]">Projects &amp; Initiatives</h2>
                </div>
            </div>
        </div>

        <!-- Infinite Carousel -->
        <div class="carousel-container relative w-full py-16">
            <div class="carousel-track flex items-center gap-8 w-max">
                @forelse($projects ?? [] as $project)
                    <div class="tooltip-container w-[300px] shrink-0 bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all">
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
                            <h4 class="font-bold text-[#1e1e1a] mb-2 text-lg">{{ $project->name }}</h4>
                            <p class="text-xs text-gray-600 mb-4 flex-grow line-clamp-2">{{ $project->short_description ?? 'Hover to learn more' }}</p>
                            <span class="text-[#D4AF37] text-xs font-bold flex items-center gap-1">Learn More →</span>
                        </div>
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
                                    <h5 class="font-bold text-xl text-[#1e1e1a] mb-2">{{ $project->name }}</h5>
                                    <p class="text-sm text-gray-700 leading-relaxed max-h-[140px] overflow-y-auto pr-1">{{ $project->description ?? $project->long_description ?? $project->short_description }}</p>
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

                @foreach($projects ?? [] as $project)
                    <div class="tooltip-container w-[300px] shrink-0 bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all">
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
                            <h4 class="font-bold text-[#1e1e1a] mb-2 text-lg">{{ $project->name }}</h4>
                            <p class="text-xs text-gray-600 mb-4 flex-grow line-clamp-2">{{ $project->short_description ?? 'Hover to learn more' }}</p>
                            <span class="text-[#D4AF37] text-xs font-bold flex items-center gap-1">Learn More →</span>
                        </div>
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
                                    <h5 class="font-bold text-xl text-[#1e1e1a] mb-2">{{ $project->name }}</h5>
                                    <p class="text-sm text-gray-700 leading-relaxed max-h-[140px] overflow-y-auto pr-1">{{ $project->description ?? $project->long_description ?? $project->short_description }}</p>
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
    <section id="research" class="py-24 bg-[#f2efe8] text-[#1e1e1a] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Section Title -->
        <div class="text-center mb-16">
            <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">Knowledge & Insights</p>
            <h2 class="text-4xl md:text-5xl font-serif font-bold">Research & Resources</h2>
            <p class="text-[#3a3a34] mt-3 max-w-2xl mx-auto">Exploring ideas, frameworks, and stories that shape Nepal's future.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="text-[#D4AF37]"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></div>
                        <p class="text-xs font-bold tracking-widest uppercase">Vision for Nepal</p>
                    </div>
                    <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden mb-6 shadow-md"><img alt="Nepal Vision" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlyyrzK21rvtEsvMYuuY-wKX-UQY-HEfD-0pwe9MHDQsCkJ4_Jq8tuhmoU6SeZrwMSyRCbpYz-ZKTh6Bam2NxyGOTXGoDvIhcYsg6T6mJ0DAslMKcFWbC1C4l0xLp2ZEjUKPauoLSTCjcc-xj8aCZUvTGkUQ9eBQgJ5fDQKrW--vlUtMdgoaY7Zw84B5KKavpyIYaIV5o-Ole5FPBNo4yR3CqtpyxNlQBxTY8tufpYJC6wLyTj6iVY"/></div>
                    <div><p class="text-sm text-[#3a3a34] leading-relaxed">My vision for a developed, prosperous and self-reliant Nepal through education, tourism, technology, youth and local economy.</p><a class="inline-block mt-4 text-xs font-bold border-b border-[#D4AF37] pb-1 text-[#D4AF37]" href="#">Explore the Vision →</a></div>
                </div>
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="text-[#D4AF37]"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></div>
                        <p class="text-xs font-bold tracking-widest uppercase">Research &amp; Papers</p>
                    </div>
                    <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden mb-6 shadow-md"><img alt="Research" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBufk59CauXHtXWCa8q_54EQ0irh6vBL23a9el9MZKt_1qKHgT4tWVdfINxY7hL1lQVGXrtL6k6tw8GBdbgZBYb9Gu0OdPAPAVKeCt-XaGpOcaOZFkb69Bd6m1SC35wNTPVp3AsMU2wke69WQGa9-H0_jG4kg5cfI7o8Y23EzVEhk8VhIBQkfANISHkrP08vIc9qjD1N56XS3-ecMyHa8BiExlL3cbAqaEKZs2grie11iEPdqfYjtqr"/></div>
                    <div><p class="text-sm text-[#3a3a34] leading-relaxed">Research papers, proposed frameworks, doctrines and whitepapers on education, tourism, technology and development.</p><a class="inline-block mt-4 text-xs font-bold border-b border-[#D4AF37] pb-1 text-[#D4AF37]" href="#">Explore Research →</a></div>
                </div>
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="text-[#D4AF37]"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 00-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></div>
                        <p class="text-xs font-bold tracking-widest uppercase">Media &amp; Stories</p>
                    </div>
                    <div class="aspect-video bg-gray-200 rounded-xl overflow-hidden mb-6 shadow-md"><img alt="Media" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBr6S8tuEdXCRKMfmXm1Vdk8bwDeh5w3OP0ecYQyeweclZ7Tt8ox9nb25CCDsARSHOWp4A74B_C31LtqTay7Mi1NrFVIfsqyZeiZTLtkDPZ8ENa4vkdlS3lf_ia6HhsyPUTNnioKNEBNGUQILue25msAiYzo0vbFw7XEtpMZFngDRUVU8UJ0v52kuaH8g6hoj32s71pZ62XzoEtZJYJ6Qe-2cG2zg6lSczg7VWSHJ5_9a3I2jFzE7Iy"/></div>
                    <div><p class="text-sm text-[#3a3a34] leading-relaxed">Videos, interviews, bootcamp highlights, podcasts and stories from the ground.</p><a class="inline-block mt-4 text-xs font-bold border-b border-[#D4AF37] pb-1 text-[#D4AF37]" href="#">Watch &amp; Listen →</a></div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- FEATURED BLOGS SECTION - MOVED BELOW RESEARCH -->
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

                    <!-- View All Blogs Button -->
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

@media (prefers-reduced-motion: reduce) {
    .carousel-track {
        animation: none;
    }
}
</style>