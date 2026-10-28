@extends('admin.layouts.app')

@section('title', 'Settings · Admin')

@section('content')
@php
    $settingsTab = request('tab', 'profile');
    if (! in_array($settingsTab, ['profile', 'password', 'general', 'navbar', 'footer'], true)) {
        $settingsTab = 'profile';
    }
@endphp
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-serif font-bold text-white mb-6">Settings</h1>

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

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-white/10">
        <button type="button" onclick="switchTab('profile')" id="tabProfile" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $settingsTab === 'profile' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            Profile
        </button>
        <button type="button" onclick="switchTab('password')" id="tabPassword" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $settingsTab === 'password' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            Password
        </button>
        <button type="button" onclick="switchTab('general')" id="tabGeneral" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $settingsTab === 'general' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            General
        </button>
        <button type="button" onclick="switchTab('navbar')" id="tabNavbar" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $settingsTab === 'navbar' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            Navbar
        </button>
        <button type="button" onclick="switchTab('footer')" id="tabFooter" class="px-4 py-2 text-sm font-medium transition border-b-2 {{ $settingsTab === 'footer' ? 'text-[#D4AF37] border-[#D4AF37]' : 'text-white/60 hover:text-white border-transparent' }}">
            Footer
        </button>
    </div>

    <!-- Tab 1: Profile Settings -->
    <div id="profileTab" class="profile-tab {{ $settingsTab === 'profile' ? '' : 'hidden' }}">
        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Profile Settings</h2>
            
            <form action="{{ route('admin.settings.update-profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Picture -->
                <div class="mb-6">
                    <label class="block text-white/70 text-sm font-medium mb-2">Profile Picture</label>
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            @php
                                $admin = Auth::guard('admin')->user();
                                $avatar = $admin->profile_pic ?? null;
                                $initial = strtoupper(substr($admin->name, 0, 1));
                            @endphp
                            
                            @if($avatar)
                                <img id="currentProfilePic" src="{{ $avatar }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-2 border-[#D4AF37]">
                            @else
                                <div id="currentProfilePic" class="w-24 h-24 rounded-full bg-[#D4AF37] text-[#0b0e12] flex items-center justify-center text-3xl font-bold border-2 border-[#D4AF37]">
                                    {{ $initial }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="hidden" onchange="previewProfilePic(event)">
                            <button type="button" onclick="document.getElementById('profile_pic').click()" class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition text-sm">
                                Change Photo
                            </button>
                            <p class="text-xs text-white/30 mt-1">JPG, PNG, GIF (Max 2MB)</p>
                        </div>
                    </div>
                    <div id="profilePicPreview" class="hidden mt-3">
                        <img id="profilePicPreviewImg" src="#" alt="Preview" class="w-24 h-24 rounded-full object-cover border-2 border-[#D4AF37]">
                    </div>
                    @error('profile_pic')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-white/70 text-sm font-medium mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::guard('admin')->user()->name) }}" required
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-white/70 text-sm font-medium mb-2">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::guard('admin')->user()->email) }}" required
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                    Update Profile
                </button>
            </form>
        </div>
    </div>

    <!-- Tab 2: Password Settings -->
    <div id="passwordTab" class="password-tab {{ $settingsTab === 'password' ? '' : 'hidden' }}">
        <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Change Password</h2>

            <form action="{{ route('admin.settings.update-password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="current_password" class="block text-white/70 text-sm font-medium mb-2">Current Password *</label>
                    <input type="password" id="current_password" name="current_password" required
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    @error('current_password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block text-white/70 text-sm font-medium mb-2">New Password *</label>
                    <input type="password" id="new_password" name="new_password" required
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    <p class="text-xs text-white/30 mt-1">Minimum 8 characters</p>
                    @error('new_password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="new_password_confirmation" class="block text-white/70 text-sm font-medium mb-2">Confirm New Password *</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                </div>

                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                    Update Password
                </button>
            </form>
        </div>
    </div>

    <!-- Tab 3: General Settings -->
<div id="generalTab" class="general-tab {{ $settingsTab === 'general' ? '' : 'hidden' }}">
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
        <h2 class="text-xl font-semibold text-white mb-6">General Settings</h2>

        <form action="{{ route('admin.settings.update-general') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Site Name -->
            <div class="mb-4">
                <label for="site_name" class="block text-white/70 text-sm font-medium mb-2">Site Name</label>
                <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? config('app.name', 'Rakesh Rajbhat')) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('site_name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Site Description -->
            <div class="mb-4">
                <label for="site_description" class="block text-white/70 text-sm font-medium mb-2">Site Description</label>
                <textarea id="site_description" name="site_description" rows="3"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('site_description', $settings['site_description'] ?? 'Official website of Rakesh Rajbhat - Founder, Builder, Future Maker') }}</textarea>
                @error('site_description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Site Logo -->
            <div class="mb-4">
                <label for="site_logo" class="block text-white/70 text-sm font-medium mb-2">Site Logo</label>
                
                <!-- Current Logo Preview -->
                @if(isset($settings['site_logo']) && $settings['site_logo'])
                    <div class="mb-3">
                        <img src="{{ $settings['site_logo'] }}" alt="Current Logo" class="h-16 w-auto object-contain border border-white/10 rounded-lg p-2 bg-white/5">
                    </div>
                @endif

                <input type="file" id="site_logo" name="site_logo" accept="image/*" 
                    class="block w-full text-white/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
                <p class="text-xs text-white/30 mt-1">JPG, PNG, SVG (Max 2MB)</p>
                @error('site_logo')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Site Favicon -->
            <div class="mb-6">
                <label for="site_favicon" class="block text-white/70 text-sm font-medium mb-2">Site Favicon</label>
                
                <!-- Current Favicon Preview -->
                @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                    <div class="mb-3">
                        <img src="{{ $settings['site_favicon'] }}" alt="Current Favicon" class="h-8 w-8 object-contain border border-white/10 rounded-lg p-1 bg-white/5">
                    </div>
                @endif

                <input type="file" id="site_favicon" name="site_favicon" accept="image/*" 
                    class="block w-full text-white/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
                <p class="text-xs text-white/30 mt-1">ICO, PNG (Max 1MB)</p>
                @error('site_favicon')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                Update General Settings
            </button>
        </form>
    </div>
</div>

<div id="navbarTab" class="navbar-tab {{ $settingsTab === 'navbar' ? '' : 'hidden' }}">
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
        <h2 class="text-xl font-semibold text-white mb-2">Navbar</h2>
        <p class="text-sm text-white/50 mb-6">Change the public menu label and link. You can add up to 12 items, and the public menu wraps to fit them. Use a section like <span class="text-[#D4AF37]">#projects</span>, a page like <span class="text-[#D4AF37]">/contact</span>, or a full https link. <span class="text-[#D4AF37]">#work-with-me</span> opens the Work With Me popup.</p>

        @error('nav_label')
            <p class="mb-4 text-sm text-red-400">{{ $message }}</p>
        @enderror

        <form action="{{ route('admin.settings.update-navigation') }}" method="POST">
            @csrf
            @method('PUT')

            <div id="navRows" class="space-y-3">
                @foreach($navItems as $item)
                    <div class="nav-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
                        <input type="text" name="nav_label[]" value="{{ $item['label'] }}" maxlength="40" placeholder="Label" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <input type="text" name="nav_url[]" value="{{ $item['url'] }}" maxlength="255" placeholder="#section or /page" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                        <button type="button" class="remove-nav-row px-3 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                <button type="button" id="addNavRow" class="px-4 py-2 rounded-lg border border-white/10 text-white/80 hover:text-white">Add item</button>
                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">Save Navbar</button>
            </div>
        </form>
    </div>
</div>

<div id="footerTab" class="footer-tab {{ $settingsTab === 'footer' ? '' : 'hidden' }}">
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
        <h2 class="text-xl font-semibold text-white mb-2">Footer</h2>
        <p class="text-sm text-white/50 mb-6">The logo, short intro, and copyright show on the left. Socials and pages keep the order you set here. Use <span class="text-[#D4AF37]">{year}</span> in the copyright line for the current year.</p>

        <form action="{{ route('admin.settings.update-footer') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="footer_name" class="block text-sm text-white/70 mb-2">Name</label>
                    <input id="footer_name" type="text" name="footer_name" value="{{ old('footer_name', $footer['name']) }}" maxlength="80" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
                <div>
                    <label for="footer_tagline" class="block text-sm text-white/70 mb-2">Tagline</label>
                    <input id="footer_tagline" type="text" name="footer_tagline" value="{{ old('footer_tagline', $footer['tagline']) }}" maxlength="160" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
            </div>

            <div>
                <label for="footer_intro" class="block text-sm text-white/70 mb-2">Short intro</label>
                <textarea id="footer_intro" name="footer_intro" rows="3" maxlength="400" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">{{ old('footer_intro', $footer['intro']) }}</textarea>
            </div>

            <div>
                <label for="footer_copyright" class="block text-sm text-white/70 mb-2">Copyright</label>
                <input id="footer_copyright" type="text" name="footer_copyright" value="{{ old('footer_copyright', $footer['copyright']) }}" maxlength="160" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
            </div>

            <div>
                <label for="footer_logo" class="block text-sm text-white/70 mb-2">Logo</label>
                @if($footer['logo'])
                    <img src="{{ $footer['logo'] }}" alt="" class="mb-3 h-14 w-auto object-contain rounded bg-white/5 p-2">
                    <label class="mb-3 flex items-center gap-2 text-sm text-white/70">
                        <input type="checkbox" name="remove_footer_logo" value="1" class="accent-[#D4AF37]">
                        Remove logo and show the name instead
                    </label>
                @endif
                <input id="footer_logo" type="file" name="footer_logo" accept="image/*" class="block w-full text-white/70 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20">
                <p class="text-xs text-white/30 mt-1">Optional. JPG, PNG, SVG, or WebP. Max 2MB.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="socials_heading" class="block text-sm text-white/70 mb-2">Socials heading</label>
                    <input id="socials_heading" type="text" name="socials_heading" value="{{ old('socials_heading', $footer['socials_heading']) }}" maxlength="40" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
                <div>
                    <label for="pages_heading" class="block text-sm text-white/70 mb-2">Pages heading</label>
                    <input id="pages_heading" type="text" name="pages_heading" value="{{ old('pages_heading', $footer['pages_heading']) }}" maxlength="40" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
            </div>

            <div>
                <p class="text-sm text-white/70 mb-2">Socials</p>
                <div id="socialRows" class="space-y-3">
                    @foreach($footer['socials'] as $item)
                        <div class="link-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
                            <input type="text" name="social_label[]" value="{{ $item['label'] }}" maxlength="40" placeholder="LinkedIn" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                            <input type="text" name="social_url[]" value="{{ $item['url'] }}" maxlength="255" placeholder="https://" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                            <div class="flex gap-2">
                                <button type="button" class="move-up px-2 py-2 text-white/60 hover:text-white" title="Move up">↑</button>
                                <button type="button" class="move-down px-2 py-2 text-white/60 hover:text-white" title="Move down">↓</button>
                                <button type="button" class="remove-link-row px-2 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addSocialRow" class="mt-3 px-4 py-2 rounded-lg border border-white/10 text-white/80 hover:text-white">Add social</button>
            </div>

            <div>
                <p class="text-sm text-white/70 mb-2">Pages</p>
                <div id="pageRows" class="space-y-3">
                    @foreach($footer['pages'] as $item)
                        <div class="link-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
                            <input type="text" name="page_label[]" value="{{ $item['label'] }}" maxlength="40" placeholder="Contact" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                            <input type="text" name="page_url[]" value="{{ $item['url'] }}" maxlength="255" placeholder="/contact" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                            <div class="flex gap-2">
                                <button type="button" class="move-up px-2 py-2 text-white/60 hover:text-white" title="Move up">↑</button>
                                <button type="button" class="move-down px-2 py-2 text-white/60 hover:text-white" title="Move down">↓</button>
                                <button type="button" class="remove-link-row px-2 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addPageRow" class="mt-3 px-4 py-2 rounded-lg border border-white/10 text-white/80 hover:text-white">Add page</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="newsletter_heading" class="block text-sm text-white/70 mb-2">Newsletter heading</label>
                    <input id="newsletter_heading" type="text" name="newsletter_heading" value="{{ old('newsletter_heading', $footer['newsletter_heading']) }}" maxlength="40" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
                </div>
                <div>
                    <label for="newsletter_note" class="block text-sm text-white/70 mb-2">Newsletter note</label>
                    <textarea id="newsletter_note" name="newsletter_note" rows="3" maxlength="240" required class="w-full h-full min-h-[88px] px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">{{ old('newsletter_note', $footer['newsletter_note']) }}</textarea>
                </div>
            </div>

            <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">Save footer</button>
        </form>
    </div>
</div>

<template id="socialRowTemplate">
    <div class="link-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
        <input type="text" name="social_label[]" value="" maxlength="40" placeholder="YouTube" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <input type="text" name="social_url[]" value="" maxlength="255" placeholder="https://" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <div class="flex gap-2">
            <button type="button" class="move-up px-2 py-2 text-white/60 hover:text-white" title="Move up">↑</button>
            <button type="button" class="move-down px-2 py-2 text-white/60 hover:text-white" title="Move down">↓</button>
            <button type="button" class="remove-link-row px-2 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
        </div>
    </div>
</template>

<template id="pageRowTemplate">
    <div class="link-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
        <input type="text" name="page_label[]" value="" maxlength="40" placeholder="Page" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <input type="text" name="page_url[]" value="" maxlength="255" placeholder="/page or https://" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <div class="flex gap-2">
            <button type="button" class="move-up px-2 py-2 text-white/60 hover:text-white" title="Move up">↑</button>
            <button type="button" class="move-down px-2 py-2 text-white/60 hover:text-white" title="Move down">↓</button>
            <button type="button" class="remove-link-row px-2 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
        </div>
    </div>
</template>

<template id="navRowTemplate">
    <div class="nav-row grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-3 items-center">
        <input type="text" name="nav_label[]" value="" maxlength="40" placeholder="Label" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <input type="text" name="nav_url[]" value="" maxlength="255" placeholder="#section or /page" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none">
        <button type="button" class="remove-nav-row px-3 py-2 text-sm text-red-300 hover:text-red-200">Remove</button>
    </div>
</template>

<script>
    function switchTab(tab) {
        const panels = {
            profile: [document.getElementById('profileTab'), document.getElementById('tabProfile')],
            password: [document.getElementById('passwordTab'), document.getElementById('tabPassword')],
            general: [document.getElementById('generalTab'), document.getElementById('tabGeneral')],
            navbar: [document.getElementById('navbarTab'), document.getElementById('tabNavbar')],
            footer: [document.getElementById('footerTab'), document.getElementById('tabFooter')],
        };

        Object.values(panels).forEach(function (pair) {
            pair[0].classList.add('hidden');
            pair[1].classList.remove('border-[#D4AF37]', 'text-[#D4AF37]');
            pair[1].classList.add('border-transparent', 'text-white/60');
        });

        if (panels[tab]) {
            panels[tab][0].classList.remove('hidden');
            panels[tab][1].classList.add('border-[#D4AF37]', 'text-[#D4AF37]');
            panels[tab][1].classList.remove('border-transparent', 'text-white/60');
        }
    }

    function previewProfilePic(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profilePicPreviewImg');
                const container = document.getElementById('profilePicPreview');
                const currentPic = document.getElementById('currentProfilePic');
                preview.src = e.target.result;
                container.classList.remove('hidden');
                
                // Hide current pic and show preview
                if (currentPic) {
                    currentPic.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const requested = new URLSearchParams(window.location.search).get('tab') || window.location.hash.replace('#', '');
        if (requested === 'password' || requested === 'general' || requested === 'navbar' || requested === 'footer') {
            switchTab(requested);
        } else {
            switchTab('profile');
        }

        const navRows = document.getElementById('navRows');
        const navTemplate = document.getElementById('navRowTemplate');

        function bindNavRow(row) {
            row.querySelector('.remove-nav-row').addEventListener('click', function () {
                if (navRows.querySelectorAll('.nav-row').length === 1) {
                    return;
                }
                row.remove();
            });
        }

        navRows.querySelectorAll('.nav-row').forEach(bindNavRow);

        document.getElementById('addNavRow').addEventListener('click', function () {
            if (navRows.querySelectorAll('.nav-row').length >= 12) {
                return;
            }
            const row = navTemplate.content.firstElementChild.cloneNode(true);
            navRows.appendChild(row);
            bindNavRow(row);
        });

        function bindLinkList(list, template, addButton) {
            function bindRow(row) {
                row.querySelector('.remove-link-row').addEventListener('click', function () {
                    row.remove();
                });
                row.querySelector('.move-up').addEventListener('click', function () {
                    const previous = row.previousElementSibling;
                    if (previous) {
                        list.insertBefore(row, previous);
                    }
                });
                row.querySelector('.move-down').addEventListener('click', function () {
                    const next = row.nextElementSibling;
                    if (next) {
                        list.insertBefore(next, row);
                    }
                });
            }

            list.querySelectorAll('.link-row').forEach(bindRow);
            addButton.addEventListener('click', function () {
                if (list.querySelectorAll('.link-row').length >= 12) {
                    return;
                }
                const row = template.content.firstElementChild.cloneNode(true);
                list.appendChild(row);
                bindRow(row);
            });
        }

        bindLinkList(document.getElementById('socialRows'), document.getElementById('socialRowTemplate'), document.getElementById('addSocialRow'));
        bindLinkList(document.getElementById('pageRows'), document.getElementById('pageRowTemplate'), document.getElementById('addPageRow'));
    });
</script>
@endsection