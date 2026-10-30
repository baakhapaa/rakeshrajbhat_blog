@extends('layouts.app')

@section('title', 'Book a Bootcamp · Rakesh Rajbhat')

@section('title', 'AI & ICT Bootcamps for Municipalities | Rakesh Rajbhat')
@section('meta_description', 'Bring a practical AI, ICT and cybersecurity bootcamp to your municipality or school, with project-based learning and documented outcomes.')

@section('content')
@php
    $page = $page ?? \App\Support\BootcampPage::content();
@endphp
<!-- Book a Bootcamp Section -->
<section id="bootcamp" class="site-theme pt-32 pb-24 text-[#1b1c1a] scroll-mt-20 relative">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center max-w-4xl mx-auto mb-20">
            @if($page['hero_kicker'] !== '')
                <div class="site-kicker center">
                    <span aria-hidden="true"></span>
                    <p>{{ $page['hero_kicker'] }}</p>
                </div>
            @endif
            @if($page['hero_heading'] !== '')
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold leading-tight mb-6 text-balance text-[#111]">
                    {{ $page['hero_heading'] }}
                </h2>
            @endif
            @if($page['hero_intro'] !== '')
                <p class="text-[#3a3a34] text-lg max-w-3xl mx-auto leading-relaxed">
                    {{ $page['hero_intro'] }}
                </p>
            @endif
        </div>

        @php
            $showProcess = ($page['steps'] ?? []) !== [];
            $showExpertise = ($page['offerings'] ?? []) !== [];
            $showAside = $showProcess || $showExpertise;
        @endphp
        <div class="grid grid-cols-1 {{ $showAside ? 'lg:grid-cols-2' : '' }} gap-16 items-start">
            
            <!-- LEFT SIDE: Booking Form -->
            <div id="bootcamp-form" class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover:shadow-2xl transition-shadow duration-300">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-serif font-bold text-[#1e1e1a]">Request a Bootcamp</h2>
                    <p class="text-[#4a4a42] mt-2 text-sm">Fill out the form below and let's bring the future to your community.</p>
                </div>

                <!-- Success Message Block -->
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-start gap-3 text-sm">
                        <i class="fas fa-check-circle text-green-500 text-xl mt-0.5"></i>
                        <div>
                            <p class="font-semibold">Request Sent!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Error Display Block -->
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bootcamp.submit') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf

                    <!-- Organization Name -->
                    <div class="md:col-span-2">
                        <label for="org_name" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-building text-[#D4AF37] mr-1"></i> Municipality / Organization Name *
                        </label>
                        <input type="text" id="org_name" name="org_name" value="{{ old('org_name') }}" required
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400"
                            placeholder="e.g. Kathmandu Metropolitan City">
                    </div>

                    <!-- Municipality / District -->
                    <div class="md:col-span-2">
                        <label for="district" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-map-pin text-[#D4AF37] mr-1"></i> Municipality / District *
                        </label>
                        <input type="text" id="district" name="district" value="{{ old('district') }}" required
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400"
                            placeholder="e.g. Kathmandu">
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-user text-[#D4AF37] mr-1"></i> Contact Person *
                        </label>
                        <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person') }}" required
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400"
                            placeholder="Full Name">
                    </div>

                    <!-- Contact Email -->
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-envelope text-[#D4AF37] mr-1"></i> Email *
                        </label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400"
                            placeholder="you@example.com">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-phone text-[#D4AF37] mr-1"></i> Phone *
                        </label>
                        <input type="tel" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" required
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400"
                            placeholder="+977 98XXXXXXXX">
                    </div>

                    <!-- Expected Participants -->
                    <div>
                        <label for="participants" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-users text-[#D4AF37] mr-1"></i> Expected Participants *
                        </label>
                        <input type="number" id="participants" name="participants" value="{{ old('participants') }}" required
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400"
                            placeholder="e.g. 50">
                    </div>

                    <!-- Preferred Date -->
                    <div>
                        <label for="preferred_date" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-calendar-alt text-[#D4AF37] mr-1"></i> Preferred Date *
                        </label>
                        <input type="date" id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}" required
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400">
                    </div>

                    @if(($page['audiences'] ?? []) !== [])
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#3a3a34] mb-2">
                                <i class="fas fa-user-graduate text-[#D4AF37] mr-1"></i> Who is this for?
                            </label>
                            <div class="flex flex-wrap gap-4 pt-1">
                                @foreach($page['audiences'] as $audience)
                                    <label class="flex items-center gap-2 cursor-pointer text-[#1e1e1a]">
                                        <input type="checkbox" name="audience[]" value="{{ $audience }}" @checked(in_array($audience, old('audience', []), true)) class="rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]">
                                        <span class="text-sm">{{ $audience }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Requirements -->
                    <div class="md:col-span-2">
                        <label for="requirements" class="block text-sm font-medium text-[#3a3a34] mb-2">
                            <i class="fas fa-comment text-[#D4AF37] mr-1"></i> Tell us about your requirement
                        </label>
                        <textarea id="requirements" name="requirements" rows="4"
                            class="w-full px-4 py-3 bg-[#f2f2f2] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition text-[#1e1e1a] placeholder-gray-400 resize-none"
                            placeholder="Any specific topics you want covered? Do you have a venue? Let us know...">{{ old('requirements') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="md:col-span-2 pt-2">
                        <p class="md:col-span-2 text-xs text-[#4a4a42] leading-relaxed">
                            By submitting this request, you agree that we may use your information to respond to your inquiry. Read our <a href="{{ route('privacy') }}" class="underline">Privacy Policy</a>.
                        </p>
                        <button type="submit" class="w-full bg-[#D4AF37] text-[#0b0e12] px-6 py-4 rounded-xl font-bold hover:brightness-110 transition-all shadow-lg shadow-[#D4AF37]/20 hover:shadow-xl flex items-center justify-center gap-3 group">
                            <span>Send Bootcamp Request</span>
                            <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </form>
            </div>

            @if($showAside)
                <div class="space-y-10">
                    @if($showProcess)
                        <div>
                            @if($page['process_label'] !== '')
                                <div class="site-kicker"><span aria-hidden="true"></span><p>{{ $page['process_label'] }}</p></div>
                            @endif
                            @if($page['process_heading'] !== '')
                                <h2 class="text-3xl font-serif font-bold text-[#1e1e1a] mb-6">{{ $page['process_heading'] }}</h2>
                            @endif

                            <div class="grid grid-cols-2 gap-4">
                                @foreach($page['steps'] as $step)
                                    <div class="bg-[#f2f2f2] p-5 text-center rounded-xl border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all shadow-lg">
                                        <div class="text-3xl font-bold text-[#D4AF37] mb-1">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                                        @if($step['title'] !== '')
                                            <h3 class="font-bold text-[#1e1e1a] text-sm">{{ $step['title'] }}</h3>
                                        @endif
                                        @if($step['body'] !== '')
                                            <p class="text-xs text-[#3a3a34] mt-1">{{ $step['body'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($showExpertise)
                        <div>
                            @if($page['expertise_label'] !== '')
                                <div class="site-kicker"><span aria-hidden="true"></span><p>{{ $page['expertise_label'] }}</p></div>
                            @endif
                            @if($page['expertise_heading'] !== '')
                                <h2 class="text-3xl font-serif font-bold text-[#1e1e1a] mb-6">{{ $page['expertise_heading'] }}</h2>
                            @endif

                            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4">
                                @foreach($page['offerings'] as $offering)
                                    <div class="bg-[#f2f2f2] p-4 text-center rounded-xl border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all shadow-lg">
                                        <div class="text-[#D4AF37] mb-2 flex justify-center text-xl">
                                            <i class="fas {{ $offering['icon'] }}"></i>
                                        </div>
                                        @if($offering['kicker'] !== '')
                                            <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">{{ $offering['kicker'] }}</p>
                                        @endif
                                        @if($offering['title'] !== '')
                                            <p class="text-[11px] font-bold text-[#1e1e1a]">{{ $offering['title'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

    </div>
</section>
@endsection
