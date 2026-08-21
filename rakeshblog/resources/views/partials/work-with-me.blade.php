@extends('layouts.app')

@section('title', 'Work With Me · Rakesh Rajbhat')

@section('content')
<section class="py-24 bg-[#fff6e0] text-[#1e1e1a] scroll-mt-20 relative">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        <!-- ========================================== -->
        <!-- FLASH MESSAGES                             -->
        <!-- ========================================== -->
        @if(session('success'))
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-md" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <div>
                        <p class="font-bold">Success!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-md" role="alert">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mt-1"></i>
                    <div>
                        <p class="font-bold">Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-md" role="alert">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mt-1"></i>
                    <div>
                        <p class="font-bold">Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- ========================================== -->
        <!-- 1. HERO SECTION                             -->
        <!-- ========================================== -->
        <div class="text-center max-w-4xl mx-auto mb-16">
            <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">Let's Build Something Meaningful</p>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold leading-tight mb-6 text-balance text-[#1e1e1a]">
                Work With Me
            </h1>
            <p class="text-[#3a3a34] text-lg max-w-2xl mx-auto leading-relaxed">
                Whether you're a municipality, school, organization, investor, or individual — let's explore how we can work together to create real-world impact.
            </p>
            <div class="mt-8">
                <a href="#opportunity" class="inline-block bg-[#D4AF37] text-[#0b0e12] px-10 py-4 rounded-xl font-bold text-sm tracking-wide hover:brightness-110 transition-all shadow-lg shadow-[#D4AF37]/20">
                    Start a Conversation <i class="fas fa-arrow-down ml-2"></i>
                </a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 2. THE OPPORTUNITY                          -->
        <!-- ========================================== -->
        <div id="opportunity" class="bg-white rounded-2xl shadow-xl p-10 md:p-12 text-center max-w-3xl mx-auto mb-20">
            <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-3 uppercase">The Opportunity</p>
            <h2 class="text-3xl font-serif font-bold mb-4">Great Things Start With A Conversation</h2>
            <p class="text-[#3a3a34] text-md max-w-2xl mx-auto leading-relaxed mb-6">
                I work with people and organizations who want to turn ideas, skills, and opportunities into meaningful projects.
            </p>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm font-medium text-[#D4AF37]">
                <span><i class="fas fa-microchip mr-1"></i> Technology</span> • 
                <span><i class="fas fa-graduation-cap mr-1"></i> Education</span> • 
                <span><i class="fas fa-users mr-1"></i> Community</span>
                <span class="hidden sm:inline">•</span> 
                <span><i class="fas fa-lightbulb mr-1"></i> Innovation</span> • 
                <span><i class="fas fa-umbrella-beach mr-1"></i> Tourism</span> • 
                <span><i class="fas fa-chart-line mr-1"></i> Future Skills</span>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 3. CUSTOM DROPDOWN & FORM SWITCHER         -->
        <!-- ========================================== -->
        <div x-data="{ 
            open: false, 
            selected: '{{ old('type', 'education') }}',
            options: [
                { id: 'education', label: 'Education', icon: 'fa-school', desc: 'Schools & future-skills programs' },
                { id: 'investor', label: 'Investor', icon: 'fa-handshake', desc: 'Investment & strategic partnerships' },
                { id: 'partner', label: 'Partner', icon: 'fa-building', desc: 'Organizations & business collaborations' },
                { id: 'builder', label: 'Future Builder', icon: 'fa-rocket', desc: 'Volunteer & contribute to projects' }
            ]
        }" class="max-w-4xl mx-auto">

            <!-- Custom Dropdown Trigger -->
            <div class="text-center mb-10">
                <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">Select Your Path</p>
                <h2 class="text-3xl font-serif font-bold mb-4">How Can We Work Together?</h2>
                
                <div class="relative inline-block w-full max-w-md text-left mt-4">
                    <div>
                        <button type="button" @click="open = !open" class="inline-flex justify-between w-full rounded-xl border border-gray-300 bg-white px-6 py-4 text-sm font-medium text-[#1e1e1a] hover:border-[#D4AF37] focus:outline-none focus:ring-2 focus:ring-[#D4AF37] transition-all shadow-sm">
                            <span class="flex items-center gap-2" x-html="'<i class=\'fas ' + options.find(opt => opt.id === selected).icon + '\'></i> ' + options.find(opt => opt.id === selected).label"></span>
                            <svg class="-mr-1 ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- Custom Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" class="absolute z-50 mt-2 w-full rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none origin-top-right transition ease-out duration-100" style="display: none;">
                        <div class="py-1">
                            <template x-for="option in options" :key="option.id">
                                <div @click="selected = option.id; open = false" class="cursor-pointer px-6 py-4 hover:bg-[#D4AF37]/10 transition-colors flex items-start gap-4 group">
                                    <div class="text-xl text-[#D4AF37] shrink-0 pt-1">
                                        <i :class="'fas ' + option.icon"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#D4AF37] transition-colors" x-text="option.label"></p>
                                        <p class="text-xs text-gray-500" x-text="option.desc"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- DYNAMIC FORMS                              -->
            <!-- ========================================== -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover:shadow-2xl transition-shadow duration-300">
                
                <!-- 2. EDUCATION FORM -->
                <div x-show="selected === 'education'" x-transition x-cloak>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-serif font-bold text-[#1e1e1a]">Education Partnership</h3>
                        <p class="text-[#4a4a42] mt-2 text-sm">Bring future-ready skills to students. Let's create practical learning experiences around technology, AI, coding, design, and entrepreneurship.</p>
                    </div>
                    <form action="{{ route('work-with-me.send') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf 
                        <input type="hidden" name="type" value="education">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-school text-[#D4AF37] mr-1"></i> School / Organization *</label>
                            <input type="text" name="org_name" required value="{{ old('org_name') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a] placeholder-gray-400" placeholder="e.g. Rato Bangala School">
                            @error('org_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-user text-[#D4AF37] mr-1"></i> Contact Person *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a] placeholder-gray-400" placeholder="Full Name">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-envelope text-[#D4AF37] mr-1"></i> Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a] placeholder-gray-400" placeholder="you@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-phone text-[#D4AF37] mr-1"></i> Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a] placeholder-gray-400" placeholder="+977 98XXXXXXXX">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-list text-[#D4AF37] mr-1"></i> What are you interested in? *</label>
                            <select name="interest" required class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a]">
                                <option value="">Select an option</option>
                                <option value="Skill Sikka (Digital Learning)" {{ old('interest') == 'Skill Sikka (Digital Learning)' ? 'selected' : '' }}>Skill Sikka (Digital Learning)</option>
                                <option value="AI & Coding Workshop" {{ old('interest') == 'AI & Coding Workshop' ? 'selected' : '' }}>AI & Coding Workshop</option>
                                <option value="Entrepreneurship Program" {{ old('interest') == 'Entrepreneurship Program' ? 'selected' : '' }}>Entrepreneurship Program</option>
                                <option value="Teacher Training" {{ old('interest') == 'Teacher Training' ? 'selected' : '' }}>Teacher Training</option>
                            </select>
                            @error('interest') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-users text-[#D4AF37] mr-1"></i> Target Audience *</label>
                            <select name="target_audience" required class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a]">
                                <option value="">Select audience</option>
                                <option value="School Students" {{ old('target_audience') == 'School Students' ? 'selected' : '' }}>School Students</option>
                                <option value="College Students" {{ old('target_audience') == 'College Students' ? 'selected' : '' }}>College Students</option>
                                <option value="Teachers" {{ old('target_audience') == 'Teachers' ? 'selected' : '' }}>Teachers</option>
                                <option value="Young Professionals" {{ old('target_audience') == 'Young Professionals' ? 'selected' : '' }}>Young Professionals</option>
                                <option value="Other" {{ old('target_audience') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('target_audience') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-layer-group text-[#D4AF37] mr-1"></i> Age / Grade</label>
                            <input type="text" name="age_grade" value="{{ old('age_grade') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a]" placeholder="e.g. Grades 9-12">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-people-arrows text-[#D4AF37] mr-1"></i> Expected Participants</label>
                            <input type="number" name="participants" value="{{ old('participants') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a]" placeholder="e.g. 30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-calendar-alt text-[#D4AF37] mr-1"></i> Preferred Date</label>
                            <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a]">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-comment-dots text-[#D4AF37] mr-1"></i> Additional Requirements</label>
                            <textarea name="requirements" rows="3" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition text-[#1e1e1a] resize-none" placeholder="Any specific learning outcomes you're looking for?">{{ old('requirements') }}</textarea>
                        </div>
                        
                        <div class="md:col-span-2 pt-2">
                            <button type="submit" class="w-full bg-[#D4AF37] text-[#0b0e12] px-6 py-4 rounded-xl font-bold hover:brightness-110 transition-all shadow-lg flex items-center justify-center gap-3">
                                <span>Discuss A Program</span> 
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 3. INVESTOR FORM -->
                <div x-show="selected === 'investor'" x-transition x-cloak>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-serif font-bold text-[#1e1e1a]">Invest / Partner</h3>
                        <p class="text-[#4a4a42] mt-2 text-sm">Explore opportunities to support and scale initiatives across technology, education, tourism, and community development.</p>
                    </div>
                    <form action="{{ route('work-with-me.send') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf 
                        <input type="hidden" name="type" value="investor">
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-user text-[#D4AF37] mr-1"></i> Your Name *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="Full Name">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-building text-[#D4AF37] mr-1"></i> Organization</label>
                            <input type="text" name="organization" value="{{ old('organization') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="Your Company">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-envelope text-[#D4AF37] mr-1"></i> Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="you@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-phone text-[#D4AF37] mr-1"></i> Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="+977 ...">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-handshake text-[#D4AF37] mr-1"></i> What are you interested in?</label>
                            <div class="flex flex-wrap gap-4 pt-1">
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="radio" name="investor_type" value="Investment" class="rounded-full border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ old('investor_type') == 'Investment' ? 'checked' : '' }}> 
                                    <span class="text-sm">Investment</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="radio" name="investor_type" value="Strategic Partnership" class="rounded-full border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ old('investor_type') == 'Strategic Partnership' ? 'checked' : '' }}> 
                                    <span class="text-sm">Strategic Partnership</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="radio" name="investor_type" value="Impact Partnership" class="rounded-full border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ old('investor_type') == 'Impact Partnership' ? 'checked' : '' }}> 
                                    <span class="text-sm">Impact Partnership</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="radio" name="investor_type" value="Technology Partnership" class="rounded-full border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ old('investor_type') == 'Technology Partnership' ? 'checked' : '' }}> 
                                    <span class="text-sm">Technology Partnership</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-comment-dots text-[#D4AF37] mr-1"></i> What would you like to explore?</label>
                            <textarea name="exploration" rows="4" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition resize-none" placeholder="Tell me about your vision...">{{ old('exploration') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-globe text-[#D4AF37] mr-1"></i> Website / LinkedIn</label>
                            <input type="text" name="website" value="{{ old('website') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="https://...">
                            @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2 pt-2">
                            <button type="submit" class="w-full bg-[#D4AF37] text-[#0b0e12] px-6 py-4 rounded-xl font-bold hover:brightness-110 transition-all shadow-lg flex items-center justify-center gap-3">
                                <span>Start A Conversation</span> 
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 4. PARTNER FORM -->
                <div x-show="selected === 'partner'" x-transition x-cloak>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-serif font-bold text-[#1e1e1a]">Let's Partner</h3>
                        <p class="text-[#4a4a42] mt-2 text-sm">Have an organization or company looking to collaborate? Let's explore how we can combine ideas, technology, and networks to create something valuable.</p>
                    </div>
                    <form action="{{ route('work-with-me.send') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf 
                        <input type="hidden" name="type" value="partner">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-building text-[#D4AF37] mr-1"></i> Organization Name *</label>
                            <input type="text" name="org_name" required value="{{ old('org_name') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="Your Organization">
                            @error('org_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-user text-[#D4AF37] mr-1"></i> Your Name *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="Full Name">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-envelope text-[#D4AF37] mr-1"></i> Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="you@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-phone text-[#D4AF37] mr-1"></i> Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="+977 ...">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-globe text-[#D4AF37] mr-1"></i> Website</label>
                            <input type="text" name="website" value="{{ old('website') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="https://...">
                            @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-list text-[#D4AF37] mr-1"></i> What are you looking for?</label>
                            <div class="flex flex-wrap gap-4 pt-1">
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="checkbox" name="collaboration_type[]" value="Project Collaboration" class="rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ in_array('Project Collaboration', old('collaboration_type', [])) ? 'checked' : '' }}> 
                                    <span class="text-sm">Project Collaboration</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="checkbox" name="collaboration_type[]" value="Technology Partnership" class="rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ in_array('Technology Partnership', old('collaboration_type', [])) ? 'checked' : '' }}> 
                                    <span class="text-sm">Technology Partnership</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="checkbox" name="collaboration_type[]" value="Education Program" class="rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ in_array('Education Program', old('collaboration_type', [])) ? 'checked' : '' }}> 
                                    <span class="text-sm">Education Program</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                    <input type="checkbox" name="collaboration_type[]" value="Community Initiative" class="rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]" {{ in_array('Community Initiative', old('collaboration_type', [])) ? 'checked' : '' }}> 
                                    <span class="text-sm">Community Initiative</span>
                                </label>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-comment-dots text-[#D4AF37] mr-1"></i> Tell me about it</label>
                            <textarea name="details" rows="4" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition resize-none" placeholder="What's the idea?">{{ old('details') }}</textarea>
                        </div>
                        <div class="md:col-span-2 pt-2">
                            <button type="submit" class="w-full bg-[#D4AF37] text-[#0b0e12] px-6 py-4 rounded-xl font-bold hover:brightness-110 transition-all shadow-lg flex items-center justify-center gap-3">
                                <span>Propose A Collaboration</span> 
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 5. FUTURE BUILDER FORM -->
                <div x-show="selected === 'builder'" x-transition x-cloak>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-serif font-bold text-[#1e1e1a]">Become a Future Builder</h3>
                        <p class="text-[#4a4a42] mt-2 text-sm">You don't need to have everything figured out. Bring your skills, ideas, curiosity, or simply your willingness to contribute.</p>
                    </div>
                    <form action="{{ route('work-with-me.send') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf 
                        <input type="hidden" name="type" value="builder">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-user text-[#D4AF37] mr-1"></i> Full Name *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="Your Name">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-envelope text-[#D4AF37] mr-1"></i> Email *</label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="you@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-phone text-[#D4AF37] mr-1"></i> Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="+977 ...">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-map-pin text-[#D4AF37] mr-1"></i> Location</label>
                            <input type="text" name="location" value="{{ old('location') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="City / Country">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-code text-[#D4AF37] mr-1"></i> Your Skills</label>
                            <input type="text" name="skills" value="{{ old('skills') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="e.g. Laravel, UI Design, Teaching...">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-link text-[#D4AF37] mr-1"></i> Portfolio / GitHub / LinkedIn</label>
                            <input type="text" name="portfolio" value="{{ old('portfolio') }}" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition" placeholder="https://...">
                            @error('portfolio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2"><i class="fas fa-comment-dots text-[#D4AF37] mr-1"></i> Why do you want to contribute?</label>
                            <textarea name="contribution_reason" rows="3" class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] transition resize-none" placeholder="Tell me your story...">{{ old('contribution_reason') }}</textarea>
                        </div>
                        <div class="md:col-span-2 pt-2">
                            <button type="submit" class="w-full bg-[#D4AF37] text-[#0b0e12] px-6 py-4 rounded-xl font-bold hover:brightness-110 transition-all shadow-lg flex items-center justify-center gap-3">
                                <span>Join The Future</span> 
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 4. WHAT HAPPENS NEXT                       -->
        <!-- ========================================== -->
        <div class="max-w-4xl mx-auto mt-20">
            <div class="text-center mb-12">
                <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">The Journey</p>
                <h2 class="text-3xl font-serif font-bold text-[#1e1e1a]">What Happens Next?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-xl p-8 text-center border border-[#D4AF37]/15 hover:border-[#D4AF37] transition-all hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-2xl font-bold text-[#D4AF37] mx-auto mb-4">01</div>
                    <h3 class="font-bold text-lg mb-2">You Reach Out</h3>
                    <p class="text-sm text-[#3a3a34]">Tell me what you're looking for through the form.</p>
                </div>
                <div class="bg-white rounded-xl shadow-xl p-8 text-center border border-[#D4AF37]/15 hover:border-[#D4AF37] transition-all hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-2xl font-bold text-[#D4AF37] mx-auto mb-4">02</div>
                    <h3 class="font-bold text-lg mb-2">We Connect</h3>
                    <p class="text-sm text-[#3a3a34]">We'll discuss your idea, needs, and goals together.</p>
                </div>
                <div class="bg-white rounded-xl shadow-xl p-8 text-center border border-[#D4AF37]/15 hover:border-[#D4AF37] transition-all hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-2xl font-bold text-[#D4AF37] mx-auto mb-4">03</div>
                    <h3 class="font-bold text-lg mb-2">We Build</h3>
                    <p class="text-sm text-[#3a3a34]">We explore the right way to work together and make it happen.</p>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 5. NOT SURE?                                -->
        <!-- ========================================== -->
        <div class="text-center max-w-2xl mx-auto mt-20 p-10 bg-[#D4AF37]/5 rounded-2xl border border-[#D4AF37]/20">
            <p class="font-bold text-xl font-serif text-[#1e1e1a]">Have a different idea?</p>
            <p class="text-[#3a3a34] mt-2">Not sure which option fits you? That's completely fine.</p>
            <a href="{{ route('contact') }}" class="inline-block mt-4 bg-[#D4AF37] text-[#0b0e12] px-8 py-3 rounded-xl font-bold hover:brightness-110 transition-all shadow-lg">
                Just Send A Message <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

    </div>
</section>

<!-- Alpine.js and x-cloak styles -->
<style>
    [x-cloak] { display: none !important; }
</style>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection