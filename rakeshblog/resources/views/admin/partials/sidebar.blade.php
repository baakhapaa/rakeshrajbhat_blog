{{-- Admin sidebar content: logo, nav (Dashboard, Stats, Blogs, Logout). Used in desktop sidebar and mobile drawer. --}}
<div class="px-6 py-4 border-b border-white/5">
    <a href="{{ route('admin.dashboard') }}" class="block">
        <h1 class="text-2xl font-serif font-bold italic text-white">
        ER <span class="text-[#D4AF37]">Rakesh Rajbhat</span>
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
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m0 0V9">
                </path>
            </svg>
            Dashboard
        </span>
    </a>

    {{-- Stats --}}
    {{-- <a href="{{ route('admin.stats.index') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Str::startsWith(Route::currentRouteName(), 'admin.stats') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
            Stats
        </span>
    </a> --}}

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
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z">
                </path>
            </svg>
            Blogs
        </span>
    </a>

    {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.users') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a4 4 0 0 0-4-4h-1M9 20H4v-2a4 4 0 0 1 4-4h1m4-4a4 4 0 1 0-2 0 4 4 0 0 0 2 0zm6 0a3 3 0 1 0-6 0 3 3 0 0 0 6 0z">
                    </path>
                </svg>
                Users
            </span>
        </a>

    {{-- Comments --}}
    <a href="{{ route('admin.comments.index') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Str::startsWith(Route::currentRouteName(), 'admin.comments') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h8M8 14h5m7 7H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z"/>
            </svg>
            Comments
        </span>
    </a>

    {{-- Activity Logs --}}
        <a href="{{ route('admin.activity.logs') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Route::currentRouteName() === 'admin.activity.logs' ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fas fa-history w-5 h-5 mr-3"></i>
                Activity Logs
            </span>
        </a>

    {{-- Research Section --}}
        <a href="{{ route('admin.research.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.research') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fas fa-flask w-5 h-5 mr-3"></i>
                Research
            </span>
        </a>
        {{-- Projects --}}
        <a href="{{ route('admin.projects.index') }}"
            class="block px-4 py-3 rounded-lg transition-all duration-200
            {{ Str::startsWith(Route::currentRouteName(), 'admin.projects') ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <span class="flex items-center">
                <i class="fas fa-project-diagram w-5 h-5 mr-3"></i>
                Projects
            </span>
        </a>

    {{-- Settings --}}
    <a href="{{ route('admin.settings') }}"
        class="block px-4 py-3 rounded-lg transition-all duration-200
        {{ Route::currentRouteName() === 'admin.settings' ? 'bg-[#D4AF37]/10 text-[#D4AF37] border-r-2 border-[#D4AF37]' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
        <span class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </span>
    </a>

    {{-- Logout --}}
    <form action="{{ route('admin.logout') }}" method="POST" class="block pt-4 border-t border-white/5">
        @csrf
        <button type="submit"
            class="w-full text-left block px-4 py-3 rounded-lg hover:bg-red-500/10 transition-all duration-200 text-gray-300 hover:text-red-400">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H7a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </span>
        </button>
    </form>
</nav>