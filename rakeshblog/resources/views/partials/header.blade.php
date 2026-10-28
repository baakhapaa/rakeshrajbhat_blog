@php
    $workNavItem = collect($siteSettings['nav_items'] ?? [])->first(function ($item) {
        return \App\Models\Setting::navOpensWorkWithMe($item['url'] ?? '');
    });
@endphp
<header class="fixed top-0 left-0 right-0 z-50 bg-[#0b0e12]/95 backdrop-blur-md border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 lg:px-6 flex items-center gap-4" style="min-height:5rem">
        <a href="{{ route('home') }}" class="shrink-0 text-2xl font-serif font-bold italic tracking-tight text-white inline-flex items-center gap-3">
            @if($siteSettings['site_logo'] ?? null)
                <img src="{{ $siteSettings['site_logo'] }}" alt="{{ $siteSettings['site_name'] }}" class="h-10 w-auto max-w-[180px] object-contain">
            @else
                <span class="text-[#D4AF37]">{{ $siteSettings['site_name'] ?? 'Rakesh Rajbhat' }}</span>
            @endif
        </a>

        <nav class="hidden min-w-0 lg:flex flex-1 flex-wrap justify-center items-center gap-4 xl:gap-8 text-sm font-medium tracking-wide text-gray-300" aria-label="Primary navigation">
            @foreach($siteSettings['nav_items'] ?? [] as $item)
                @continue(\App\Models\Setting::navOpensWorkWithMe($item['url']))
                <a href="{{ \App\Models\Setting::navHref($item['url']) }}" class="nav-link whitespace-nowrap hover:text-[#D4AF37] transition-colors px-1">{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <div class="ml-auto shrink-0 flex items-center gap-3">
            <div id="langSwitch" class="notranslate relative flex shrink-0 items-center gap-1 text-[11px] font-semibold tracking-[0.16em] text-white" translate="no">
                <button type="button" data-set-lang="en" class="lang-option rounded-sm px-1.5 py-1 text-[#D4AF37]" style="color:#D4AF37" aria-pressed="true">EN</button>
                <span style="color:#ffffff" aria-hidden="true">|</span>
                <button type="button" data-set-lang="ne" class="lang-option rounded-sm px-1.5 py-1 text-white" style="color:#e5e7eb" aria-pressed="false">NP</button>
            </div>
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
            @elseif($workNavItem)
                <button type="button" data-open-work="education" class="notranslate inline-flex shrink-0 border border-[#D4AF37] text-[#D4AF37] px-4 py-2 rounded-sm text-xs font-semibold uppercase tracking-widest hover:bg-[#D4AF37] hover:text-[#0b0e12] transition-all" translate="no">{{ $workNavItem['label'] }}</button>
            @endif
            <button type="button" id="mobileMenuToggle" class="lg:hidden inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#D4AF37]" aria-label="Open navigation menu" aria-expanded="false" aria-controls="mobileNavigation">
                <svg id="mobileMenuOpenIcon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="mobileMenuCloseIcon" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <nav id="mobileNavigation" class="hidden lg:hidden border-t border-white/10 bg-[#0b0e12] px-6 py-5" aria-label="Mobile navigation">
        <div class="flex flex-col gap-1">
            @foreach($siteSettings['nav_items'] ?? [] as $item)
                @continue(\App\Models\Setting::navOpensWorkWithMe($item['url']))
                <a href="{{ \App\Models\Setting::navHref($item['url']) }}" class="mobile-nav-link rounded-md px-3 py-3 text-gray-200 hover:bg-white/10 hover:text-[#D4AF37]">{{ $item['label'] }}</a>
            @endforeach
            <div class="notranslate mt-2 flex items-center gap-2 px-3 py-3 text-xs font-semibold tracking-[0.16em] text-white" translate="no">
                <button type="button" data-set-lang="en" class="lang-option text-[#D4AF37]" style="color:#D4AF37">EN</button>
                <span style="color:#ffffff">|</span>
                <button type="button" data-set-lang="ne" class="lang-option text-white" style="color:#e5e7eb">NP</button>
            </div>
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
<style>
    header + main > :first-child { margin-top: var(--site-header-extra, 0px); }
    html { scroll-padding-top: var(--site-header-extra, 0px); }
</style>
<script>
    (function () {
        var header = document.querySelector('header');
        var nav = header && header.querySelector('nav[aria-label="Primary navigation"]');
        if (!header || !nav) return;

        function fitNav() {
            var desktop = window.matchMedia('(min-width: 1024px)').matches;
            nav.style.fontSize = '';
            nav.style.columnGap = '';
            nav.style.rowGap = '';
            nav.style.flexWrap = '';
            document.documentElement.style.setProperty('--site-header-extra', '0px');
            if (!desktop) return;

            var size = 14;
            var gap = 32;
            var guard = 0;
            nav.style.flexWrap = 'nowrap';
            nav.style.fontSize = size + 'px';
            nav.style.columnGap = gap + 'px';
            while (nav.scrollWidth > nav.clientWidth + 1 && guard < 40) {
                guard += 1;
                if (gap > 8) {
                    gap -= 2;
                } else if (size > 12) {
                    size -= 0.5;
                } else {
                    break;
                }
                nav.style.fontSize = size + 'px';
                nav.style.columnGap = gap + 'px';
            }
            if (nav.scrollWidth > nav.clientWidth + 1) {
                nav.style.flexWrap = 'wrap';
                nav.style.rowGap = '0.4rem';
                nav.style.justifyContent = 'center';
            }
            var extra = Math.round(header.getBoundingClientRect().height) - 81;
            if (extra < 8) {
                extra = 0;
            }
            document.documentElement.style.setProperty('--site-header-extra', extra + 'px');
        }

        window.addEventListener('resize', fitNav);
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(fitNav);
        }
        fitNav();
    })();
</script>
