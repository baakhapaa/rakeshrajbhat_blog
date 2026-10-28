{{-- Admin sidebar content: logo, nav (Dashboard, Stats, Blogs, Logout). Used in desktop sidebar and mobile drawer. --}}
<div class="px-6 py-4 border-b border-white/5">
    <a href="{{ route('admin.dashboard') }}" class="block">
        <h1 class="text-2xl font-serif font-bold italic text-white">
        <span class="text-[#D4AF37]">Rakesh Rajbhat</span>
        </h1>
        <p class="text-gray-400 text-xs mt-1">Admin Panel</p>
    </a>
</div>

<nav class="mt-8 space-y-2 px-4">
    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Route::currentRouteName() === 'admin.dashboard' ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <i class="fa-solid fa-gauge-high inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
            Dashboard
        </span>
    </a>

    {{-- Home content --}}
    <a href="{{ route('admin.home-content.edit') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Str::startsWith(Route::currentRouteName(), 'admin.home-content') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10">
                </path>
            </svg>
            Home
        </span>
    </a>

    {{-- Stats --}}
    <a href="{{ route('admin.stats.index') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Str::startsWith(Route::currentRouteName(), 'admin.stats') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <i class="fa-solid fa-chart-column inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
            Stats
        </span>
    </a>

    {{-- Team Members --}}
    {{-- <a href="{{ route('admin.team-members.index') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Str::startsWith(Route::currentRouteName(), 'admin.team-members') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5V18a4 4 0 00-5-3.87M17 20H7m10 0v-2a4 4 0 00-4-4H11a4 4 0 00-4 4v2m0 0H2V18a4 4 0 015-3.87M9 7a3 3 0 106 0 3 3 0 00-6 0zm8 2a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM7 9A2.5 2.5 0 112 9a2.5 2.5 0 015 0z">
                </path>
            </svg>
            Team Members
        </span>
    </a> --}}

    {{-- Blogs --}}
    <a href="{{ route('admin.blogs.index') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Str::startsWith(Route::currentRouteName(), 'admin.blogs') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <i class="fa-solid fa-newspaper inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
            Blogs
        </span>
    </a>

    {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.users') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fa-solid fa-users inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                Users
            </span>
        </a>

    {{-- Comments --}}
    <a href="{{ route('admin.comments.index') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Str::startsWith(Route::currentRouteName(), 'admin.comments') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <i class="fa-solid fa-comments inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
            Comments
        </span>
    </a>

    {{-- Activity Logs --}}
        <a href="{{ route('admin.activity.logs') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Route::currentRouteName() === 'admin.activity.logs' ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fa-solid fa-clock-rotate-left inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                Activity Logs
            </span>
        </a>

    {{-- Research Section --}}
        <a href="{{ route('admin.research.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.research') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fa-solid fa-flask inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                Research
            </span>
        </a>
        {{-- Projects --}}
        <a href="{{ route('admin.projects.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.projects') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fa-solid fa-diagram-project inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                Projects
            </span>
        </a>

        {{-- News & Updates --}}
        <a href="{{ route('admin.news.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.news') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fa-solid fa-rss inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                News & Updates
            </span>
        </a>

        {{-- Legal pages --}}
        <a href="{{ route('admin.legal.edit') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.legal') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fa-solid fa-scale-balanced inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                Legal
            </span>
        </a>

        {{-- Gallery --}}
        <a href="{{ route('admin.gallery.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.gallery') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fa-solid fa-images inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                Gallery
            </span>
        </a>

    {{-- Navbar --}}
    <!-- <a href="{{ route('admin.settings', ['tab' => 'navbar']) }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Route::currentRouteName() === 'admin.settings' && request('tab') === 'navbar' ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <i class="fa-solid fa-bars inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
            Navbar
        </span>
    </a> -->

    {{-- Footer --}}
    <!-- <a href="{{ route('admin.settings', ['tab' => 'footer']) }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Route::currentRouteName() === 'admin.settings' && request('tab') === 'footer' ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <i class="fa-solid fa-copyright inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
            Footer
        </span>
    </a> -->

    {{-- Settings --}}
    <a href="{{ route('admin.settings') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Route::currentRouteName() === 'admin.settings' && ! in_array(request('tab'), ['navbar', 'footer'], true) ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <i class="fa-solid fa-gear inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
            Settings
        </span>
    </a>

    {{-- Logout --}}
    <form action="{{ route('admin.logout') }}" method="POST" class="block pt-4 border-t border-white/5">
        @csrf
        <button type="submit"
            class="w-full text-left block px-4 py-3 rounded-lg hover:bg-red-500/10 transition-all duration-200 text-gray-300 hover:text-red-400">
            <span class="flex items-center">
                <i class="fa-solid fa-right-from-bracket inline-block w-5 text-center text-base mr-3" aria-hidden="true"></i>
                Logout
            </span>
        </button>
    </form>
</nav>