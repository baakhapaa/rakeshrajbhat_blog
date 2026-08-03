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
                <div class="flex items-center gap-4">
                    <span class="text-white/70 text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="border border-red-500/50 text-red-400 px-4 py-2 rounded-sm text-xs font-semibold tracking-widest hover:bg-red-500 hover:text-white transition-all">
                            LOGOUT
                        </button>
                    </form>
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