@extends('layouts.app')

@section('title', 'Rakesh Rajbhat · Portfolio')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen pt-20 flex items-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img 
                src="https://media.licdn.com/dms/image/v2/C5603AQE6POjIis5YCw/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1660678334379?e=1788393600&v=beta&t=eHlLVtp2b2sIXaemzCtK5XZOMHi3bWvMBJf5hwJBb8c" 
                alt="Rakesh Rajbhat" 
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
                        <a href="#" class="border border-white/30 text-white px-8 py-3 font-bold text-sm tracking-wide rounded-sm hover:bg-white/10 transition-all">
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
    <section id="projects" class="py-24 bg-[#fff6e0] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">What I'm Building</p>
                    <h2 class="text-4xl font-serif font-bold text-[#1e1e1a]">Projects &amp; Initiatives</h2>
                </div>
                <a class="text-[#1e1e1a] font-bold text-sm flex items-center gap-1 group hover:text-[#D4AF37]" href="#">
                    View All Projects <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
                <!-- Baakhapaa -->
                <div class="bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white/96 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-6"><span class="text-3xl font-bold text-orange-600">B</span></div>
                    <h4 class="font-bold text-[#1e1e1a] mb-3">Baakhapaa</h4>
                    <p class="text-xs text-gray-600 mb-6 flex-grow">Play • Learn • Earn ecosystem that rewards knowledge.</p>
                    <a class="text-[#D4AF37] text-xs font-bold flex items-center gap-1" href="#">Learn More →</a>
                </div>
                <!-- Skill Sikka -->
                <div class="bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white/96 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6"><svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg></div>
                    <h4 class="font-bold text-[#1e1e1a] mb-3">Skill Sikka</h4>
                    <p class="text-xs text-gray-600 mb-6 flex-grow">Education OS empowering schools and learners.</p>
                    <a class="text-[#D4AF37] text-xs font-bold flex items-center gap-1" href="#">Learn More →</a>
                </div>
                <!-- HillyChilly -->
                <div class="bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white/96 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-6 overflow-hidden"><img alt="HillyChilly" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDtVw82X70xhiu3XiyMuulIp1IUKvKbscyTnVn07plv5jPl_9xfV8KE0oMpsWFLaTklXBW78elL5V5GChnbiw_VkaGWP5NgXsodX6c4wG3SfpRROuy245T6ukKH95NYOrzNkZAxgtvrA79tJ5rjgHb6LsQrd1zVBM8GEpI0z9FGDwU64Ijd4hYQPWTv9LFP2EPIZMZqSDmPYwwwsj-hhwYek9agWMYb5M4PRpm-Ly-A7_oq9CxjvEKQ"/></div>
                    <h4 class="font-bold text-[#1e1e1a] mb-3">HillyChilly</h4>
                    <p class="text-xs text-gray-600 mb-6 flex-grow">Gamified tourism platform for local destinations.</p>
                    <a class="text-[#D4AF37] text-xs font-bold flex items-center gap-1" href="#">Learn More →</a>
                </div>
                <!-- Future Builders -->
                <div class="bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white/96 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6"><svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg></div>
                    <h4 class="font-bold text-[#1e1e1a] mb-3">Future Builders</h4>
                    <p class="text-xs text-gray-600 mb-6 flex-grow">Youth movement building skills &amp; entrepreneurs.</p>
                    <a class="text-[#D4AF37] text-xs font-bold flex items-center gap-1" href="#">Learn More →</a>
                </div>
                <!-- Marsyangdi -->
                <div class="bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white/96 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-6"><svg class="h-8 w-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg></div>
                    <h4 class="font-bold text-[#1e1e1a] mb-3 leading-tight">Marsyangdi Doctrine</h4>
                    <p class="text-xs text-gray-600 mb-6 flex-grow">100-year vision for sustainable development.</p>
                    <a class="text-[#D4AF37] text-xs font-bold flex items-center gap-1" href="#">Learn More →</a>
                </div>
                <!-- Kholso -->
                <div class="bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white/96 hover:shadow-lg hover:-translate-y-1 transition-all">
                    <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mb-6"><svg class="h-8 w-8 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></svg></div>
                    <h4 class="font-bold text-[#1e1e1a] mb-3">Kholso</h4>
                    <p class="text-xs text-gray-600 mb-6 flex-grow">Regenerative living spaces celebrating culture.</p>
                    <a class="text-[#D4AF37] text-xs font-bold flex items-center gap-1" href="#">Learn More →</a>
                </div>
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
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">58</div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Students Trained<br/>AI &amp; ICT Bootcamp</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">4</div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Days<br/>Intensive Bootcamp</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">2</div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Municipalities<br/>Actively Engaged</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">15+</div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Team Members<br/>Passionate Builders</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419] border-b border-white/5 sm:border-b-0">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">5 Lakh+</div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">NPR Budget<br/>Invested in Youth</div>
                </div>
                <div class="p-8 text-center flex flex-col items-center bg-[#0f1419]">
                    <svg class="h-8 w-8 text-[#D4AF37] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <div class="text-4xl font-serif font-bold text-white mb-1">1000+</div>
                    <div class="text-[10px] tracking-widest text-gray-400 uppercase leading-tight">Future Builders<br/>And Growing</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Research Section -->
    <section id="research" class="py-24 bg-[#f2efe8] text-[#1e1e1a] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
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
    </section>
@endsection