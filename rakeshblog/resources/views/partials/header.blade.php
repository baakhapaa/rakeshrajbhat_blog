<header class="fixed top-0 left-0 right-0 z-50 bg-[#0b0e12]/95 backdrop-blur-md border-b border-white/5">
    <div class="max-w-7xl mx-auto h-20 px-4 lg:px-6 flex items-center gap-4">
        <a href="{{ route('home') }}" class="shrink-0 text-2xl font-serif font-bold italic tracking-tight text-white inline-flex items-center gap-3">
            @if($siteSettings['site_logo'] ?? null)
                <img src="{{ $siteSettings['site_logo'] }}" alt="{{ $siteSettings['site_name'] }}" class="h-10 w-auto max-w-[180px] object-contain">
            @else
                <span class="text-[#D4AF37]">{{ $siteSettings['site_name'] ?? 'Rakesh Rajbhat' }}</span>
            @endif
        </a>

        <nav class="hidden lg:flex flex-1 justify-center items-center gap-4 xl:gap-7 whitespace-nowrap text-xs xl:text-sm font-medium tracking-wide text-gray-300" aria-label="Primary navigation">
            <a href="{{ route('home') }}#home" class="nav-link hover:text-[#D4AF37] transition-colors">Home</a>
            <a href="{{ route('home') }}#about" class="nav-link hover:text-[#D4AF37] transition-colors">Mission</a>
            <a href="{{ route('home') }}#projects" class="nav-link hover:text-[#D4AF37] transition-colors">Initiatives</a>
            <a href="{{ route('home') }}#impact" class="nav-link hover:text-[#D4AF37] transition-colors">Impact</a>
            <a href="{{ route('home') }}#research" class="nav-link hover:text-[#D4AF37] transition-colors">Ideas &amp; Research</a>
            <a href="{{ route('home') }}#featured-blogs" class="nav-link hover:text-[#D4AF37] transition-colors">Blog</a>
        </nav>

        <div class="shrink-0 flex items-center gap-3">
            @if(request()->routeIs('blog') || request()->routeIs('blog.show'))
                @auth
                    <div class="relative hidden sm:block group">
                        @php($currentUser = Auth::user())
                        <button type="button" class="user-menu-toggle inline-flex items-center gap-2 text-white/80 hover:text-[#D4AF37] text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37] rounded-md px-2 py-2" aria-haspopup="true" aria-expanded="false">
                            @if($currentUser->profile_photo_url)
                                <img src="{{ $currentUser->profile_photo_url }}" alt="" class="h-9 w-9 rounded-full object-cover border border-[#D4AF37]/70">
                            @else
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#D4AF37] text-[#0b0e12] text-xs font-bold" aria-hidden="true">{{ $currentUser->initials }}</span>
                            @endif
                            <svg class="w-4 h-4 transition-transform group-focus-within:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="user-menu-dropdown absolute right-0 top-full mt-2 w-44 rounded-lg border border-gray-200 bg-white p-2 shadow-xl opacity-0 invisible transition group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible" aria-hidden="true">
                            <a href="{{ route('profile') }}" class="block rounded-md px-3 py-2 text-sm text-gray-900 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('settings') }}" class="block rounded-md px-3 py-2 text-sm text-gray-900 hover:bg-gray-100">Settings</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left rounded-md px-3 py-2 text-sm text-gray-900 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline text-white/70 hover:text-[#D4AF37] text-sm">Login</a>
                    <a href="{{ route('register') }}" class="hidden sm:inline border border-[#D4AF37] text-[#D4AF37] px-4 py-2 rounded-sm text-xs font-semibold tracking-widest">SIGN UP</a>
                @endauth
            @else
                <a href="{{ route('work-with-me') }}" class="hidden sm:inline border border-[#D4AF37] text-[#D4AF37] px-4 py-2 rounded-sm text-xs font-semibold tracking-widest hover:bg-[#D4AF37] hover:text-[#0b0e12] transition-all">WORK WITH ME</a>
            @endif
            <button type="button" id="mobileMenuToggle" class="lg:hidden inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#D4AF37]" aria-label="Open navigation menu" aria-expanded="false" aria-controls="mobileNavigation">
                <svg id="mobileMenuOpenIcon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="mobileMenuCloseIcon" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <nav id="mobileNavigation" class="hidden lg:hidden border-t border-white/10 bg-[#0b0e12] px-6 py-5" aria-label="Mobile navigation">
        <div class="flex flex-col gap-1">
            <a href="{{ route('home') }}#home" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Home</a>
            <a href="{{ route('home') }}#projects" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Initiatives</a>
            <a href="{{ route('home') }}#research" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Ideas &amp; Research</a>
            <a href="{{ route('home') }}#impact" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Impact</a>
            <a href="{{ route('home') }}#featured-blogs" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Blog</a>
            <a href="{{ route('work-with-me') }}" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Work With Me</a>
            @if(request()->routeIs('blog') || request()->routeIs('blog.show'))
                @auth
                    <a href="{{ route('profile') }}" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Profile</a>
                    <a href="{{ route('settings') }}" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Settings</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="mobile-nav-link w-full text-left rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Login</a>
                    <a href="{{ route('register') }}" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">Sign Up</a>
                @endauth
            @endif
        </div>
    </nav>
</header>
