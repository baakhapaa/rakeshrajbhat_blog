<header class="fixed top-0 left-0 right-0 z-50 bg-[#0b0e12]/95 backdrop-blur-md border-b border-white/5">
    <div class="max-w-7xl mx-auto h-20 px-6 flex items-center justify-between">
        <!-- Left side - Logo -->
        <a href="{{ route('home') }}" class="text-2xl font-serif font-bold italic tracking-tight text-white">
            R <span class="text-[#D4AF37]">Rakesh Rajbhat</span>
        </a>
        
        <!-- Center - Navigation -->
        <nav class="hidden md:flex items-center space-x-8 text-sm font-medium tracking-wide text-gray-300">
            <a href="{{ route('home') }}#home" class="border-b-2 border-[#D4AF37] text-[#D4AF37] pb-1 nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('home') }}#about" class="hover:text-[#D4AF37] transition-colors nav-link">About</a>
            <a href="{{ route('home') }}#projects" class="hover:text-[#D4AF37] transition-colors nav-link">Projects</a>
            <a href="{{ route('home') }}#impact" class="hover:text-[#D4AF37] transition-colors nav-link">Impact</a>
            <a href="{{ route('home') }}#research" class="hover:text-[#D4AF37] transition-colors nav-link">Research</a>
            {{-- <a href="{{ route('home') }}#media" class="hover:text-[#D4AF37] transition-colors nav-link">Media</a> --}}
            <a href="{{ route('blog') }}" class="hover:text-[#D4AF37] transition-colors blog-link {{ request()->routeIs('blog') ? 'text-[#D4AF37] border-b-2 border-[#D4AF37] pb-1' : '' }}">Blog</a>
        </nav>
        <!-- Right side - Conditional Button -->
        @if(request()->routeIs('blog'))
            <!-- Show Login/Signup on Blog Page -->
           @auth
        <div class="relative group">
    <!-- User Button -->
        <button class="flex items-center gap-2 text-white hover:text-[#D4AF37] transition">
            <div class="w-9 h-9 rounded-full bg-[#D4AF37] text-[#0b0e12] flex items-center justify-center font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span class="hidden sm:block text-sm">
                {{ Auth::user()->name }}
            </span>
            <svg class="w-4 h-4 transition-transform group-hover:rotate-180"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Dropdown -->
        <div class="absolute right-0 mt-3 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="px-4 py-3 border-b">
                <p class="text-sm font-semibold text-gray-800">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ Auth::user()->email }}
                </p>
            </div>
            <a href="{{ route('profile') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#D4AF37] transition">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile
            </a>
            <a href="{{ route('settings') }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#D4AF37] transition">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-white/70 hover:text-[#D4AF37] transition-colors text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="border border-[#D4AF37] text-[#D4AF37] px-5 py-2 rounded-sm text-xs font-semibold tracking-widest hover:bg-[#D4AF37] hover:text-[#0b0e12] transition-all">
                        SIGN UP
                    </a>
                </div>
            @endauth
        @else
            <!-- Show WORK WITH ME on Home Page and other pages -->
            <a href="#" class="border border-[#D4AF37] text-[#D4AF37] px-5 py-2 rounded-sm text-xs font-semibold tracking-widest hover:bg-[#D4AF37] hover:text-[#0b0e12] transition-all">
                WORK WITH ME
            </a>
        @endif
    </div>
</header>