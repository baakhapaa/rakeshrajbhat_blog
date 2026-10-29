@php
    $workNavItem = collect($siteSettings['nav_items'] ?? [])->first(function ($item) {
        return \App\Models\Setting::navOpensWorkWithMe($item['url'] ?? '');
    });
    $navTagline = trim((string) ($homeContent['eyebrow'] ?? 'Founder · Builder · Future Maker'));
    $workLabel = trim((string) ($workNavItem['label'] ?? 'Work with me'));
    if ($workLabel === '') {
        $workLabel = 'Work with me';
    }
    $navTaglineParts = array_values(array_filter(array_map('trim', preg_split('/\s*[·•|]\s*/u', $navTagline) ?: []), fn ($part) => $part !== ''));
    $headerOverlay = request()->routeIs('home');
@endphp
<header id="siteHeader" class="site-header{{ $headerOverlay ? ' is-overlay' : '' }}">
    <div class="site-header-inner">
        <a href="{{ route('home') }}" class="site-brand">
            <span class="site-brand-name">{{ $siteSettings['site_name'] ?? 'Rakesh Rajbhat' }}</span>
            @if($navTaglineParts)
                <span class="site-brand-tag">
                    @foreach($navTaglineParts as $part)
                        <span>{{ $part }}</span>
                        @if(! $loop->last)
                            <span class="site-brand-dot" aria-hidden="true">•</span>
                        @endif
                    @endforeach
                </span>
            @endif
        </a>

        <nav class="site-nav" aria-label="Primary navigation">
            @foreach($siteSettings['nav_items'] ?? [] as $item)
                @continue(\App\Models\Setting::navOpensWorkWithMe($item['url']))
                <a href="{{ \App\Models\Setting::navHref($item['url']) }}" class="nav-link whitespace-nowrap">{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <div class="site-header-actions">
            <div id="langSwitch" class="site-lang notranslate relative hidden lg:flex shrink-0 items-center gap-1" translate="no">
                <button type="button" data-set-lang="en" class="lang-option is-active" aria-pressed="true">EN</button>
                <span class="lang-divider" aria-hidden="true">|</span>
                <button type="button" data-set-lang="ne" class="lang-option" aria-pressed="false">NP</button>
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
                <button type="button" data-open-work="education" class="site-cta notranslate" translate="no">
                    <span>{{ $workLabel }}</span>
                    <span class="site-cta-icon" aria-hidden="true">
                        <img class="site-cta-icon-a" src="{{ asset('images/hero/figma/nav-arrow-a.svg') }}" alt="">
                        <img class="site-cta-icon-b" src="{{ asset('images/hero/figma/nav-arrow-b.svg') }}" alt="">
                    </span>
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
                <button type="button" data-set-lang="en" class="lang-option is-active" aria-pressed="true">EN</button>
                <span class="lang-divider">|</span>
                <button type="button" data-set-lang="ne" class="lang-option" aria-pressed="false">NP</button>
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
                <button type="button" data-open-work="education" class="mobile-work notranslate" translate="no">
                    <span>{{ $workLabel }}</span>
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M4.5 11.5 11.5 4.5M11.5 4.5H6.5M11.5 4.5V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            @endif
        </div>
    </nav>
</header>
<style>
    :root { --fu: calc(min(100vw, 2305px) / 2305); }
    header + main > :first-child { margin-top: var(--site-header-extra, 0px); }
    html { scroll-padding-top: var(--site-header-extra, 0px); }
    .site-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 50;
        background: #ffffff;
        transition: background-color 0.2s ease;
    }
    .site-header::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 1px;
        background: rgba(179, 104, 85, 0.5);
        pointer-events: none;
    }
    .site-header.is-overlay {
        background: transparent;
        -webkit-backdrop-filter: blur(4px);
        backdrop-filter: blur(4px);
    }
    .site-header.is-overlay.is-scrolled,
    .site-header.is-overlay.is-menu-open { background: rgba(255, 255, 255, 0.96); }
    .site-header-inner {
        width: calc(100% - 40px);
        min-height: 72px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .site-brand {
        flex-shrink: 0;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        color: #000000;
        text-decoration: none;
    }
    .site-brand-name {
        font-family: Poppins, "Plus Jakarta Sans", sans-serif;
        font-weight: 800;
        font-size: 17px;
        line-height: 1;
        letter-spacing: 2px;
        text-transform: uppercase;
        white-space: nowrap;
        color: #000000;
    }
    .site-brand-tag {
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-family: Inter, sans-serif;
        font-weight: 700;
        font-size: 9px;
        line-height: 1.22;
        text-transform: uppercase;
        white-space: nowrap;
        color: #7f2f1a;
    }
    .site-brand-dot {
        font-family: "Space Grotesk", sans-serif;
        font-size: 6px;
        color: #372e23;
    }
    .site-nav { display: none; }
    .site-header-actions {
        margin-left: auto;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .site-lang {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.16em;
        color: #000000;
    }
    .lang-option {
        appearance: none;
        -webkit-appearance: none;
        border: 0;
        background: transparent;
        color: #8a8178;
        font: inherit;
        letter-spacing: inherit;
        line-height: 1;
        cursor: pointer;
        border-radius: 999px;
        padding: 6px 9px;
        transition: color 0.15s ease, background-color 0.15s ease, transform 0.12s ease;
    }
    .lang-option:hover { color: #1c1c1c; }
    .lang-option:active { transform: scale(0.94); }
    .lang-option:focus-visible {
        outline: 2px solid #b36855;
        outline-offset: 2px;
    }
    .lang-option.is-active,
    .lang-option.is-active:hover {
        color: #ffffff;
        font-weight: 800;
        background: #b36855;
    }
    .lang-divider { color: #8a8178; }
    .mobile-work {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        align-self: flex-start;
        gap: 8px;
        width: auto;
        max-width: 100%;
        height: 44px;
        margin-top: 12px;
        padding: 0 18px;
        border: 0;
        border-radius: 999px;
        background: #b36855;
        color: #ffffff;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 14px;
        font-weight: 600;
        line-height: 1;
        white-space: nowrap;
        cursor: pointer;
    }
    .mobile-work svg {
        display: block;
        width: 14px;
        height: 14px;
        flex: none;
    }
    .mobile-work:hover { filter: brightness(1.06); }
    .site-cta {
        display: none;
        align-items: center;
        height: 40px;
        padding: 0 16px;
        border-radius: 9999px;
        background: #b36855;
        color: #ffffff;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-weight: 600;
        font-size: 13px;
        line-height: 1.5;
        letter-spacing: -0.025em;
        white-space: nowrap;
        transition: filter 0.2s ease;
    }
    .site-cta:hover { filter: brightness(1.06); }
    .site-cta-icon {
        position: relative;
        flex-shrink: 0;
        width: 1em;
        height: 1em;
        margin-left: 0.93em;
    }
    .site-cta-icon img { position: absolute; max-width: none; }
    .site-cta-icon-a { left: 9.17%; top: 9.17%; width: 81.67%; height: 81.67%; }
    .site-cta-icon-b { left: 17.5%; top: 9.17%; width: 73.33%; height: 73.33%; }
    @media (min-width: 640px) {
        .site-cta { display: inline-flex; }
    }
    @media (min-width: 1024px) {
        .site-header-inner {
            width: max(calc(1476 * var(--fu)), min(calc(100% - 48px), 960px));
            min-height: max(72px, calc(138 * var(--fu)));
            padding-top: calc(6 * var(--fu));
            gap: 0;
        }
        .site-brand-name {
            font-size: max(17px, calc(31 * var(--fu)));
            line-height: calc(30 / 31);
            letter-spacing: max(2px, calc(4 * var(--fu)));
        }
        .site-brand-tag {
            margin-top: max(5px, calc(11.5 * var(--fu)));
            gap: max(5px, calc(10 * var(--fu)));
            font-size: max(9px, calc(16 * var(--fu)));
        }
        .site-brand-dot { font-size: max(6px, calc(8 * var(--fu))); }
        .site-nav {
            margin-left: auto;
            min-width: 0;
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: flex-end;
            column-gap: clamp(14px, calc(26 * var(--fu)), 26px);
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 500;
            font-size: max(14px, calc(20 * var(--fu)));
            line-height: 1.25;
            color: #000000;
        }
        .site-nav .nav-link {
            color: #000000;
            border-bottom: 1px solid transparent;
            padding-bottom: calc(4 * var(--fu));
            transition: color 0.2s ease;
        }
        .site-nav .nav-link:hover { color: #b36855; }
        .site-nav .nav-link.active { border-bottom-color: #000000; padding-bottom: calc(4 * var(--fu)); }
        .site-header-actions {
            margin-left: max(16px, calc(28 * var(--fu)));
            gap: max(10px, calc(18 * var(--fu)));
        }
        .site-lang { font-size: max(11px, calc(15 * var(--fu))); }
        .site-cta {
            height: max(36px, calc(53 * var(--fu)));
            padding: 0 max(14px, calc(24 * var(--fu)));
            font-size: max(12px, calc(14 * var(--fu)));
            letter-spacing: calc(-0.35 * var(--fu));
        }
    }
</style>
<script>
    (function () {
        var root = document.documentElement;
        var header = document.getElementById('siteHeader');
        var nav = header && header.querySelector('nav[aria-label="Primary navigation"]');
        if (!header || !nav) return;

        function setUnit() {
            root.style.setProperty('--fu', (Math.min(root.clientWidth, 2305) / 2305) + 'px');
        }

        function fitNav() {
            setUnit();
            var desktop = window.matchMedia('(min-width: 1024px)').matches;
            nav.style.fontSize = '';
            nav.style.columnGap = '';
            nav.style.rowGap = '';
            nav.style.flexWrap = '';
            root.style.setProperty('--site-header-extra', '0px');
            if (!desktop) {
                root.dispatchEvent(new CustomEvent('site-header:fit'));
                return;
            }

            var style = window.getComputedStyle(nav);
            var size = parseFloat(style.fontSize);
            var gap = parseFloat(style.columnGap);
            var guard = 0;
            while (nav.scrollWidth > nav.clientWidth + 1 && guard < 60) {
                guard += 1;
                if (gap > 10) {
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
            }
            var extra = Math.round(header.getBoundingClientRect().height) - 81;
            if (extra < 8) {
                extra = 0;
            }
            root.style.setProperty('--site-header-extra', extra + 'px');
            root.dispatchEvent(new CustomEvent('site-header:fit'));
        }

        function onScroll() {
            header.classList.toggle('is-scrolled', window.scrollY > 8);
        }

        var menuToggle = document.getElementById('mobileMenuToggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', function () {
                window.setTimeout(function () {
                    header.classList.toggle('is-menu-open', menuToggle.getAttribute('aria-expanded') === 'true');
                }, 0);
            });
        }

        window.addEventListener('resize', fitNav);
        window.addEventListener('scroll', onScroll, { passive: true });
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(fitNav);
        }
        fitNav();
        onScroll();
    })();
</script>
