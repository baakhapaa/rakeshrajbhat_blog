@php
    $workNavItem = collect($siteSettings['nav_items'] ?? [])->first(function ($item) {
        return \App\Models\Setting::navOpensWorkWithMe($item['url'] ?? '');
    });
    $navTagline = trim((string) ($homeContent['eyebrow'] ?? 'Founder · Builder · Future Maker'));
    $workLabel = trim((string) ($workNavItem['label'] ?? 'Work with me'));
    if ($workLabel === '') {
        $workLabel = 'Work with me';
    }
@endphp
<header class="fixed top-0 left-0 right-0 z-50 bg-white">
    <div class="max-w-[1440px] mx-auto px-5 lg:px-10 flex items-center gap-6" style="min-height:92px">
        <a href="{{ route('home') }}" class="shrink-0 min-w-0 leading-none">
            <span class="block truncate text-[15px] sm:text-[17px] font-bold uppercase tracking-[0.14em] text-[#1c1c1c]">{{ $siteSettings['site_name'] ?? 'Rakesh Rajbhat' }}</span>
            @if($navTagline !== '')
                <span class="mt-1.5 block truncate text-[9px] sm:text-[10px] font-semibold uppercase tracking-[0.16em] text-[#9a4e32]">{{ $navTagline }}</span>
            @endif
        </a>

        <nav class="hidden min-w-0 lg:flex flex-1 flex-wrap justify-center items-center gap-4 xl:gap-8 text-[15px] font-medium text-[#1c1c1c]" aria-label="Primary navigation">
            @foreach($siteSettings['nav_items'] ?? [] as $item)
                @continue(\App\Models\Setting::navOpensWorkWithMe($item['url']))
                <a href="{{ \App\Models\Setting::navHref($item['url']) }}" class="nav-link whitespace-nowrap px-0.5 text-[#1c1c1c] transition-colors hover:text-[#9a4e32]">{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <div class="ml-auto shrink-0 flex items-center gap-3 sm:gap-4">
            <div id="langSwitch" class="notranslate relative hidden lg:flex shrink-0 items-center gap-1 text-[11px] font-semibold tracking-[0.16em] text-[#1c1c1c]" translate="no">
                <button type="button" data-set-lang="en" class="lang-option rounded-sm px-1.5 py-1 text-[#1c1c1c]" style="color:#1c1c1c" aria-pressed="true">EN</button>
                <span class="text-[#8a8178]" aria-hidden="true">|</span>
                <button type="button" data-set-lang="ne" class="lang-option rounded-sm px-1.5 py-1 text-[#8a8178]" style="color:#8a8178" aria-pressed="false">NP</button>
            </div>
            @if(request()->routeIs('blog') || request()->routeIs('blog.show'))
                @auth
                    <div class="relative hidden sm:block group">
                        @php($currentUser = Auth::user())
                        <button type="button" class="user-menu-toggle inline-flex items-center gap-2 text-[#1c1c1c] hover:text-[#9a4e32] text-sm focus:outline-none focus:ring-2 focus:ring-[#9a4e32] rounded-md px-2 py-2" aria-haspopup="true" aria-expanded="false">
                            @if($currentUser->profile_photo_url)
                                <img src="{{ $currentUser->profile_photo_url }}" alt="" class="h-9 w-9 rounded-full object-cover border border-[#c4a484]">
                            @else
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#c4a484] text-white text-xs font-bold" aria-hidden="true">{{ $currentUser->initials }}</span>
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
                    <a href="{{ route('login') }}" class="hidden sm:inline text-[#1c1c1c] hover:text-[#9a4e32] text-sm">Login</a>
                    <a href="{{ route('register') }}" class="hidden sm:inline rounded-full bg-[#c4a484] px-4 py-2 text-xs font-semibold text-white">Sign up</a>
                @endauth
            @else
                <button type="button" data-open-work="education" class="notranslate hidden sm:inline-flex shrink-0 items-center gap-2 rounded-full bg-[#c4a484] px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-[#b8956c]" translate="no">
                    {{ $workLabel }}
                    <svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M4.5 11.5 11.5 4.5M11.5 4.5H6.5M11.5 4.5V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            @endif
            <button type="button" id="mobileMenuToggle" class="lg:hidden inline-flex items-center justify-center rounded-md p-2 text-[#1c1c1c] hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-[#c4a484]" aria-label="Open navigation menu" aria-expanded="false" aria-controls="mobileNavigation">
                <svg id="mobileMenuOpenIcon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="mobileMenuCloseIcon" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <nav id="mobileNavigation" class="hidden lg:hidden border-t border-black/10 bg-white px-6 py-5" aria-label="Mobile navigation">
        <div class="flex flex-col gap-1">
            @foreach($siteSettings['nav_items'] ?? [] as $item)
                @continue(\App\Models\Setting::navOpensWorkWithMe($item['url']))
                <a href="{{ \App\Models\Setting::navHref($item['url']) }}" class="mobile-nav-link rounded-md px-3 py-3 text-[#1c1c1c] hover:bg-black/5 hover:text-[#9a4e32]">{{ $item['label'] }}</a>
            @endforeach
            <div class="notranslate mt-2 flex items-center gap-2 px-3 py-3 text-xs font-semibold tracking-[0.16em] text-[#1c1c1c]" translate="no">
                <button type="button" data-set-lang="en" class="lang-option text-[#1c1c1c]" style="color:#1c1c1c">EN</button>
                <span class="text-[#8a8178]">|</span>
                <button type="button" data-set-lang="ne" class="lang-option text-[#8a8178]" style="color:#8a8178">NP</button>
            </div>
            @if(request()->routeIs('blog') || request()->routeIs('blog.show'))
                @auth
                    <a href="{{ route('profile') }}" class="mobile-nav-link rounded-md px-3 py-3 text-[#1c1c1c] hover:bg-black/5 hover:text-[#9a4e32]">Profile</a>
                    <a href="{{ route('settings') }}" class="mobile-nav-link rounded-md px-3 py-3 text-[#1c1c1c] hover:bg-black/5 hover:text-[#9a4e32]">Settings</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="mobile-nav-link w-full text-left rounded-md px-3 py-3 text-[#1c1c1c] hover:bg-black/5 hover:text-[#9a4e32]">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link rounded-md px-3 py-3 text-[#1c1c1c] hover:bg-black/5 hover:text-[#9a4e32]">Login</a>
                    <a href="{{ route('register') }}" class="mobile-nav-link rounded-md px-3 py-3 text-[#1c1c1c] hover:bg-black/5 hover:text-[#9a4e32]">Sign Up</a>
                @endauth
            @else
                <button type="button" data-open-work="education" class="mobile-nav-link notranslate mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-[#c4a484] px-4 py-3 text-sm font-medium text-white" translate="no">
                    {{ $workLabel }}
                    <svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M4.5 11.5 11.5 4.5M11.5 4.5H6.5M11.5 4.5V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
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
