@extends('layouts.app')

@section('title', 'Rakesh Rajbhat · Portfolio')

@section('title', 'Rakesh Rajbhat | Technology Entrepreneur & Youth Development Builder')
@section('meta_description', 'Official website of Rakesh Rajbhat, founder of Baakhapaa and builder of Skill Sikka, Hillychilly, Future Builders and AI & ICT programs in Nepal.')

@section('content')
    @php
        $homeContent = $homeContent ?? \App\Models\Setting::getHomeContent();
        $aboutContent = \App\Models\Setting::getAboutContent();
    @endphp
    <!-- Hero Section — Figma frame 8 (2305 × 1119) -->
    <section id="home" class="hero-stage">
        <style>
            .hero-stage {
                background: #ffffff;
                margin-top: 0 !important;
                padding-top: 0;
            }
            .hero-fit {
                width: min(2305px, 100%);
                margin: 0 auto;
                position: relative;
                overflow: hidden;
                background: #ffffff;
            }
            .hero-canvas {
                width: 2305px;
                height: 1331px;
                position: absolute;
                left: 0;
                top: 0;
                transform-origin: top left;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                color: #111111;
                background: #ffffff;
            }
            .hero-canvas > * { position: absolute; }
            .hero-cubes {
                background-image: url("{{ asset('images/hero/hero-cubes.jpg') }}");
                background-repeat: repeat-y;
                opacity: 0.1;
                filter: contrast(1.5) brightness(1.25);
                pointer-events: none;
            }
            .hero-cubes-a {
                inset: 0;
                background-size: 5239px 11342px;
                background-position: -1467px 0;
                animation: heroCubesA 360s linear infinite;
            }
            .hero-cubes-b {
                left: 7px;
                top: 0;
                width: 2298px;
                height: 1331px;
                background-size: 2298px 5802px;
                background-position: 0 -2292px;
                animation: heroCubesB 190s linear infinite;
            }
            @keyframes heroCubesA { to { background-position: -1467px 11342px; } }
            @keyframes heroCubesB { to { background-position: 0 3510px; } }
            .hero-warm {
                left: 227px;
                top: 795px;
                width: 1922px;
                height: 274px;
                background: rgba(179, 104, 85, 0.06);
                filter: blur(82.3px);
                pointer-events: none;
            }
            .hero-glow,
            .hero-haze,
            .hero-arc {
                max-width: none;
                pointer-events: none;
                user-select: none;
            }
            .hero-glow { left: 1019.4px; top: 74.4px; }
            .hero-haze-a { left: -271.8px; top: -674.8px; }
            .hero-haze-b { left: 1401.2px; top: -764.8px; }
            .hero-portrait {
                left: 834.08px;
                top: 187.34px;
                width: 1154.061px;
                height: 930.639px;
                overflow: hidden;
                transform: rotate(0.13deg);
                pointer-events: none;
            }
            .hero-portrait img {
                position: absolute;
                left: -6.1%;
                top: -39.52%;
                width: 121.45%;
                height: 155.05%;
                max-width: none;
                user-select: none;
            }
            /* Canvas units scale with the hero; dividing by --hero-scale gives real-pixel sizes and minimums. */
            .hero-copy {
                left: calc(415px + var(--hero-shift, 0px));
                top: 254px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            .hero-lead {
                margin: 0 0 0.3em;
                font-family: Poppins, "Plus Jakarta Sans", sans-serif;
                font-size: max(38px, calc(16px / var(--hero-scale, 1)));
                font-weight: 500;
                line-height: 1.3;
                letter-spacing: -0.033em;
                color: #111111;
                white-space: nowrap;
            }
            .hero-title {
                margin: 0 0 0 4px;
                font-family: Poppins, "Plus Jakarta Sans", sans-serif;
                font-size: max(81px, calc(34px / var(--hero-scale, 1)));
                font-weight: 600;
                line-height: 1;
                letter-spacing: -0.016em;
                color: #111111;
                white-space: nowrap;
            }
            .hero-title span { display: block; }
            .hero-body {
                max-width: calc(1200px - 415px - var(--hero-shift, 0px));
                margin: max(36px, calc(16px / var(--hero-scale, 1))) 0 0 3px;
                font-size: max(21px, calc(13.5px / var(--hero-scale, 1)));
                font-weight: 400;
                line-height: 1.7;
                letter-spacing: 0.095em;
                color: #59554f;
            }
            .hero-body span { display: block; }
            .hero-body .hero-body-lead { font-weight: 500; }
            .hero-body strong { font-weight: 700; }
            .hero-body .hero-body-note { font-style: italic; color: #46433f; }
            .hero-actions {
                margin: max(44px, calc(22px / var(--hero-scale, 1))) 0 0 4px;
                display: flex;
                align-items: center;
                gap: calc(12px / var(--hero-scale, 1));
            }
            .hero-btn {
                height: calc(var(--btn-h) / var(--hero-scale, 1));
                padding: 0 calc(var(--btn-px) / var(--hero-scale, 1));
                border-radius: 9999px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: calc(10px / var(--hero-scale, 1));
                font-size: calc(var(--btn-fs) / var(--hero-scale, 1));
                line-height: 1;
                text-decoration: none;
                white-space: nowrap;
            }
            .hero-btn-primary {
                background: #b36855;
                color: #faf7f2;
                font-weight: 700;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12), 0 2px 4px -2px rgba(0, 0, 0, 0.43);
            }
            .hero-btn-primary:hover { filter: brightness(1.05); }
            .hero-btn-primary img { width: calc(10px / var(--hero-scale, 1)); height: auto; }
            .hero-btn-secondary {
                color: #000000;
                font-weight: 600;
                border: calc(1px / var(--hero-scale, 1)) solid #d5cec2;
            }
            .hero-btn-secondary:hover { background: rgba(255, 255, 255, 0.35); }
            .hero-glass {
                -webkit-backdrop-filter: blur(4px);
                backdrop-filter: blur(4px);
                box-shadow:
                    inset 1.5px 1.5px 1px rgba(255, 255, 255, 0.85),
                    inset -1px -1px 1px rgba(255, 255, 255, 0.45),
                    0 6px 20px -8px rgba(0, 0, 0, 0.12);
            }
            .hero-tag {
                left: calc(415px + var(--hero-shift, 0px));
                top: 941px;
                margin: 0;
                padding: 0.6em 1.9em;
                border-radius: 9999px;
                background: rgba(217, 217, 217, 0.2);
                font-family: Poppins, "Plus Jakarta Sans", sans-serif;
                font-size: max(18px, calc(11px / var(--hero-scale, 1)));
                font-weight: 500;
                line-height: 1.7;
                letter-spacing: 0.055em;
                text-transform: uppercase;
                white-space: pre;
                color: #000000;
            }
            .hero-arc-1 { left: 1232.86px; top: 263.89px; }
            .hero-arc-2 { left: 1064.05px; top: 325.27px; }
            .hero-arc-3 {
                left: 1086.14px;
                top: 566.22px;
                width: 840.858px;
                height: 318.517px;
                transform: rotate(-7.48deg);
            }
            .hero-arc-3 img { position: absolute; left: -1.09px; top: -1.08px; max-width: none; }
            .hero-badge {
                width: 45px;
                height: 45px;
                animation: heroBadgeFloat 4.8s ease-in-out infinite;
                pointer-events: none;
            }
            .hero-badge > span {
                position: absolute;
                inset: 0;
            }
            .hero-badge img {
                position: absolute;
                left: -250px;
                top: -250px;
                max-width: none;
                user-select: none;
            }
            .hero-badge-baakhapaa { left: 1871.29px; top: 470.19px; }
            .hero-badge-baakhapaa > span { transform: rotate(-10.48deg); }
            .hero-badge-hillychilly { left: 1406.11px; top: 285px; animation-delay: -1.6s; }
            .hero-badge-hillychilly > span { transform: rotate(-22.58deg); }
            .hero-badge-skillsikka { left: 1801.57px; top: 220.48px; width: 47px; height: 47px; animation-delay: -3.2s; }
            .hero-badge-skillsikka > span { transform: rotate(-16.37deg); }
            @keyframes heroBadgeFloat {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }
            @keyframes heroCubesM { to { background-position: 50% 1688px; } }
            @media (max-width: 1023px) {
                .hero-fit { height: auto !important; }
                #heroCanvas {
                    position: relative;
                    width: auto;
                    height: auto;
                    transform: none !important;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    padding: clamp(32px, 6vw, 56px) var(--site-edge) 0;
                    overflow: hidden;
                }
                #heroCanvas > * {
                    position: relative;
                    left: auto;
                    top: auto;
                    width: auto;
                    z-index: 1;
                }
                #heroCanvas > .hero-cubes-a {
                    position: absolute;
                    inset: 0;
                    width: auto;
                    z-index: 0;
                    background-repeat: repeat;
                    background-size: 780px 1688px;
                    background-position: 50% 0;
                    animation-name: heroCubesM;
                    animation-duration: 120s;
                }
                #heroCanvas > .hero-cubes-b,
                #heroCanvas > .hero-glow,
                #heroCanvas > .hero-haze,
                #heroCanvas > .hero-arc,
                #heroCanvas > .hero-badge,
                #heroCanvas > .hero-warm { display: none; }
                #heroCanvas > .hero-copy { order: 1; }
                #heroCanvas .hero-lead {
                    margin: 0;
                    font-size: clamp(18px, 2.4vw + 9px, 24px);
                    line-height: 1.35;
                    letter-spacing: -0.4px;
                    white-space: normal;
                }
                #heroCanvas .hero-title {
                    margin: 8px 0 0;
                    font-size: clamp(34px, 8.6vw, 64px);
                    line-height: 1.08;
                    letter-spacing: -0.8px;
                    white-space: normal;
                }
                #heroCanvas .hero-body {
                    margin: 18px 0 0;
                    max-width: 640px;
                    font-size: clamp(15px, 0.5vw + 13px, 17px);
                    line-height: 1.7;
                    letter-spacing: 0.5px;
                }
                #heroCanvas .hero-body .hero-body-note { margin-top: 4px; }
                #heroCanvas .hero-actions {
                    margin: 28px 0 0;
                    flex-wrap: wrap;
                    gap: 12px;
                }
                #heroCanvas > .hero-tag {
                    order: 5;
                    margin-top: 28px;
                    padding: 11px 20px;
                    font-size: 11px;
                    line-height: 1.6;
                    letter-spacing: 0.6px;
                    word-spacing: 2px;
                    white-space: normal;
                    text-wrap: balance;
                }
                @media (min-width: 560px) {
                    #heroCanvas > .hero-tag { font-size: 13px; white-space: pre-wrap; }
                }
                #heroCanvas > .hero-portrait {
                    order: 6;
                    align-self: center;
                    width: calc(100% + 2 * var(--site-gutter));
                    max-width: 760px;
                    height: auto;
                    aspect-ratio: 1154.061 / 930.639;
                    margin: 28px calc(-1 * var(--site-gutter)) 0;
                    transform: none;
                }
            }
            .hero-lead,
            .hero-title span,
            .hero-body,
            .hero-actions,
            .hero-tag {
                animation: heroRise 0.9s cubic-bezier(0.22, 1, 0.36, 1) both;
            }
            .hero-lead { animation-delay: 0.05s; }
            .hero-title span:nth-child(1) { animation-delay: 0.15s; }
            .hero-title span:nth-child(2) { animation-delay: 0.25s; }
            .hero-body { animation-delay: 0.4s; }
            .hero-actions { animation-delay: 0.5s; }
            .hero-tag { animation-delay: 0.65s; }
            .hero-portrait { animation: heroPortraitIn 1.3s cubic-bezier(0.22, 1, 0.36, 1) 0.1s both; }
            .hero-btn { transition: filter 0.2s ease, background-color 0.2s ease, translate 0.25s ease; }
            .hero-btn:hover { translate: 0 -2px; }
            .hero-btn-primary img { transition: translate 0.25s ease; }
            .hero-btn-primary:hover img { translate: 4px 0; }
            @keyframes heroRise {
                from { opacity: 0; translate: 0 32px; }
                to { opacity: 1; translate: 0 0; }
            }
            @keyframes heroPortraitIn {
                from { opacity: 0; scale: 1.05; }
                to { opacity: 1; scale: 1; }
            }
            @media (prefers-reduced-motion: reduce) {
                .hero-cubes,
                .hero-badge,
                .hero-lead,
                .hero-title span,
                .hero-body,
                .hero-actions,
                .hero-tag,
                .hero-portrait { animation: none; }
            }
        </style>
        @php
            $heroLead = trim((string) ($homeContent['headline_line_1'] ?? ''));
            $heroLine2 = trim((string) ($homeContent['headline_line_2'] ?? ''));
            $heroLine3 = trim((string) ($homeContent['headline_line_3'] ?? ''));
            if ($heroLead !== '' && preg_match('/^for\s+/i', $heroLine2)) {
                $heroLead = rtrim($heroLead, " :") . ' for:';
                $heroLine2 = preg_replace('/^for\s+/i', '', $heroLine2);
            }
            if (preg_match('/^and\s+/i', $heroLine3)) {
                $heroLine3 = '& ' . preg_replace('/^and\s+/i', '', $heroLine3);
            }
            $heroIntro = trim((string) ($homeContent['intro'] ?? ''));
            $heroIntroParts = preg_split('/(?<=\.)\s+/', $heroIntro, 2) ?: [];
            $heroIntroFirst = trim((string) ($heroIntroParts[0] ?? ''));
            $heroIntroSecond = trim((string) ($heroIntroParts[1] ?? ''));
            $heroIntroLead = '';
            if (preg_match('/^(Founder of)\s+(.+)$/i', $heroIntroFirst, $heroIntroMatch)) {
                $heroIntroLead = $heroIntroMatch[1];
                $heroIntroFirst = preg_replace('/\s+and\s+(?=[^,]+\.?$)/i', ' & ', $heroIntroMatch[2]);
            }
            $heroTagline = preg_replace('/\.\s+/', '.    ', trim((string) ($homeContent['tagline'] ?? '')));
        @endphp
        <div id="heroAlign" class="site-container" aria-hidden="true"></div>
        <div id="heroFit" class="hero-fit">
            <div id="heroCanvas" class="hero-canvas">
                <div class="hero-cubes hero-cubes-a" aria-hidden="true"></div>
                <div class="hero-cubes hero-cubes-b" aria-hidden="true"></div>
                <div class="hero-warm" aria-hidden="true"></div>
                <img class="hero-glow" src="{{ asset('images/hero/figma/ellipse9.svg') }}" alt="" width="1769" height="1692">
                <div class="hero-portrait">
                    <img src="{{ asset('images/hero/hero-portrait.png') }}" alt="{{ $homeContent['name'] }}">
        </div>
                <div class="hero-copy">
                @if($heroLead !== '')
                    <p class="hero-lead">{{ $heroLead }}</p>
                @endif
                @if($heroLine2 !== '' || $heroLine3 !== '')
                    <h1 class="hero-title">
                        @if($heroLine2 !== '')
                            <span>{{ $heroLine2 }}</span>
                        @endif
                        @if($heroLine3 !== '')
                            <span>{{ $heroLine3 }}</span>
                        @endif
                    </h1>
                @endif
                @if($heroIntro !== '')
                    @if($heroIntroSecond !== '' || $heroIntroLead !== '')
                        <p class="hero-body">
                            <span>@if($heroIntroLead !== '')<span class="hero-body-lead" style="display:inline">{{ $heroIntroLead }}</span> <strong>{{ $heroIntroFirst }}</strong>@else{{ $heroIntroFirst }}@endif</span>
                            @if($heroIntroSecond !== '')
                                <span class="hero-body-note">{{ $heroIntroSecond }}</span>
                            @endif
                        </p>
                    @else
                        <p class="hero-body is-plain">{{ $heroIntro }}</p>
                    @endif
                @endif
                <div class="hero-actions">
                    @if(filled($homeContent['primary_button_label']))
                        <a href="{{ \App\Models\Setting::linkHref($homeContent['primary_button_url']) }}" @if(str_starts_with((string) $homeContent['primary_button_url'], 'http')) target="_blank" rel="noopener noreferrer" @endif class="hero-btn hero-btn-primary">
                            {{ $homeContent['primary_button_label'] }}
                            <img src="{{ asset('images/hero/figma/arrow.svg') }}" alt="" width="9.46875" height="3.75">
                        </a>
                    @endif
                    @if(filled($homeContent['text_link_label']))
                        <a href="{{ \App\Models\Setting::linkHref($homeContent['text_link_url']) }}" @if(str_starts_with((string) $homeContent['text_link_url'], 'http')) target="_blank" rel="noopener noreferrer" @endif class="hero-btn hero-btn-secondary hero-glass">
                            {{ $homeContent['text_link_label'] }}
                        </a>
                    @endif
                </div>
                </div>
                <div class="hero-badge hero-badge-baakhapaa" aria-hidden="true"><span><img src="{{ asset('images/hero/figma/badge-baakhapaa.png') }}" alt="" width="545" height="545"></span></div>
                <div class="hero-badge hero-badge-hillychilly" aria-hidden="true"><span><img src="{{ asset('images/hero/figma/badge-hillychilly.png') }}" alt="" width="545" height="545"></span></div>
                <div class="hero-badge hero-badge-skillsikka" aria-hidden="true"><span><img src="{{ asset('images/hero/figma/badge-skillsikka.png') }}" alt="" width="547" height="547"></span></div>
                <img class="hero-arc hero-arc-1" src="{{ asset('images/hero/figma/arc-1.svg') }}" alt="" width="608.976" height="720.521">
                <img class="hero-arc hero-arc-2" src="{{ asset('images/hero/figma/arc-2.svg') }}" alt="" width="410.827" height="549.7">
                <div class="hero-arc hero-arc-3" aria-hidden="true"><img src="{{ asset('images/hero/figma/arc-3.svg') }}" alt="" width="843.457" height="321.101"></div>
                <img class="hero-haze hero-haze-a" src="{{ asset('images/hero/figma/ellipse8.svg') }}" alt="" width="1281" height="1281">
                @if($heroTagline !== '')
                    <p class="hero-tag hero-glass">{{ $heroTagline }}</p>
                @endif
                <img class="hero-haze hero-haze-b" src="{{ asset('images/hero/figma/ellipse8.svg') }}" alt="" width="1281" height="1281">
                </div>
                </div>
        <script>
            (function () {
                var stage = document.querySelector('.hero-stage');
                var fit = document.getElementById('heroFit');
                var canvas = document.getElementById('heroCanvas');
                var header = document.getElementById('siteHeader');
                var align = document.getElementById('heroAlign');
                if (!stage || !fit || !canvas) return;
                var stacked = window.matchMedia('(max-width: 1023px)');
                function applyHeroScale() {
                    if (stacked.matches) {
                        canvas.style.transform = '';
                        canvas.style.removeProperty('--hero-scale');
                        canvas.style.removeProperty('--hero-shift');
                        fit.style.height = '';
                        stage.style.paddingTop = Math.round(header ? header.getBoundingClientRect().height : 0) + 'px';
                        return;
                    }
                    var scale = fit.clientWidth / 2305;
                    canvas.style.transform = 'scale(' + scale + ')';
                    canvas.style.setProperty('--hero-scale', scale.toFixed(4));
                    if (align) {
                        var columnLeft = (align.getBoundingClientRect().left - fit.getBoundingClientRect().left) / scale;
                        canvas.style.setProperty('--hero-shift', (columnLeft - 415).toFixed(2) + 'px');
                    }
                    fit.style.height = Math.round(1331 * scale) + 'px';
                    var headerHeight = header ? header.getBoundingClientRect().height : 0;
                    stage.style.paddingTop = Math.max(0, Math.round(headerHeight - 138 * scale)) + 'px';
                }
                applyHeroScale();
                window.addEventListener('resize', applyHeroScale);
                document.documentElement.addEventListener('site-header:fit', applyHeroScale);
            })();
        </script>
    </section>
    
    <!-- About Me -->
    <section id="about-me" class="about-reveal scroll-mt-20 text-[#1b1c1a]">
        <div class="about-card">
            <div class="about-grid">
                <div class="about-reveal-text">
                    <div class="about-label">
                        <span class="about-label-rule" aria-hidden="true"></span>
                        <p>{{ $aboutContent['label'] }}</p>
                </div>
                    <h2 class="about-heading">
                        {{ $aboutContent['heading_line_1'] }}@if(filled($aboutContent['heading_line_2'])) {{ $aboutContent['heading_line_2'] }}@endif
                    </h2>
                    @php
                        $aboutSecond = trim((string) ($aboutContent['paragraph_2'] ?? ''));
                        $aboutThird = trim((string) ($aboutContent['paragraph_3'] ?? ''));
                        if ($aboutSecond !== '' && $aboutThird !== '' && str_contains($aboutSecond, $aboutThird)) {
                            $aboutSecond = trim(str_replace($aboutThird, '', $aboutSecond));
                        }
                    @endphp
                    <div class="about-copy">
                        <div class="about-quote-box">
                            <p class="about-quote">{{ $aboutContent['paragraph_1'] }}</p>
                        </div>
                        @if($aboutSecond !== '')
                            <p class="about-body">{{ $aboutSecond }}</p>
                        @endif
                        @if($aboutThird !== '')
                            <p class="about-note">{{ $aboutThird }}</p>
                        @endif
                        </div>
                    @if(filled($aboutContent['button_label']))
                        <div class="about-action">
                            <a href="{{ \App\Models\Setting::linkHref($aboutContent['button_url'] ?: '#projects') }}" @if(str_starts_with((string) $aboutContent['button_url'], 'http')) target="_blank" rel="noopener noreferrer" @endif class="about-btn site-btn">
                                <span>{{ $aboutContent['button_label'] }}</span>
                                <img src="{{ asset('images/about-arrow.svg') }}" alt="" width="9.46875" height="3.75">
                            </a>
                    </div>
                    @endif
                        </div>
                <div class="about-reveal-media">
                    @php
                        $aboutMediaClass = 'about-photo';
                    @endphp
                    @if(!empty($aboutContent['media_url']) && ($aboutContent['media_type'] ?? null) === 'video')
                        <div class="about-portrait">
                            <video
                                id="aboutPortraitVideo"
                                @if(!empty($aboutContent['media_poster'])) poster="{{ $aboutContent['media_poster'] }}" @endif
                                data-src="{{ $aboutContent['media_url'] }}"
                                muted
                                loop
                                playsinline
                                preload="none"
                                class="{{ $aboutMediaClass }}"
                            ></video>
                            <button type="button" id="aboutPortraitSound" aria-pressed="false" aria-label="Turn sound on">
                                <i class="fa-solid fa-volume-xmark" aria-hidden="true"></i>
                            </button>
                        </div>
                    @else
                        <img
                            src="{{ !empty($aboutContent['media_url']) ? $aboutContent['media_url'] : asset('images/rakeshrajbhat.jpg') }}"
                            alt="{{ $homeContent['name'] ?? 'Rakesh Rajbhat' }}"
                            class="{{ $aboutMediaClass }}"
                        >
                    @endif
                    </div>
                        </div>
                        </div>
    </section>
    <style>
        #about-me {
            position: relative;
            overflow-x: clip;
            padding: 0 0 24px;
            background: linear-gradient(to bottom, #e9e9e9 0, #e9e9e9 96px, #f3f3f3 96px, #f3f3f3 100%);
            font-family: "Plus Jakarta Sans", sans-serif;
        }
        .about-card {
            position: relative;
            margin: 0 auto;
            padding: 40px var(--site-edge) 48px;
            background: #fbf9f6;
            border-bottom: 1px solid #efeeeb;
            box-shadow: 0 18px 50px -12px rgba(0, 0, 0, 0.28), 0 4px 14px rgba(0, 0, 0, 0.08);
        }
        .about-grid { display: grid; gap: 40px; }
        .about-label { display: flex; align-items: center; gap: 8px; }
        .about-label-rule { display: block; flex-shrink: 0; width: 24px; height: 2px; background: #89351d; }
        .about-label p {
            margin: 0;
            font-family: "Space Grotesk", sans-serif;
            font-size: var(--kicker-size);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            color: #89351d;
        }
        .about-heading {
            margin: 0;
            padding-top: var(--kicker-gap);
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: var(--heading-size);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: #1b1c1a;
        }
        .about-copy { display: flex; flex-direction: column; gap: 32px; padding-top: 32px; }
        .about-quote-box {
            border-left: 4px solid #89351d;
            border-radius: 16px;
            background: #f5f3f0;
            padding: 20px 20px 20px 24px;
        }
        .about-quote { margin: 0; font-size: 22px; font-weight: 700; line-height: 1.35; color: #1b1c1a; }
        .about-body { margin: 0; font-size: 17px; font-weight: 700; line-height: 1.75; color: #5f5e5e; }
        .about-note { margin: 0; font-size: 17px; font-weight: 400; line-height: 1.55; color: #5f5e5e; }
        .about-action { padding-top: 32px; }
        .about-reveal-media {
            position: relative;
            width: 100%;
            aspect-ratio: 665.333 / 738;
            overflow: hidden;
        }
        .about-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            max-width: none;
            object-fit: cover;
        }
        @media (min-width: 1024px) {
            #about-me {
                z-index: 1;
                margin-top: calc(-212 * var(--fu));
                padding: 0 0 24px;
                background: linear-gradient(to bottom, transparent 0, transparent calc(212 * var(--fu)), #f3f3f3 calc(212 * var(--fu)), #f3f3f3 100%);
            }
            .about-card {
                --about-pad: max(0px, min(calc(120 * var(--fu)), calc(var(--site-edge) - 16px)));
                width: calc(var(--site-width) + 2 * var(--about-pad));
                padding: calc(160 * var(--fu)) var(--about-pad) calc(113 * var(--fu));
                border-radius: max(12px, calc(20 * var(--fu)));
            }
            .about-grid {
                width: 100%;
                grid-template-columns: minmax(0, 1fr) minmax(0, 42%);
                column-gap: clamp(32px, calc(80 * var(--fu)), 80px);
                align-items: center;
            }
            .about-reveal-text { align-self: start; padding-top: calc(39 * var(--fu)); }
            .about-copy { gap: calc(50 * var(--fu)); padding-top: calc(51 * var(--fu)); }
            .about-quote-box {
                max-width: 100%;
                border-left-width: max(2px, calc(4 * var(--fu)));
                border-radius: calc(16 * var(--fu));
                padding: calc(24 * var(--fu)) calc(24 * var(--fu)) calc(24 * var(--fu)) calc(28 * var(--fu));
            }
            .about-quote { font-size: clamp(19px, calc(31 * var(--fu)), 31px); line-height: 1.3; }
            .about-body {
                max-width: 100%;
                font-size: clamp(16px, 1.2vw, 18px);
                line-height: 1.75;
            }
            .about-note {
                max-width: min(100%, 38rem);
                font-size: clamp(16px, 1.2vw, 18px);
                line-height: 1.55;
            }
            .about-action { padding-top: clamp(32px, calc(64 * var(--fu)), 64px); }
            .about-reveal-media { border-radius: max(10px, calc(16 * var(--fu))); }
        }
        .about-photo { transition: scale 1.2s cubic-bezier(0.22, 1, 0.36, 1); }
        .about-reveal-media:hover .about-photo { scale: 1.04; }
        .about-reveal-ready .about-card {
            opacity: 0;
            transform: translateY(160px);
            transition: transform 0.7s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.5s ease-out;
        }
        .about-reveal-ready .about-reveal-text,
        .about-reveal-ready .about-reveal-media {
            opacity: 0;
            transition: transform 0.5s ease-in 0.15s, opacity 0.5s ease-in 0.15s;
        }
        .about-reveal-ready .about-reveal-text { transform: translateX(-59.375vw); }
        .about-reveal-ready .about-reveal-media { transform: translateX(46.875vw); }
        .about-card { overflow: visible; }
        .about-card > .about-grid { overflow: clip; overflow-clip-margin: 40px; }
        .about-reveal-ready .about-reveal.is-revealed .about-card,
        .about-reveal-ready .about-reveal.is-revealed .about-reveal-text,
        .about-reveal-ready .about-reveal.is-revealed .about-reveal-media {
            opacity: 1;
            transform: none;
        }
        @media (prefers-reduced-motion: reduce) {
            .about-reveal-ready .about-card,
            .about-reveal-ready .about-reveal-text,
            .about-reveal-ready .about-reveal-media {
                opacity: 1;
                transform: none;
                transition: none;
            }
        }
        .about-portrait { position: absolute; inset: 0; }
        .about-portrait video { z-index: 0; display: block; }
        #aboutPortraitSound {
            position: absolute;
            right: 16px;
            bottom: 16px;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border: 0;
            border-radius: 999px;
            background: rgba(11, 14, 18, 0.72);
            color: #fff;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.28);
        }
        #aboutPortraitSound:hover { background: rgba(11, 14, 18, 0.9); }
    </style>
    <script>
        (function () {
            const section = document.getElementById('about-me');
            if (!section) {
                return;
            }
            document.documentElement.classList.add('about-reveal-ready');
            function check() {
                if (window.scrollY < 10) {
                    return;
                }
                if (section.getBoundingClientRect().top < window.innerHeight * 0.92) {
                    section.classList.add('is-revealed');
                    window.removeEventListener('scroll', check);
                    window.removeEventListener('resize', check);
                }
            }
            window.addEventListener('scroll', check, { passive: true });
            window.addEventListener('resize', check);
            check();
        })();
    </script>
    <script>
        (function () {
            const button = document.getElementById('aboutPortraitSound');
            const video = document.getElementById('aboutPortraitVideo');
            if (!video) {
                return;
            }

            const source = video.getAttribute('data-src');
            let started = false;

            function start() {
                if (started || !source) {
                    return;
                }
                started = true;
                video.src = source;
                video.preload = 'auto';
                const play = video.play();
                if (play && typeof play.catch === 'function') {
                    play.catch(function () {});
                }
            }

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            start();
                            observer.disconnect();
                        }
                    });
                }, { rootMargin: '400px 0px' });
                observer.observe(video);
            } else {
                start();
            }

            if (!button) {
                return;
            }

            button.addEventListener('click', function () {
                start();
                video.muted = !video.muted;
                if (!video.muted) {
                    video.volume = 1;
                    video.play();
                }

                const soundOn = !video.muted;
                button.setAttribute('aria-pressed', soundOn ? 'true' : 'false');
                button.setAttribute('aria-label', soundOn ? 'Turn sound off' : 'Turn sound on');
                button.querySelector('i').className = soundOn
                    ? 'fa-solid fa-volume-high text-sm'
                    : 'fa-solid fa-volume-xmark text-sm';
            });
        })();
    </script>
    <!-- Impact Stats -->
    <section id="impact" class="impact-section scroll-mt-20 bg-[#010a19]">
        <div class="site-container impact-layout">
            <div class="impact-intro" data-reveal>
                <div class="flex items-center gap-2">
                    <span class="reveal-line block h-0.5 w-6 shrink-0 bg-[#b36855]" aria-hidden="true"></span>
                    @php $statsSection = \App\Models\Setting::getStatsSection(); @endphp
                    <p class="impact-kicker font-grotesk font-bold uppercase tracking-[1.1px] text-[#b36855]">{{ $statsSection['title'] }}</p>
                    </div>
                <h2 class="impact-heading text-white">
                    {{ $statsSection['description'] }}
                </h2>
                        </div>
            <div class="w-full min-w-0 flex-1 overflow-hidden rounded-2xl border border-[#1e2530] bg-[#12161e] shadow-[0px_25px_50px_-12px_rgba(0,0,0,0.25)]" data-reveal>
                <div class="grid grid-cols-2 gap-px bg-[#1c232d] md:grid-cols-3 xl:grid-cols-6" data-reveal-stagger>
                    @forelse($stats ?? [] as $stat)
                        @php
                            $number = trim((string) $stat->number);
                            preg_match('/^([0-9]+(?:\\.[0-9]+)?)(.*)$/', $number, $numberParts);
                            $numericValue = $numberParts[1] ?? '0';
                            $numberSuffix = trim($numberParts[2] ?? '');
                            $accentSuffix = '';
                            $inlineSuffix = '';
                            if (preg_match('/lakh/i', $numberSuffix)) {
                                $accentSuffix = $numberSuffix;
                            } elseif ($numberSuffix !== '') {
                                $inlineSuffix = $numberSuffix;
                            }
                        @endphp
                        <div class="impact-stat flex min-h-[220px] flex-col items-center justify-between bg-[#12161e] px-4 py-10 text-center">
                            <img src="{{ asset('images/metric-arrow.svg') }}" alt="" width="32" height="32">
                            <div class="flex flex-col items-center py-3">
                                <p class="font-inter text-[34px] font-extrabold leading-[34px] tracking-[-0.85px] text-white">
                                    <span class="counter" data-target="{{ $numericValue }}">{{ $numericValue }}</span>@if($inlineSuffix !== '') {{ $inlineSuffix }}@endif
                                </p>
                                @if($accentSuffix !== '')
                                    <p class="font-playfair text-[28px] font-extrabold leading-8 text-[#d4a034]">{{ $accentSuffix }}</p>
                                @endif
                        </div>
                            <p class="font-inter text-[11px] font-semibold uppercase leading-[1.35] tracking-[1.54px] text-[#9ca3af]">
                                {{ $stat->label }}@if(filled($stat->sub_label))<br>{{ $stat->sub_label }}@endif
                            </p>
                    </div>
                    @empty
                        <div class="col-span-full bg-[#12161e] px-8 py-10 text-center text-[#9ca3af]">No impact stats available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="initiatives-section scroll-mt-20" aria-labelledby="initiatives-heading">
        <div class="initiatives-cubes hero-cubes hero-cubes-a" aria-hidden="true"></div>
        <div class="initiatives-cubes hero-cubes hero-cubes-b" aria-hidden="true"></div>

        <div class="initiatives-content">
            @php
                $projectsSection = \App\Models\Setting::getProjectsSection();
            @endphp

            <div class="initiatives-heading site-container">
                <div class="initiatives-heading-inner">
                    <div class="initiatives-kicker">
                        <span aria-hidden="true"></span>
                        <p>{{ $projectsSection["label"] }}</p>
                </div>
                    <h2 id="initiatives-heading">{{ $projectsSection["title"] }}</h2>
            </div>
        </div>

            <div class="initiatives-viewport carousel-container" tabindex="0" aria-label="Projects and initiatives">
                <div class="initiatives-track carousel-track">
                @forelse($projects ?? [] as $project)
                        @php
                            $projectSlug = strtolower((string) ($project->slug ?? ""));
                            $initiativeBackground = preg_match('/^#[0-9A-Fa-f]{6}$/', (string) $project->bg_color)
                                ? $project->bg_color
                                : '#ffffff';
                            $initiativeLogoNumber = match (true) {
                                str_contains($projectSlug, "bootcamp"), str_contains($projectSlug, "ict") => 1,
                                str_contains($projectSlug, "baakhapaa") => 2,
                                str_contains($projectSlug, "skill") => 3,
                                str_contains($projectSlug, "hilly") => 4,
                                str_contains($projectSlug, "kholso"), str_contains($projectSlug, "resort") => 5,
                                default => null,
                            };
                            $initiativeLogo = $initiativeLogoNumber
                                ? asset("images/initiatives/initiative-mark-" . $initiativeLogoNumber . ".png")
                                : $project->image_url;
                            $initiativeDescription = $project->short_description ?: $project->description;
                        @endphp
                        <article class="initiative-card tooltip-container" style="--initiative-index: {{ $loop->index }}; --initiative-bg: {{ $initiativeBackground }};">
                            <div class="project-default">
                                <div class="initiative-card-surface" aria-hidden="true"></div>
                                <div class="initiative-mark">
                                    @if($initiativeLogo)
                                        <img src="{{ $initiativeLogo }}" alt="{{ $project->name }}" width="142" height="142" loading="lazy" decoding="async">
                                @else
                                        <span>{{ strtoupper(substr($project->name, 0, 1)) }}</span>
                                    @endif
                                    </div>
                                <h3>{{ $project->name }}</h3>
                                @if(filled($initiativeDescription))
                                    <p>{{ $initiativeDescription }}</p>
                                @endif
                                @if(filled($project->url))
                                    <a class="initiative-read-more" href="{{ $project->url }}" target="_blank" rel="noopener noreferrer">
                                        <span>Read more</span>
                                        <img src="{{ asset("images/initiatives/initiative-arrow.svg") }}" alt="" aria-hidden="true">
                                    </a>
                                @endif
                        </div>

                            @if(filled($project->description))
                                <div class="tooltip-popup" role="dialog" aria-label="{{ $project->name }} overview">
                                    <div class="project-popup-content">
                                    <div class="popup-image">
                                            @if($initiativeLogo)
                                                <img src="{{ $initiativeLogo }}" alt="{{ $project->name }}" loading="lazy" decoding="async">
                                        @else
                                                <span>{{ strtoupper(substr($project->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                        <h4>{{ $project->name }}</h4>
                                        <p>{{ $project->description }}</p>
                                        @if(filled($project->url))
                                            <a class="project-visit-link" href="{{ $project->url }}" target="_blank" rel="noopener noreferrer">
                                                <span>Visit Website</span>
                                                <img src="{{ asset('images/initiatives/initiative-arrow.svg') }}" alt="" aria-hidden="true">
                                            </a>
                                @endif
                            </div>
                        </div>
                            @endif
                        </article>
                @empty
                        <p class="initiatives-empty">No projects available yet.</p>
                @endforelse
                                    </div>
                            </div>
                        </div>

        <script>
            (function () {
                var section = document.getElementById("projects");
                if (!section) return;

                document.documentElement.classList.add("initiatives-reveal-ready");
                if (window.matchMedia("(prefers-reduced-motion: reduce)").matches || !("IntersectionObserver" in window)) {
                    section.classList.add("is-visible");
                    return;
                }

                var observer = new IntersectionObserver(function (entries) {
                    if (entries.some(function (entry) { return entry.isIntersecting; })) {
                        section.classList.add("is-visible");
                        observer.disconnect();
                    }
                }, { threshold: 0.15 });

                observer.observe(section);
            })();
        </script>
    </section>
  <!-- Mission Section -->
    @php
        $missionContent = \App\Models\Setting::getMissionContent();
        $missionItems = $missionContent['items'];
        $missionLabel = $missionContent['label'];
        $missionButtonLabel = $missionContent['button_label'];
    @endphp

    <section id="about" class="mission-scroll text-[#1e1e1a] scroll-mt-20" aria-labelledby="mission-heading">
        <div class="mission-scroll__list">
            <p class="mission-scroll__kicker"><span class="mission-scroll__dash" aria-hidden="true"></span>{{ $missionLabel }}</p>
            @foreach($missionItems as $index => $item)
                <div class="mission-scroll__listItem">
                    <div class="mission-scroll__listNum">{{ $item['number'] }}</div>
                    <h3 class="mission-scroll__listTitle">{{ $item['title'] }}</h3>
                    <p class="mission-scroll__listBody">{{ $item['body'] }}</p>
                    <button type="button" class="mission-scroll__more mission-scroll__more--list site-btn site-btn--sm" data-mission-open="{{ $index }}">
                        {{ $missionButtonLabel }}
                        <img src="{{ asset('images/gallery-explore-arrow.svg') }}" alt="" width="9.46875" height="3.75">
                    </button>
                                    </div>
            @endforeach
                            </div>

        <div class="mission-scroll__track" id="missionTrack">
            <div class="mission-scroll__sticky" id="missionSticky">
                <div class="mission-scroll__dialZone" aria-hidden="true">
                    <div class="mission-scroll__rings">
                        <div class="mission-scroll__dialBaseOuter"></div>
                        <div class="mission-scroll__dialBaseInner"></div>
                        <div class="mission-scroll__dialBaseCenter"></div>
                    </div>
                    <div class="mission-scroll__dialCanvas" id="missionDial">
                        @foreach($missionItems as $item)
                            <div class="mission-scroll__marker">
                                <div class="mission-scroll__markerContent">
                                    <span class="mission-scroll__markerNum">{{ $item["number"] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
                <p id="mission-heading" class="mission-scroll__kicker"><span class="mission-scroll__dash" aria-hidden="true"></span>{{ $missionLabel }}</p>
                <div class="mission-scroll__textZone">
                    <div class="mission-scroll__textViewport" id="missionText">
                        @foreach($missionItems as $index => $item)
                            <article class="mission-scroll__reason">
                                <div class="mission-scroll__copy">
                                    <h3 class="mission-scroll__headline">{{ $item['title'] }}</h3>
                                    <p class="mission-scroll__body">{{ $item['body'] }}</p>
                                </div>
                                <button type="button" class="mission-scroll__more site-btn site-btn--sm" data-mission-open="{{ $index }}">
                                    {{ $missionButtonLabel }}
                                    <img src="{{ asset('images/gallery-explore-arrow.svg') }}" alt="" width="9.46875" height="3.75">
                                </button>
                            </article>
                        @endforeach
            </div>
                        </div>
                        </div>
                    </div>

        <div id="missionModal" class="mission-modal" hidden>
            <div class="mission-modal__backdrop" data-mission-close></div>
            <div class="mission-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="missionModalTitle">
                <button type="button" class="mission-modal__close" data-mission-close aria-label="Close mission details">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
                <p class="mission-modal__number" id="missionModalNumber"></p>
                <h3 class="mission-modal__title" id="missionModalTitle"></h3>
                <div class="mission-modal__body" id="missionModalBody"></div>
            </div>
        </div>
    </section>

    <style>
        .mission-scroll {
            --dial-size: min(78vh, 898px);
            --dial-center: 0.04;
            --number-margin: 8px;
            position: relative;
            width: 100%;
            background: #fbf9f6;
            border-bottom: 1px solid #efeeeb;
            overflow: clip;
        }

        .mission-scroll__kicker {
            position: absolute;
            z-index: 3;
            left: calc(var(--dial-size) * var(--dial-center) + var(--dial-size) * 0.5 + var(--number-margin));
            top: calc(50% - clamp(250px, 32vh, 340px));
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            color: #89351d;
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(22px, 2.4vw, 46px);
            font-weight: 700;
            letter-spacing: 1.1px;
            line-height: 1;
            text-transform: uppercase;
        }
        .mission-scroll__list {
            display: none;
            max-width: 40rem;
            margin: 0 auto;
            padding: 72px 24px 80px;
        }

        .mission-scroll__listItem + .mission-scroll__listItem {
            margin-top: 28px;
            padding-top: 28px;
            border-top: 1px solid rgba(30, 30, 26, 0.08);
        }

        .mission-scroll__listNum {
            color: #D4AF37;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 28px;
            font-weight: 700;
        }

        .mission-scroll__listTitle {
            margin: 8px 0 0;
            font-family: Poppins, sans-serif;
            font-size: 32px;
            font-weight: 600;
            color: #111111;
        }

        .mission-scroll__listBody {
            margin: 8px 0 0;
            color: #5a5a52;
            font-size: 15px;
            line-height: 1.6;
        }

        .mission-scroll__track {
            position: relative;
            width: 100%;
            height: 600vh;
        }

        .mission-scroll__dash {
            width: 39px;
            height: 4px;
            background: #89351d;
            flex: none;
        }
        .mission-scroll__list .mission-scroll__kicker {
            position: static;
            margin: 0 0 24px;
            font-size: 28px;
        }
        .mission-scroll__listItem + .mission-scroll__listItem { margin-top: 28px; padding-top: 28px; border-top: 1px solid #efeeeb; }
        .mission-scroll__listNum { color: #111111; font-family: "Plus Jakarta Sans", sans-serif; font-size: 28px; font-weight: 700; letter-spacing: -0.04em; }
        .mission-scroll__listTitle { margin: 8px 0 0; font-family: Poppins, sans-serif; font-size: 32px; font-weight: 600; letter-spacing: -0.6px; color: #111111; }
        .mission-scroll__listBody {
            margin: 8px 0 0;
            max-width: 100%;
            max-height: 7.5em;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
            color: #59554f;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.5;
        }
        .mission-scroll__more--list { margin-top: 16px; }
        .mission-scroll__track { position: relative; width: 100%; height: 600vh; }
        .mission-scroll__sticky {
            position: sticky;
            top: 5rem;
            height: calc(100vh - 5rem);
            width: 100%;
            overflow: hidden;
        }

        .mission-scroll__dialZone {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        .mission-scroll__rings {
            position: absolute;
            inset: 0;
            pointer-events: none;
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, #000 14%, #000 86%, transparent 100%);
            mask-image: linear-gradient(to bottom, transparent 0%, #000 14%, #000 86%, transparent 100%);
        }

        .mission-scroll__dialBaseOuter,
        .mission-scroll__dialBaseInner,
        .mission-scroll__dialBaseCenter {
            position: absolute;
            top: 50%;
            border-radius: 50%;
        }

        .mission-scroll__dialBaseOuter {
            width: var(--dial-size);
            height: var(--dial-size);
            left: calc(var(--dial-size) * (var(--dial-center) - 0.5));
            margin-top: calc(var(--dial-size) / -2);
            background: radial-gradient(circle at 35% 35%, #ffffff 0%, #f7f4ee 100%);
            box-shadow: 30px 40px 90px rgba(30, 30, 26, 0.08), inset -6px -6px 16px rgba(255, 255, 255, 0.95), inset 6px 6px 16px rgba(30, 30, 26, 0.05);
        }

        .mission-scroll__dialBaseInner {
            width: calc(var(--dial-size) * 0.76);
            height: calc(var(--dial-size) * 0.76);
            left: calc(var(--dial-size) * (var(--dial-center) - 0.38));
            margin-top: calc(var(--dial-size) * 0.76 / -2);
            background: radial-gradient(circle at 35% 35%, #ffffff 0%, #faf8f5 100%);
            box-shadow: 12px 16px 40px rgba(30, 30, 26, 0.05), inset -4px -4px 10px rgba(255, 255, 255, 0.9);
        }

        .mission-scroll__dialBaseCenter {
            width: calc(var(--dial-size) * 0.52);
            height: calc(var(--dial-size) * 0.52);
            left: calc(var(--dial-size) * (var(--dial-center) - 0.26));
            margin-top: calc(var(--dial-size) * 0.52 / -2);
            background: #fff;
            box-shadow: 6px 8px 24px rgba(30, 30, 26, 0.04);
        }

        .mission-scroll__dialCanvas {
            position: absolute;
            width: var(--dial-size);
            height: var(--dial-size);
            left: calc(var(--dial-size) * (var(--dial-center) - 0.5));
            top: 50%;
            margin-top: calc(var(--dial-size) / -2);
            transform-origin: 50% 50%;
            will-change: transform;
        }

        .mission-scroll__marker {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 0;
            height: 0;
            transform-origin: 0 0;
            transform: rotate(var(--angle)) translateX(calc(var(--dial-size) * 0.5 + var(--number-margin)));
        }

        .mission-scroll__markerContent {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .mission-scroll__markerNum {
            display: inline-block;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: clamp(64px, 7vw, 126px);
            font-weight: 700;
            line-height: 0.8;
            letter-spacing: -0.04em;
            color: #111111;
            will-change: transform, color, opacity;
        }

        .mission-scroll__textZone {
            position: absolute;
            left: calc(var(--dial-size) * var(--dial-center) + var(--dial-size) * 0.5 + clamp(150px, 16vw, 230px));
            right: var(--site-edge);
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }
        .mission-scroll__more {
            grid-column: 2;
            grid-row: 1;
            align-self: center;
            justify-self: start;
            z-index: 3;
            flex: none;
        }
        .mission-modal {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .mission-modal[hidden] { display: none !important; }
        .mission-modal__backdrop {
            position: absolute;
            inset: 0;
            background: rgba(17, 17, 17, 0.55);
            backdrop-filter: blur(4px);
        }
        .mission-modal__dialog {
            position: relative;
            z-index: 1;
            width: min(760px, 100%);
            max-height: min(88vh, 820px);
            overflow: auto;
            padding: 32px 28px 28px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 24px 60px rgba(17, 17, 17, 0.28);
        }
        .mission-modal__close {
            position: absolute;
            top: 16px;
            right: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid #efeeeb;
            border-radius: 9999px;
            background: #fff;
            color: #59554f;
            cursor: pointer;
        }
        .mission-modal__close:hover { color: #111111; border-color: #d5cec2; }
        .mission-modal__number {
            margin: 0;
            color: #89351d;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.08em;
        }
        .mission-modal__title {
            margin: 8px 0 0;
            color: #111111;
            font-family: Poppins, sans-serif;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 600;
            letter-spacing: -0.04em;
            line-height: 1.15;
            padding-right: 40px;
        }
        .mission-modal__body {
            margin-top: 16px;
            color: #3a3a34;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 16px;
            line-height: 1.7;
        }
        .mission-modal__body > *:first-child { margin-top: 0; }
        .mission-modal__body p { margin: 0 0 1em; }
        .mission-modal__body h2,
        .mission-modal__body h3,
        .mission-modal__body h4 {
            margin: 1.15em 0 0.45em;
            color: #111111;
            font-family: Poppins, sans-serif;
            font-weight: 600;
            letter-spacing: -0.03em;
            line-height: 1.2;
        }
        .mission-modal__body h2 { font-size: 1.5rem; }
        .mission-modal__body h3 { font-size: 1.25rem; }
        .mission-modal__body h4 { font-size: 1.1rem; }
        .mission-modal__body ul,
        .mission-modal__body ol {
            margin: 0 0 1em;
            padding-left: 1.35rem;
        }
        .mission-modal__body li { margin: 0.3em 0; }
        .mission-modal__body a { color: #89351d; text-decoration: underline; text-underline-offset: 2px; }
        .mission-modal__body blockquote {
            margin: 0 0 1em;
            padding: 0.15em 0 0.15em 1rem;
            border-left: 3px solid #b36855;
            color: #59554f;
        }
        .mission-modal__body img {
            display: block;
            /* width: auto; */
            max-width: 100%;
            justify-self: center;
            height: auto;
            margin: 1.1em 0;
            border-radius: 16px;
            object-fit: contain;
            box-shadow: 0 12px 28px rgba(17, 17, 17, 0.12);
        }
        .mission-modal__body figure {
            margin: 1.1em 0;
            max-width: 100%;
        }
        .mission-modal__body figure img {
            margin: 0;
        }
        .mission-modal__body figcaption {
            margin-top: 0.45em;
            color: #8a8a82;
            font-size: 0.875rem;
            line-height: 1.4;
        }
        .mission-scroll__textViewport {
            position: relative;
            width: min(760px, 100%);
            height: min(220px, 32vh);
            min-height: 150px;
            overflow: hidden;
        }
        .mission-scroll__reason {
            position: absolute;
            inset: 0;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            column-gap: 20px;
            align-items: center;
            opacity: 0;
            will-change: transform, opacity;
        }
        .mission-scroll__copy {
            grid-column: 1;
            grid-row: 1;
            min-width: 0;
            max-width: 100%;
            max-height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            mask-image: linear-gradient(to bottom, #000 0%, #000 78%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, #000 0%, #000 78%, transparent 100%);
        }
        .mission-scroll__headline {
            min-width: 0;
            margin: 0;
            font-family: Poppins, "Plus Jakarta Sans", sans-serif;
            font-size: clamp(22px, 2.1vw, 34px);
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: 0;
            color: #111111;
            will-change: transform;
        }
        .mission-scroll__body {
            min-width: 0;
            width: 100%;
            margin: 8px 0 0;
            max-height: 6.6em;
            overflow-x: auto;
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            color: #59554f;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: clamp(13px, 1vw, 15px);
            font-weight: 500;
            line-height: 1.45;
            letter-spacing: 0;
            will-change: transform;
            scrollbar-width: thin;
            scrollbar-color: rgba(179, 104, 85, 0.55) transparent;
        }
        .mission-scroll__body::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        .mission-scroll__body::-webkit-scrollbar-thumb {
            background: rgba(179, 104, 85, 0.55);
            border-radius: 999px;
        }

        @media (max-width: 1100px) {
            .mission-scroll__textZone {
                left: calc(var(--dial-size) * var(--dial-center) + var(--dial-size) * 0.5 + 112px);
                right: 12px;
            }
            .mission-scroll__textViewport {
                width: min(640px, 100%);
                height: min(200px, 34vh);
            }
            .mission-scroll__headline { font-size: 24px; letter-spacing: 0; }
            .mission-scroll__kicker { top: calc(50% - 230px); font-size: 20px; }
        }

        @media (max-width: 768px) {
            .mission-scroll {
                --dial-size: min(34vh, 250px);
                --dial-center: -0.22;
                --number-margin: 4px;
            }

            .mission-scroll__sticky {
                top: 5rem;
                height: calc(100svh - 5rem);
            }

            .mission-scroll__rings {
                -webkit-mask-image: linear-gradient(to bottom, transparent 0%, #000 10%, #000 90%, transparent 100%);
                mask-image: linear-gradient(to bottom, transparent 0%, #000 10%, #000 90%, transparent 100%);
            }

            .mission-scroll__dialBaseOuter,
            .mission-scroll__dialBaseInner,
            .mission-scroll__dialBaseCenter {
                box-shadow: none;
            }

            .mission-scroll__dialBaseOuter {
                background: radial-gradient(circle at 35% 35%, #ffffff 0%, #f7f4ee 100%);
                filter: drop-shadow(8px 12px 28px rgba(30, 30, 26, 0.05));
            }

            .mission-scroll__markerNum { font-size: clamp(32px, 9vw, 44px); }

            .mission-scroll__textZone {
                left: calc(var(--dial-size) * var(--dial-center) + var(--dial-size) * 0.5 + 48px);
                right: 12px;
                transform: translateY(-50%);
            }

            .mission-scroll__textViewport {
                width: 100%;
                min-height: 170px;
                height: min(260px, 42vh);
            }

            .mission-scroll__reason {
                grid-template-columns: minmax(0, 1fr);
                grid-template-rows: minmax(0, 1fr) auto;
                row-gap: 10px;
                align-content: center;
            }

            .mission-scroll__copy {
                grid-row: 1;
                mask-image: none;
                -webkit-mask-image: none;
            }

            .mission-scroll__more {
                grid-column: 1;
                grid-row: 2;
                justify-self: start;
            }

            .mission-scroll__headline { font-size: 20px; letter-spacing: 0; }

            .mission-scroll__body {
                margin-top: 8px;
                font-size: 13px;
                line-height: 1.45;
                max-height: 9.5em;
                overflow: visible;
            }

            .mission-scroll__kicker {
                font-size: 16px;
                top: calc(50% - 150px);
                left: calc(var(--dial-size) * var(--dial-center) + var(--dial-size) * 0.5 + var(--number-margin));
            }

            .mission-scroll__dash { width: 28px; height: 3px; }
        }

        @media (max-width: 480px) {
            .mission-scroll {
                --dial-size: min(30vh, 210px);
                --dial-center: -0.28;
            }

            .mission-scroll__textZone {
                left: calc(var(--dial-size) * var(--dial-center) + var(--dial-size) * 0.5 + 40px);
                right: 10px;
            }

            .mission-scroll__textViewport {
                width: 100%;
                min-height: 180px;
                height: min(280px, 46vh);
            }

            .mission-scroll__body {
                max-height: 11em;
                overflow: visible;
            }

            .mission-scroll__markerNum { font-size: clamp(28px, 8.5vw, 38px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .mission-scroll__track {
                display: none !important;
                height: auto !important;
            }

            .mission-scroll__list {
                display: block !important;
            }
        }
    </style>

    <script>
        (function () {
            const missions = @json($missionItems);
            const modal = document.getElementById('missionModal');
            const numberEl = document.getElementById('missionModalNumber');
            const titleEl = document.getElementById('missionModalTitle');
            const bodyEl = document.getElementById('missionModalBody');
            if (!modal || !numberEl || !titleEl || !bodyEl) return;

            function openMission(index) {
                const item = missions[index];
                if (!item) return;
                numberEl.textContent = item.number || '';
                titleEl.textContent = item.title || '';
                const html = String(item.description || '').trim();
                if (html && /<[a-z][\s\S]*>/i.test(html)) {
                    bodyEl.innerHTML = html;
                } else {
                    bodyEl.textContent = html || item.body || '';
                }
                modal.hidden = false;
                document.body.style.overflow = 'hidden';
                modal.querySelector('.mission-modal__dialog')?.scrollTo(0, 0);
            }

            function closeMission() {
                modal.hidden = true;
                document.body.style.overflow = '';
            }

            document.querySelectorAll('[data-mission-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    openMission(Number(button.getAttribute('data-mission-open')));
                });
            });

            modal.querySelectorAll('[data-mission-close]').forEach(function (el) {
                el.addEventListener('click', closeMission);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.hidden) {
                    closeMission();
                }
            });
        })();
    </script>
    <script>
        (function () {
            const section = document.getElementById('about');
            const track = document.getElementById('missionTrack');
            const sticky = document.getElementById('missionSticky');
            const canvas = document.getElementById('missionDial');
            const viewport = document.getElementById('missionText');
            if (!section || !track || !sticky || !canvas || !viewport) return;

            const CONFIG = {
                angleStep: 28,
                exitY: 200,
                stiffness: 85,
                damping: 26,
                mass: 0.3,
                headlineYOffset: 45,
                bodyYOffset: 25,
                scrollPadding: 0
            };
            function applyMotionScale() {
                const narrow = window.innerWidth <= 768;
                CONFIG.exitY = narrow ? 90 : 200;
                CONFIG.headlineYOffset = narrow ? 20 : 45;
                CONFIG.bodyYOffset = narrow ? 12 : 25;
            }
            const COLOR_FADED = "rgba(0, 0, 0, 0.26)";
            const COLOR_ACTIVE = "#111111";
            const markers = Array.from(canvas.querySelectorAll(".mission-scroll__marker"));
            const nums = Array.from(canvas.querySelectorAll(".mission-scroll__markerNum"));
            const articles = Array.from(viewport.querySelectorAll(".mission-scroll__reason"));
            const headlines = Array.from(viewport.querySelectorAll(".mission-scroll__headline"));
            const bodies = Array.from(viewport.querySelectorAll(".mission-scroll__body"));
            const total = articles.length;

            if (total < 2) return;

            markers.forEach(function (marker, index) {
                marker.style.setProperty("--angle", (index * CONFIG.angleStep) + "deg");
            });

            const clamp = function (value, min, max) {
                return Math.min(Math.max(value, min), max);
            };

            function interpolate(x, input, output) {
                if (x <= input[0]) return output[0];
                if (x >= input[input.length - 1]) return output[output.length - 1];
                for (let i = 1; i < input.length; i++) {
                    if (x <= input[i]) {
                        const t = (x - input[i - 1]) / (input[i] - input[i - 1]);
                        return output[i - 1] + (output[i] - output[i - 1]) * t;
                    }
                }
                return output[output.length - 1];
            }

            function parseColor(str) {
                if (str[0] === "#") {
                    const hex = str.slice(1);
                    return [parseInt(hex.slice(0, 2), 16), parseInt(hex.slice(2, 4), 16), parseInt(hex.slice(4, 6), 16), 1];
                }
                const parts = str.match(/rgba?\(([^)]+)\)/)[1].split(",").map(Number);
                return [parts[0], parts[1], parts[2], parts[3] === undefined ? 1 : parts[3]];
            }

            function lerpColor(a, b, t) {
                const A = parseColor(a);
                const B = parseColor(b);
                const ch = function (i) {
                    return Math.sqrt(A[i] * A[i] + (B[i] * B[i] - A[i] * A[i]) * t);
                };
                const alpha = A[3] + (B[3] - A[3]) * t;
                return "rgba(" + Math.round(ch(0)) + ", " + Math.round(ch(1)) + ", " + Math.round(ch(2)) + ", " + alpha.toFixed(4) + ")";
            }

            const spring = { value: 0, target: 0, velocity: 0 };
            let trackTop = 0;
            let travel = 1;

            function readProgress() {
                return clamp((window.scrollY - trackTop) / travel, 0, 1);
            }

            function layout() {
                applyMotionScale();
                const rect = track.getBoundingClientRect();
                trackTop = rect.top + window.scrollY;
                travel = Math.max(1, track.offsetHeight - sticky.offsetHeight);
                spring.value = spring.target = readProgress();
            }

            function stepSpring(dt) {
                const steps = Math.min(12, Math.max(1, Math.ceil(dt / (1 / 240))));
                const h = dt / steps;
                for (let i = 0; i < steps; i++) {
                    const accel = (-CONFIG.stiffness * (spring.value - spring.target) - CONFIG.damping * spring.velocity) / CONFIG.mass;
                    spring.velocity += accel * h;
                    spring.value += spring.velocity * h;
                }
                if (Math.abs(spring.velocity) < 0.001 && Math.abs(spring.value - spring.target) < 0.00005) {
                    spring.value = spring.target;
                    spring.velocity = 0;
                }
            }

            function render() {
                const progress = spring.value;
                const pad = CONFIG.scrollPadding;
                const step = (1 - 2 * pad) / (total - 1);
                const rotation = interpolate(progress, [pad, 1 - pad], [0, -(total - 1) * CONFIG.angleStep]);
                canvas.style.transform = 'rotate(' + rotation + 'deg)';

                for (let i = 0; i < total; i++) {
                    const s = pad + (i / (total - 1)) * (1 - 2 * pad);
                    const scale = interpolate(progress, [s - step * 0.8, s, s + step * 0.8], [0.5, 1, 0.5]);
                    const angle = i * CONFIG.angleStep + rotation;
                    const above = angle >= -8 ? 1 : (angle <= -26 ? 0 : (angle + 26) / 18);
                    const opacity = interpolate(progress, [s - step * 0.9, s, s + step * 0.9], [0.3, 1, 0.3]) * above;
                    const cRange = [s - step * 0.6, s, s + step * 0.6];
                    let color = COLOR_FADED;
                    if (progress > cRange[0] && progress < cRange[2]) {
                        color = progress < cRange[1]
                            ? lerpColor(COLOR_FADED, COLOR_ACTIVE, (progress - cRange[0]) / (cRange[1] - cRange[0]))
                            : lerpColor(COLOR_ACTIVE, COLOR_FADED, (progress - cRange[1]) / (cRange[2] - cRange[1]));
                    }
                    nums[i].style.transform = "scale(" + scale.toFixed(4) + ")";
                    nums[i].style.opacity = opacity.toFixed(4);
                    nums[i].style.visibility = opacity < 0.02 ? 'hidden' : 'visible';
                    nums[i].style.color = color;

                    const y = interpolate(progress, [s - step * 0.8, s, s + step * 0.8], [CONFIG.exitY, 0, -CONFIG.exitY]);
                    const cardOpacity = interpolate(progress, [s - step * 0.6, s - step * 0.2, s + step * 0.2, s + step * 0.6], [0, 1, 1, 0]);
                    articles[i].style.transform = "translate3d(0, " + y.toFixed(2) + "px, 0)";
                    articles[i].style.opacity = cardOpacity.toFixed(4);
                    articles[i].style.visibility = cardOpacity < 0.002 ? "hidden" : "visible";
                    headlines[i].style.transform = "translate3d(0, " + interpolate(progress, [s - step * 0.6, s, s + step * 0.6], [CONFIG.headlineYOffset, 0, -CONFIG.headlineYOffset]).toFixed(2) + "px, 0)";
                    bodies[i].style.transform = "translate3d(0, " + interpolate(progress, [s - step * 0.5, s, s + step * 0.5], [CONFIG.bodyYOffset, 0, -CONFIG.bodyYOffset]).toFixed(2) + "px, 0)";
                }
            }

            let last = performance.now();

            function frame(now) {
                const dt = Math.min(0.05, (now - last) / 1000);
                last = now;
                spring.target = readProgress();
                stepSpring(dt);
                render();
                requestAnimationFrame(frame);
            }

            window.addEventListener("resize", layout);
            layout();
            render();
            requestAnimationFrame(frame);
        })();
    </script>
<section id="research" class="studies-section scroll-mt-20" aria-labelledby="studies-heading">
    <style>
        .studies-section {
            background: #fff;
            color: #111;
            padding: var(--section-y) var(--site-edge);
        }
        .studies-intro { display: flex; flex-direction: column; gap: var(--kicker-gap); }
        .studies-kicker { display: flex; align-items: center; gap: 8px; }
        .studies-kicker span { width: 24px; height: 2px; background: #89351d; flex: none; }
        .studies-kicker p {
            margin: 0;
            color: #89351d;
            font-family: "Space Grotesk", sans-serif;
            font-size: var(--kicker-size);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: 1.1px;
            text-transform: uppercase;
        }
        .studies-title {
            max-width: 14em;
            margin: 0;
            color: #111;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: var(--heading-size);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        .studies-filters {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 12px;
        }
        .studies-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px 40px;
        }
        .studies-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: var(--pill-h);
            padding: 0 var(--pill-px);
            border: 1px solid #d5cec2;
            border-radius: 9999px;
            background: transparent;
            color: #59554f;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: var(--pill-fs);
            font-weight: 500;
            line-height: 1;
            cursor: pointer;
        }
        .studies-pill.is-active {
            border-color: #2a2929;
            background: #2a2929;
            color: #faf7f2;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12), 0 2px 4px -2px rgba(0, 0, 0, 0.43);
        }
        .studies-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: var(--heading-gap);
        }
        @media (min-width: 640px) {
            .studies-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        .study-card {
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
            border-radius: 24px;
            background: #fbf9f6;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .study-card-media {
            position: relative;
            display: block;
            aspect-ratio: 563.333 / 253.424;
            background: #eae8e5;
            overflow: hidden;
            cursor: pointer;
        }
        .study-card-media img,
        .study-card-media video {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
        }
        .study-play {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            padding: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.12));
            cursor: pointer;
        }
        .study-play span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #d4af37;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35);
        }
        .study-play i {
            margin-left: 3px;
            color: #fff;
            font-size: 18px;
        }
        .study-card-category {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 3;
            margin: 0;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(251, 249, 246, 0.9);
            color: #89351d;
            font-family: "Space Grotesk", sans-serif;
            font-size: 10px;
            font-weight: 700;
            line-height: 14px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            pointer-events: none;
            -webkit-backdrop-filter: blur(12px);
            backdrop-filter: blur(12px);
        }
        .study-card-body {
            display: flex;
            flex: 1;
            flex-direction: column;
            justify-content: space-between;
            gap: 28px;
            padding: 24px;
        }
        .study-card-date {
            margin: 0 0 11px;
            color: #5f5e5e;
            font-family: "Space Grotesk", sans-serif;
            font-size: 10px;
            font-weight: 500;
            line-height: 14px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .study-card h3,
        .study-card h3 a {
            margin: 0;
            color: #1b1c1a;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 22px;
            font-weight: 600;
            line-height: 28px;
            text-decoration: none;
        }
        .study-card-excerpt {
            display: -webkit-box;
            margin: 11px 0 0;
            overflow: hidden;
            color: #5f5e5e;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 22px;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }
        .study-read {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            margin-top: auto;
            padding: 0;
            border: 0;
            background: transparent;
            color: #89351d;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 14px;
            font-weight: 700;
            line-height: 16px;
            letter-spacing: 1.32px;
            text-decoration: none;
            text-transform: uppercase;
            cursor: pointer;
        }
        .studies-empty {
            margin: 0;
            color: #5f5e5e;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 16px;
        }
        .studies-cta { display: flex; justify-content: center; margin-top: var(--cta-gap); }
        .study-card {
            transition: translate 0.5s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.5s ease;
        }
        .study-card:hover {
            translate: 0 -6px;
            box-shadow: 0 28px 50px -24px rgba(27, 28, 26, 0.35);
        }
        .study-card-media img,
        .study-card-media video { transition: scale 0.9s cubic-bezier(0.22, 1, 0.36, 1); }
        .study-card:hover .study-card-media img,
        .study-card:hover .study-card-media video { scale: 1.06; }
        .study-read img { transition: translate 0.25s ease; }
        .study-read:hover img { translate: 4px 0; }
        .study-card h3 a { transition: color 0.2s ease; }
        .study-card h3 a:hover { color: #89351d; }
        .studies-pill { transition: background-color 0.25s ease, color 0.25s ease, border-color 0.25s ease, padding 0.25s ease; }
        .studies-pill:not(.is-active):hover { border-color: #b36855; color: #89351d; }
        @media (min-width: 1024px) {
            .studies-filters { justify-content: flex-end; }
            .studies-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: clamp(20px, calc(46 * var(--fu)), 46px);
            }
            .study-card { min-height: clamp(440px, calc(597 * var(--fu)), 597px); border-radius: clamp(16px, calc(24 * var(--fu)), 24px); }
            .study-card-body { gap: clamp(20px, calc(28 * var(--fu)), 28px); padding: clamp(20px, calc(24 * var(--fu)), 24px); }
            .study-card-date {
                margin-bottom: 10px;
                font-size: clamp(10px, calc(12 * var(--fu)), 12px);
                line-height: 1.4;
                letter-spacing: 0.5px;
            }
            .study-card h3,
            .study-card h3 a {
                font-size: clamp(18px, calc(26 * var(--fu)), 26px);
                line-height: 1.25;
            }
            .study-card-excerpt {
                margin-top: 10px;
                font-size: clamp(14px, calc(18 * var(--fu)), 18px);
                line-height: 1.5;
            }
            .study-read {
                gap: 8px;
                font-size: clamp(13px, calc(16 * var(--fu)), 16px);
                letter-spacing: 1.32px;
            }
        }
    </style>
    @php
        $researchSection = \App\Models\Setting::getResearchSection();
    @endphp
    <div class="studies-head">
    <div class="studies-intro" data-reveal>
        <div class="studies-kicker">
            <span class="reveal-line" aria-hidden="true"></span>
            <p>Studies</p>
                                    </div>
        <h2 id="studies-heading" class="studies-title">{{ $researchSection['title'] }}</h2>
                                </div>
                                
    @php
        $homeFilters = \App\Models\Setting::getResearchHomeFilters();
    @endphp
    <div class="studies-filters" id="researchFilters" data-reveal>
        @foreach($homeFilters as $filter)
            <button type="button" data-research-filter="{{ $filter['key'] }}" class="studies-pill {{ $filter['key'] === 'all' ? 'is-active' : '' }}" aria-pressed="{{ $filter['key'] === 'all' ? 'true' : 'false' }}">{{ $filter['label'] }}</button>
        @endforeach
    </div>
    </div>

    @php
        $homeBlogs = isset($featuredBlogs) ? $featuredBlogs->take(3) : collect();
        $spotlightResearch = $spotlightResearch ?? collect();
        $featuredResearch = $featuredResearch ?? collect();
    @endphp

    <div data-research-panel="all">
        <div class="studies-grid" data-reveal-stagger>
            @php
                $allSlotOrder = collect($homeFilters)->pluck('key')->filter(fn ($key) => in_array($key, ['vision', 'research', 'blog'], true))->values();
                $allSlotShown = false;
            @endphp
            @foreach($allSlotOrder as $slotKey)
                @if($slotKey === 'blog')
                    @if($homeBlogs->isNotEmpty())
                        @php $allSlotShown = true; @endphp
                        @include('partials.home-blog-card', ['blog' => $homeBlogs->first(), 'studyCategory' => 'Blog'])
                    @endif
                @elseif(isset($spotlightResearch[$slotKey]) && $spotlightResearch[$slotKey]->isNotEmpty())
                    @php $allSlotShown = true; @endphp
                    @include('partials.home-research-card', ['item' => $spotlightResearch[$slotKey]->first(), 'studyCategory' => $slotKey === 'vision' ? 'Vision' : 'Research'])
                @endif
            @endforeach
            @if(! $allSlotShown)
                <p class="studies-empty">Nothing added to home yet.</p>
            @endif
                                        </div>
                                    </div>

    @foreach(['vision' => 'Vision', 'research' => 'Research', 'media' => 'Media'] as $key => $studyCategory)
        <div data-research-panel="{{ $key }}" class="hidden">
            <div class="studies-grid" data-reveal-stagger>
                @if(isset($featuredResearch[$key]) && $featuredResearch[$key]->isNotEmpty())
                    @foreach($featuredResearch[$key]->take(3) as $item)
                        @include('partials.home-research-card', ['item' => $item, 'studyCategory' => $studyCategory])
                        @endforeach
                    @else
                    <p class="studies-empty">Nothing added to home yet.</p>
                    @endif
            </div>
                </div>
            @endforeach

    <div data-research-panel="blog" class="hidden">
        <div class="studies-grid" data-reveal-stagger>
            @forelse($homeBlogs as $blog)
                @include('partials.home-blog-card', ['blog' => $blog, 'studyCategory' => 'Blog'])
            @empty
                <p class="studies-empty">No featured blogs yet.</p>
            @endforelse
        </div>
        </div>
        
    <div class="studies-cta" data-reveal>
        <a class="studies-view-all site-btn" href="{{ route('research.featured') }}">
            View all Studies
            <img src="{{ asset('images/studies/view-all-arrow.svg') }}" alt="" width="9.46875" height="3.75">
        </a>
        </div>
    <script>
        document.querySelectorAll('[data-research-filter]').forEach(function (button) {
            button.addEventListener('click', function () {
                var filter = button.getAttribute('data-research-filter');
                document.querySelectorAll('[data-research-filter]').forEach(function (item) {
                    var active = item === button;
                    item.classList.toggle('is-active', active);
                    item.setAttribute('aria-pressed', active ? 'true' : 'false');
                });
                document.querySelectorAll('[data-research-panel]').forEach(function (panel) {
                    panel.classList.toggle('hidden', panel.getAttribute('data-research-panel') !== filter);
                });
            });
        });
    </script>
</section>

<!-- Research Detail Modal -->
<div id="researchModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">   
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeResearchDetail()"></div>
        <div class="relative research-modal-panel max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <button type="button" onclick="closeResearchDetail()" class="research-close" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>

            <div id="researchDetailContent">
                <div class="text-center py-12">
                    <div class="inline-block">
                        <i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i>
                    </div>
                    <p class="mt-3 text-[#8a8a82]">Loading story...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="videoModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeVideoModal()"></div>
    <div class="relative max-w-4xl w-full bg-black rounded-2xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
        <button type="button" onclick="closeVideoModal()" class="absolute top-4 right-4 z-10 text-white/70 hover:text-[#D4AF37] bg-black/50 rounded-full p-2 transition-all duration-300 hover:scale-110" aria-label="Close video">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div id="videoContainer" class="aspect-video"></div>
    </div>
</div>
        {{--
                    <style>
                        .mission-scroll {
                            --gold: #D4AF37;
                            --ink: #1e1e1a;
                            --muted: #5a5a52;
                            --dial-size: min(52vw, 800px);
                            --dial-center: -0.02;
                            --number-margin: min(4vw, 64px);
                            position: relative;
                            width: 100%;
                            background: #f2f2f2;
                            overflow: clip;
                        }
                        .mission-scroll__kicker {
        <div id="videoContainer" class="aspect-video">
            <!-- Video will be loaded here -->
        </div>
    </div>
</div>
--}}
<script>
function openResearchDetail(id) {
    const modal = document.getElementById('researchModal');
    const content = document.getElementById('researchDetailContent');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = '0px';

    content.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block">
                <i class="fas fa-spinner fa-spin text-3xl text-[#D4AF37]"></i>
            </div>
            <p class="mt-3 text-[#8a8a82]">Loading story...</p>
        </div>
    `;

    fetch(`/research/${id}/detail`)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const item = data.data;
                const escapeHtml = (str) => {
                    if (!str) return '';
                    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                };

                const formatResearchContent = (value) => {
                    if (!value) return '';
                    if (!/<\/?[a-z][\s\S]*>/i.test(value)) {
                        return `<div class="research-detail-copy" style="white-space:pre-wrap">${escapeHtml(value)}</div>`;
                    }
                    return `<div class="research-detail-copy research-rich">${value}</div>`;
                };

                const categoryLabel = item.category === 'Research Papers' ? 'Research' : (item.category || '');
                const storyDate = item.created_at ? new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).toUpperCase() : '';

                content.innerHTML = `
                    <div class="research-detail">
                        <h2 class="research-detail-title">${escapeHtml(item.title)}</h2>
                        ${item.image_url ? `<div class="research-detail-media"><img src="${item.image_url}" alt="${escapeHtml(item.title)}"></div>` : ''}
                    ${item.video_url || item.video_file ? `
                            <div class="research-detail-media">
                            ${item.video_file ? 
                                    `<video controls class="w-full"><source src="${item.video_file}" type="video/mp4"></video>` :
                                item.video_embed_url ? 
                                    `<iframe src="${item.video_embed_url}" class="w-full aspect-video" allowfullscreen></iframe>` :
                                    `<div class="aspect-video flex items-center justify-center text-white">No video available</div>`
                            }
                        </div>
                    ` : ''}
                        <div class="research-detail-meta">
                            ${categoryLabel ? `<span class="research-chip">${escapeHtml(categoryLabel)}</span>` : ''}
                            ${item.is_featured ? '<span class="research-chip">Featured</span>' : ''}
                            ${storyDate ? `<span class="library-date">${storyDate}</span>` : ''}
                    </div>
                        <div class="research-block">
                            <h4 class="research-kicker"><span></span>About</h4>
                            <p class="research-detail-copy">${escapeHtml(item.description || '')}</p>
                        </div>
                    ${item.content ? `
                            <div class="research-block">
                                <h4 class="research-kicker"><span></span>Full story</h4>
                                ${formatResearchContent(item.content)}
                        </div>
                    ` : ''}
                        ${item.link_url ? `<div class="research-link"><a class="library-cta" href="${item.link_url}" target="_blank" rel="noopener noreferrer">Visit link</a></div>` : ''}
                        </div>
                `;
            } else {
                content.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">😕</div>
                        <p class="text-[#5a5a52]">${data.message || 'Failed to load research details'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-12">
                    <div class="text-5xl mb-4">😕</div>
                    <p class="text-[#5a5a52]">Oops! Something went wrong.</p>
                    <p class="text-sm text-[#8a8a82] mt-1">Please try again later.</p>
                </div>
            `;
        });
}

function closeResearchDetail() {
    const modal = document.getElementById('researchModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function playVideo(element, researchId) {
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');
    
    container.innerHTML = `
        <div class="w-full h-full flex items-center justify-center text-white">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin text-4xl text-[#D4AF37]"></i>
                <p class="mt-2 text-gray-400 text-sm">Loading video...</p>
            </div>
        </div>
    `;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    fetch(`/research/${researchId}/video`)
        .then(response => response.json())
        .then(data => {
            if (data.video_file) {
                container.innerHTML = `
                    <video controls autoplay class="w-full h-full">
                        <source src="${data.video_file}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                `;
            } else if (data.video_embed_url) {
                container.innerHTML = `
                    <iframe src="${data.video_embed_url}" class="w-full h-full" allowfullscreen></iframe>
                `;
            } else {
                container.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center text-white">
                        <div class="text-center">
                            <p>No video available</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading video:', error);
            container.innerHTML = `
                <div class="w-full h-full flex items-center justify-center text-white">
                    <p>Error loading video. Please try again.</p>
                </div>
            `;
        });
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');
    modal.classList.add('hidden');
    container.innerHTML = '';
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeResearchDetail();
        closeVideoModal();
    }
});
</script>
{{--

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

#videoModal {
    animation: fadeIn 0.25s ease;
}

#researchModal {
    animation: fadeIn 0.3s ease;
}

#researchModal .relative {
    animation: scaleIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes scaleIn {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

#researchDetailContent::-webkit-scrollbar {
    width: 6px;
}

#researchDetailContent::-webkit-scrollbar-track {
    background: #f5f5f5;
    border-radius: 10px;
}

#researchDetailContent::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 10px;
}

#researchDetailContent::-webkit-scrollbar-thumb:hover {
    background: #c4a030;
}

/* Prose styling for content */
.prose {
    font-size: 1rem;
    line-height: 1.75;
    color: #3a3a34;
}

.prose p {
    margin-bottom: 1rem;
}

/* Hover effects */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

/* Smooth transitions */
.transition-all {
    transition-duration: 300ms;
}
</style>

    {{-- FEATURED BLOGS SECTION
    <section id="featured-blogs" class="py-24 bg-[#fff6e0] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
                <div>
                    <h2 class="text-4xl font-serif font-bold text-[#1e1e1a]">Featured Blogs</h2>
                    <p class="text-[#3a3a34] mt-2 max-w-lg">Explore insights, stories, and ideas from my journey.</p>
                </div>
            </div>

            @if(isset($featuredBlogs) && $featuredBlogs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredBlogs as $blog)
                        <a href="{{ route('blog.show', $blog->slug) }}" 
                        class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative overflow-hidden h-52">
                                @if($blog->featured_image_url)
                                    <img src="{{ $blog->featured_image_url }}" 
                                        alt="{{ $blog->title }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-[#D4AF37]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 bg-[#D4AF37] text-[#0b0e12] text-xs font-bold rounded-full">
                                        Featured
                                    </span>
                                </div>
                                @if($blog->category)
                                    <div class="absolute bottom-3 left-3">
                                        <span class="px-3 py-1 bg-black/60 text-white text-xs font-medium rounded-full backdrop-blur-sm">
                                            {{ $blog->category }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                    <span>{{ $blog->short_date }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-13h-2v6l5.25 3.15L17 12.23l-4-2.37V7z"/>
                                        </svg>
                                        {{ $blog->reading_time ?? '5 min read' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-[#1e1e1a] mb-2 group-hover:text-[#D4AF37] transition-colors line-clamp-2">
                                    {{ $blog->title }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content ?? ''), 120) }}
                                </p>
                                <div class="mt-4 flex items-center gap-2 text-sm text-[#D4AF37] font-medium">
                                    Read More 
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('blog') }}" 
                    class="inline-flex items-center gap-2 px-8 py-3 bg-[#D4AF37] text-[#0b0e12] font-bold rounded-lg hover:bg-[#c4a030] transition-all shadow-lg shadow-[#D4AF37]/20 hover:shadow-[#D4AF37]/40 hover:-translate-y-0.5">
                        View All Blogs
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-white/50 rounded-xl">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                    </svg>
                    <p class="text-gray-500">No featured blogs yet. Check back soon!</p>
                </div>
            @endif
        </div>
    </section>
    --}}

    <section id="news" class="news-section scroll-mt-20">
        <style>
            .news-section {
                background: #fbf9f6;
                color: #1b1c1a;
                padding: var(--section-y) 0;
            }
            .news-wrap {
                width: var(--site-width);
                margin: 0 auto;
            }
            .news-kicker {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .news-kicker-dash {
                width: 24px;
                height: 2px;
                background: #89351d;
                flex: none;
            }
            .news-kicker p {
                margin: 0;
                font-family: "Space Grotesk", Inter, sans-serif;
                font-size: var(--kicker-size);
                font-weight: 700;
                line-height: 1.15;
                letter-spacing: 1.1px;
                text-transform: uppercase;
                color: #89351d;
            }
            .news-heading {
                margin: var(--kicker-gap) 0 0;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                font-size: var(--heading-size);
                font-weight: 700;
                line-height: 1.1;
                letter-spacing: -0.02em;
                color: #1b1c1a;
            }
            .news-layout {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                gap: 28px;
                margin-top: var(--heading-gap);
            }
            .news-feature-media {
                position: relative;
                display: block;
                width: 100%;
                padding: 0;
                border: 0;
                background: #efeae3;
                border-radius: 8px;
                overflow: hidden;
                aspect-ratio: 16 / 7;
                cursor: pointer;
            }
            .news-feature-media img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
            .news-feature-badge {
                position: absolute;
                top: 12px;
                left: 12px;
                padding: 6px 12px;
                border-radius: 999px;
                background: #fbf9f6;
                color: #7f2f1a;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                font-size: 11px;
                font-weight: 700;
                line-height: 1;
                letter-spacing: 0.4px;
            }
            .news-feature-meta {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-top: 12px;
            }
            .news-feature-cat,
            .news-row-cat {
                margin: 0;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                font-weight: 700;
                color: #7f2f1a;
                letter-spacing: 0.4px;
                text-transform: uppercase;
            }
            .news-feature-cat { font-size: 12px; line-height: 16px; }
            .news-feature-date,
            .news-row-date {
                margin: 0;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                font-weight: 400;
                color: #59554f;
            }
            .news-feature-date { font-size: 12px; line-height: 16px; }
            .news-feature-title {
                margin: 8px 0 0;
                max-width: 640px;
                font-family: Poppins, Inter, sans-serif;
                font-size: clamp(22px, 1.9vw, 28px);
                font-weight: 600;
                line-height: 1.25;
                color: #2f2f2f;
            }
            .news-feature-excerpt {
                margin: 8px 0 0;
                max-width: 640px;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.55;
                color: #59554f;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .news-story-btn { margin-top: 18px; }
            .news-story-icon {
                position: relative;
                width: 14px;
                height: 14px;
                flex: none;
            }
            .news-story-icon img {
                position: absolute;
                max-width: none;
            }
            .news-story-icon img:first-child { left: 1.28px; top: 1.28px; }
            .news-story-icon img:last-child { left: 2.45px; top: 1.28px; }
            .news-side { min-width: 0; }
            .news-row {
                display: flex;
                align-items: flex-start;
                gap: 16px;
                width: 100%;
                margin: 0;
                padding: 16px 0;
                border: 0;
                border-top: 1px solid #d5cec2;
                background: transparent;
                color: inherit;
                text-align: left;
                cursor: pointer;
                font: inherit;
            }
            .news-row-copy { min-width: 0; flex: 1; }
            .news-row-cat, .news-row-date { display: block; }
            .news-row-cat { font-size: 11px; line-height: 14px; }
            .news-row-titleline {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                margin-top: 8px;
            }
            .news-row-title {
                margin: 0;
                flex: 1;
                min-width: 0;
                font-family: Poppins, Inter, sans-serif;
                font-size: clamp(16px, 1.25vw, 18px);
                font-weight: 600;
                line-height: 1.25;
                color: #2f2f2f;
            }
            .news-row-titleline img { flex: none; margin-top: 2px; max-width: none; }
            .news-row-excerpt {
                margin: 8px 0 0;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                font-size: 14px;
                font-weight: 500;
                line-height: 1.6;
                color: #59554f;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .news-row-date { margin-top: 10px; font-size: 11px; line-height: 14px; }
            .news-row-thumb {
                width: 128px;
                height: 112px;
                border-radius: 8px;
                object-fit: cover;
                flex: none;
                background: #efeae3;
            }
            .news-row-thumb--empty { display: block; }
            .news-feature-media img,
            .news-row-thumb { transition: scale 0.9s cubic-bezier(0.22, 1, 0.36, 1); }
            .news-feature-media:hover img { scale: 1.04; }
            .news-row:hover .news-row-thumb { scale: 1.05; }
            .news-row-titleline img { transition: translate 0.25s ease; }
            .news-row:hover .news-row-titleline img { translate: 3px -3px; }
            .news-row-title { transition: color 0.2s ease; }
            .news-row:hover .news-row-title { color: #89351d; }
            .news-view {
                display: flex;
                justify-content: center;
                margin-top: var(--cta-gap);
            }
            .news-empty {
                margin-top: 48px;
                text-align: center;
                font-family: "Plus Jakarta Sans", Inter, sans-serif;
                font-size: 14px;
                color: #5f5e5e;
            }
            @media (max-width: 720px) {
                .news-row { gap: 12px; padding: 14px 0; }
                .news-row-thumb,
                .news-row-thumb--empty { width: 96px; height: 84px; }
            }
            @media (min-width: 1024px) {
                .news-layout {
                    grid-template-columns: minmax(0, 784fr) minmax(0, 771fr);
                    column-gap: clamp(28px, 4vw, 64px);
                    align-items: start;
                }
            }
        </style>
        @php
            $newsContent = \App\Models\Setting::getNewsContent();
            $newsItems = $newsItems ?? collect();
            $featuredNews = $newsItems->first();
            $sideNews = $newsItems->slice(1)->values();
            $newsHeading = trim((string) ($newsContent['heading'] ?? 'Latest News and Activities'));
            $newsHeadingHtml = e($newsHeading);
            if (preg_match('/^(Latest News)\s+(and Activities)$/i', $newsHeading, $newsHeadingParts)) {
                $newsHeadingHtml = e($newsHeadingParts[1]).'<br>'.e($newsHeadingParts[2]);
            }
            $newsDate = function ($item) {
                $date = $item->published_at ?? $item->created_at;

                return $date ? mb_strtoupper($date->format('d M Y')) : null;
            };
        @endphp
        <div class="news-wrap">
            <div data-reveal>
                <div class="news-kicker">
                    <span class="news-kicker-dash reveal-line" aria-hidden="true"></span>
                    <p>{{ $newsContent['label'] }}</p>
                </div>
                <h2 class="news-heading">{!! $newsHeadingHtml !!}</h2>
            </div>

            @if($featuredNews)
                <div class="news-layout">
                    <article data-reveal>
                        <button type="button" class="news-feature-media" onclick="openNewsDetail({{ $featuredNews->id }})">
                            @if($featuredNews->image_url)
                                <img src="{{ $featuredNews->image_url }}" alt="{{ $featuredNews->title }}">
                            @endif
                            <span class="news-feature-badge">FEATURED</span>
                        </button>
                        <div class="news-feature-meta">
                            <p class="news-feature-cat">{{ $featuredNews->badgeLabel() }}</p>
                            @if($newsDate($featuredNews))
                                <p class="news-feature-date">{{ $newsDate($featuredNews) }}</p>
                            @endif
                        </div>
                        <h3 class="news-feature-title">{{ $featuredNews->title }}</h3>
                        @if($featuredNews->excerpt)
                            <p class="news-feature-excerpt">{{ $featuredNews->excerpt }}</p>
                        @endif
                        <button type="button" class="news-story-btn site-btn site-btn--sm" onclick="openNewsDetail({{ $featuredNews->id }})">
                            Read the story
                            <span class="news-story-icon" aria-hidden="true">
                                <img src="{{ asset('images/news-story-arrow-a.svg') }}" alt="" width="11.4333" height="11.4333">
                                <img src="{{ asset('images/news-story-arrow-b.svg') }}" alt="" width="10.2667" height="10.2667">
                            </span>
                        </button>
                    </article>

                    @if($sideNews->isNotEmpty())
                        <div class="news-side" data-reveal-stagger>
                            @foreach($sideNews as $item)
                                <button type="button" class="news-row" onclick="openNewsDetail({{ $item->id }})">
                                    <span class="news-row-copy">
                                        <span class="news-row-cat">{{ $item->badgeLabel() }}</span>
                                        <span class="news-row-titleline">
                                            <span class="news-row-title">{{ $item->title }}</span>
                                            <img src="{{ asset('images/news-arrow-up-right.svg') }}" alt="" width="22" height="22">
                                        </span>
                                        @if($item->excerpt)
                                            <span class="news-row-excerpt">{{ $item->excerpt }}</span>
                                        @endif
                                        @if($newsDate($item))
                                            <span class="news-row-date">{{ $newsDate($item) }}</span>
                                        @endif
                                    </span>
                                    @if($item->image_url)
                                        <img class="news-row-thumb" src="{{ $item->image_url }}" alt="">
                                    @else
                                        <span class="news-row-thumb news-row-thumb--empty" aria-hidden="true"></span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="news-view" data-reveal>
                    <a href="{{ route('news.index') }}" class="gallery-explore site-btn">
                        View all Articles
                        <img src="{{ asset('images/gallery-explore-arrow.svg') }}" alt="" width="9.46875" height="3.75">
                    </a>
                </div>
            @else
                <p class="news-empty">News will appear here once a link is added.</p>
            @endif
        </div>
    </section>

    @include('partials.news-modal')

    <section id="gallery" class="gallery-section scroll-mt-20">
        @php
            $gallerySection = \App\Models\Setting::getGallerySection();
            $galleryTitle = trim((string) ($gallerySection['title'] ?? ''));
        @endphp
        <div class="gallery-wrap" data-reveal>
            <div class="gallery-marker">
                <span class="gallery-dash reveal-line" aria-hidden="true"></span>
                <p class="gallery-kicker">{{ $gallerySection['label'] }}</p>
            </div>
            <h2 class="gallery-title">
                @if($galleryTitle !== '')
                    {{ $galleryTitle }}
                @else
                    My work. The projects<br>& moments between.
                @endif
            </h2>
        </div>

        @if($galleryCollections->isNotEmpty())
            <div class="gallery-scroller" tabindex="0" aria-label="Photo collections" data-reveal-stagger>
                @foreach($galleryCollections as $collection)
                    @php
                        $previewImages = $collection->images->take(4);
                        $lead = $previewImages->first();
                        $sideImages = $previewImages->slice(1, 3);
                    @endphp
                    <a href="{{ route('gallery.show', $collection) }}" class="gallery-card {{ $sideImages->isEmpty() ? 'gallery-card-single' : '' }}" aria-label="View {{ $collection->title }}">
                        <div class="gallery-card-lead">
                            <img src="{{ $lead->url }}" alt="{{ $collection->title }}" draggable="false">
                            <span class="gallery-card-scrim" aria-hidden="true"></span>
                            <span class="gallery-card-count">
                                <img src="{{ asset('images/gallery-count.svg') }}" alt="" width="16" height="16">
                                <span>{{ $collection->images->count() }}</span>
                            </span>
                            <div class="gallery-card-copy">
                                <time class="gallery-card-date" datetime="{{ $collection->created_at->toDateString() }}">{{ $collection->created_at->format('M Y') }}</time>
                                <h3>{{ $collection->title }}</h3>
                            </div>
                        </div>
                        @if($sideImages->isNotEmpty())
                            <div class="gallery-card-side">
                                @foreach($sideImages as $image)
                                    <div class="gallery-card-thumb">
                                        <img src="{{ $image->url }}" alt="" draggable="false">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
            <div class="gallery-action" data-reveal>
                <a href="{{ route('gallery.index') }}" class="gallery-explore site-btn">
                    Explore gallery
                    <img src="{{ asset('images/gallery-explore-arrow.svg') }}" alt="" width="9.46875" height="3.75">
                </a>
            </div>
        @else
            <p class="gallery-empty">{{ $gallerySection['empty'] }}</p>
        @endif
    </section>

    {{-- <section class="py-24 bg-gradient-to-b from-[#f2efe8] to-[#faf8f5] text-[#1e1e1a]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-[#D4AF37]/10 px-4 py-2 rounded-full mb-4">
                    <span class="text-[#D4AF37]">✦</span>
                    <span class="text-xs font-semibold text-[#D4AF37] uppercase tracking-widest">Join the work</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#1e1e1a] leading-tight">
                    Let's Build the <span class="text-[#D4AF37]">Future</span> Together
                </h2>
                <p class="text-[#5a5a52] mt-4 max-w-2xl mx-auto text-lg leading-relaxed">
                    Whether you are a municipality, school, organization, investor or a passionate individual, there is a place for you in this journey.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                <a href="{{ route('bootcamp') }}" class="group bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Municipalities</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Book Bootcamp</p>
                </a>

                <a href="https://skillsikka.com/" target="_blank" rel="noopener noreferrer" class="group bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Schools</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Skill Sikka</p>
                </a>

                <a href="https://hillychilly.com/" target="_blank" rel="noopener noreferrer" class="group bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Tourism</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">HillyChilly</p>
                </a>

                <button type="button" data-open-work="investor" class="group w-full bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Investors</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Meet</p>
                </button>

                <button type="button" data-open-work="builder" class="group col-span-2 md:col-span-1 w-full bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-1 border border-gray-100/50 hover:border-[#D4AF37]/20">
                    <div class="w-10 h-10 mx-auto mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37] group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 20c4.478 0 8.268-2.943 9.542-7-1.274-4.057-5.064-7-9.542-7-4.477 0-8.268 2.943-9.542 7"/></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#8a8a82] mb-1">Volunteers</p>
                    <p class="text-sm font-bold text-[#1e1e1a] group-hover:text-[#735A12]">Join Future</p>
                </button>
            </div>
        </div>
    </section> --}}

    <style>
        html { scroll-behavior: smooth; }
        .reveal-ready [data-reveal]:not(.reveal-done),
        .reveal-ready [data-reveal-stagger] > :not(.reveal-done) {
            transition: opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1), transform 0.9s cubic-bezier(0.22, 1, 0.36, 1);
            transition-delay: var(--reveal-delay, 0s);
        }
        .reveal-ready [data-reveal]:not(.is-revealed),
        .reveal-ready [data-reveal-stagger] > :not(.is-revealed) {
            opacity: 0;
            transform: translate3d(0, 32px, 0);
        }
        .reveal-line {
            transform-origin: left center;
            transition: transform 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.25s;
        }
        .reveal-ready [data-reveal]:not(.is-revealed) .reveal-line { transform: scaleX(0); }
        .impact-section { padding: var(--section-y) 0; }
        .impact-kicker { margin: 0; font-size: var(--kicker-size); line-height: 1.15; }
        .impact-heading {
            margin: var(--kicker-gap) 0 0;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: var(--heading-size);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        .impact-layout {
            display: flex;
            flex-direction: column;
            gap: var(--heading-gap);
        }
        @media (min-width: 1536px) {
            .impact-layout { flex-direction: row; align-items: center; gap: 56px; }
            .impact-intro { flex: 0 0 clamp(260px, 14vw, 380px); }
        }
        .impact-stat { transition: background-color 0.35s ease; }
        .impact-stat:hover { background-color: #171c26; }
        .impact-stat > img { transition: translate 0.35s cubic-bezier(0.22, 1, 0.36, 1); }
        .impact-stat:hover > img { translate: 0 -4px; }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
        }
    </style>
    <script>
        (function () {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;
            var targets = document.querySelectorAll('[data-reveal], [data-reveal-stagger] > *');
            if (!targets.length) return;
            document.documentElement.classList.add('reveal-ready');

            var observer = new IntersectionObserver(function (entries) {
                var batch = entries
                    .filter(function (entry) { return entry.isIntersecting || entry.boundingClientRect.bottom < 0; })
                    .map(function (entry) { return entry.target; })
                    .sort(function (a, b) {
                        return a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1;
                    });

                batch.forEach(function (el, index) {
                    var delay = Math.min(index, 6) * 90;
                    observer.unobserve(el);
                    el.style.setProperty('--reveal-delay', delay + 'ms');
                    el.classList.add('is-revealed');
                    window.setTimeout(function () {
                        el.classList.add('reveal-done');
                        el.style.removeProperty('--reveal-delay');
                    }, delay + 1000);
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

            targets.forEach(function (el) { observer.observe(el); });
        })();
    </script>
@endsection

<style>
#projects {
    overflow: hidden !important;
}

.initiatives-section {
    position: relative;
    isolation: isolate;
    overflow: hidden;
    padding: var(--section-y) 0 max(24px, calc(var(--section-y) - 64px));
    background: #f7f7f5;
    color: #111111;
}

.initiatives-cubes {
    position: absolute;
    z-index: -1;
    inset: 0;
    width: 100%;
    height: 100%;
    animation-play-state: paused;
}

.initiatives-section.is-visible .initiatives-cubes {
    animation-play-state: running;
}

.initiatives-section .hero-cubes-b {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}

.initiatives-content {
    position: relative;
    z-index: 1;
}

.initiatives-heading {
    transition: opacity 650ms ease, transform 650ms cubic-bezier(0.22, 1, 0.36, 1);
}

.initiatives-kicker {
    display: flex;
    align-items: center;
    gap: 8px;
}

.initiatives-kicker > span {
    width: 24px;
    height: 2px;
    flex: 0 0 auto;
    background: #89351d;
}

.initiatives-kicker p {
    margin: 0;
    color: #89351d;
    font-family: "Space Grotesk", sans-serif;
    font-size: var(--kicker-size);
    font-weight: 700;
    line-height: 1.15;
    letter-spacing: 1.1px;
    text-transform: uppercase;
}

.initiatives-heading h2 {
    margin: var(--kicker-gap) 0 0;
    color: #1b1c1a;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
    font-size: var(--heading-size);
    letter-spacing: -0.02em;
    font-weight: 700;
    line-height: 1.1;
}

.initiatives-viewport {
    width: 100%;
    padding-block: var(--heading-gap) 64px;
    overflow-x: auto;
    overscroll-behavior-x: contain;
    scrollbar-width: none;
    scroll-snap-type: x mandatory;
    -webkit-mask-image: linear-gradient(to right, transparent, #000 3%, #000 97%, transparent);
    mask-image: linear-gradient(to right, transparent, #000 3%, #000 97%, transparent);
    touch-action: pan-x;
}

.initiatives-viewport::-webkit-scrollbar {
    display: none;
}

.initiatives-viewport:focus-visible {
    outline: 2px solid #89351d;
    outline-offset: -2px;
}

.initiatives-track {
    display: flex;
    width: max-content;
    gap: 20px;
    padding-inline: var(--site-edge);
    align-items: flex-start;
}

.initiative-card {
    position: relative;
    flex: 0 0 calc((100vw - 120px) / 5.2);
    width: calc((100vw - 120px) / 5.2);
    height: 350px;
    color: #111111;
    text-align: center;
    scroll-snap-align: center;
    transition: opacity 650ms ease, transform 650ms cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease;
    transition-delay: calc(var(--initiative-index, 0) * 70ms);
    overflow: visible;
}

.initiative-card:hover {
    transform: translateY(-4px);
    z-index: 20;
}

.project-default {
    position: relative;
    width: 100%;
    height: 100%;
    transition: opacity 0.25s ease, transform 0.35s ease;
}

.initiative-card-surface {
    position: absolute;
    inset: 38px 0 0;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.72);
    background: rgba(255, 255, 255, 0.3);
    background: color-mix(in srgb, var(--initiative-bg, #ffffff) 18%, transparent);
    box-shadow: 0 16px 38px rgba(31, 38, 48, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.62);
    -webkit-backdrop-filter: blur(20px) saturate(145%);
    backdrop-filter: blur(20px) saturate(145%);
}

.initiative-card:nth-child(1) .initiative-card-surface,
.initiative-card:nth-child(5) .initiative-card-surface {
    inset-block: 38px 0;
}

.initiative-mark {
    position: absolute;
    top: 6px;
    left: 50%;
    display: flex;
    width: 92px;
    height: 92px;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 1px solid rgba(212, 175, 55, 0.28);
    border-radius: 50%;
    background: #ffffff;
    transform: translateX(-50%);
}

.initiative-card:nth-child(1) .initiative-mark,
.initiative-card:nth-child(5) .initiative-mark {
    top: 0;
}

.initiative-mark img {
    display: block;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: contain;
}

.initiative-mark > span {
    display: flex;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #101417;
    color: #f3c64e;
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 48px;
    font-weight: 700;
}

.initiative-card h3 {
    position: absolute;
    top: 128px;
    right: 12px;
    left: 12px;
    margin: 0;
    color: #111111;
    font-family: Poppins, "Plus Jakarta Sans", sans-serif;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -0.02em;
}

.initiative-card:nth-child(1) h3,
.initiative-card:nth-child(5) h3 {
    top: 128px;
}

.initiative-card > p,
.initiative-card .project-default > p {
    position: absolute;
    top: 178px;
    left: 50%;
    width: calc(100% - 32px);
    max-width: calc(100% - 44px);
    max-height: 72px;
    margin: 0;
    overflow: hidden;
    color: #46433f;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
    transform: translateX(-50%);
}

.initiative-card:nth-child(1) > p,
.initiative-card:nth-child(1) .project-default > p,
.initiative-card:nth-child(5) > p,
.initiative-card:nth-child(5) .project-default > p {
    top: 178px;
}

.initiative-read-more {
    position: absolute;
    top: 267px;
    left: 50%;
    display: inline-flex;
    min-height: 44px;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #89351d;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1.1px;
    text-decoration: none;
    text-transform: uppercase;
    transform: translateX(-50%);
}

.initiative-card:nth-child(1) .initiative-read-more,
.initiative-card:nth-child(5) .initiative-read-more {
    top: 267px;
}

.tooltip-container .project-default {
    opacity: 1;
    transition: opacity 0.25s ease, transform 0.35s ease;
}

.tooltip-container:hover .project-default,
.tooltip-container.is-open .project-default {
    opacity: 0;
    transform: scale(0.97);
    pointer-events: none;
}

.initiative-card:hover,
.initiative-card.is-open {
    transition-delay: 0s;
}

.tooltip-popup {
    position: absolute;
    left: 50%;
    top: 50%;
    width: min(350px, calc(100% + 40px));
    min-height: 280px;
    padding: 20px 18px 18px;
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(212, 175, 55, 0.45);
    border-radius: 18px;
    box-shadow: 0 22px 45px rgba(17, 17, 17, 0.18);
    text-align: left;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translate(-50%, -50%) scale(0.84);
    transition: opacity 0.28s ease, visibility 0.28s ease, transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 30;
}

.tooltip-container:hover .tooltip-popup,
.tooltip-container.is-open .tooltip-popup {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translate(-50%, -50%) scale(1);
}

.project-popup-content {
    display: flex;
    flex-direction: column;
    gap: 12px;
    height: 100%;
}

.project-popup-content h4 {
    margin: 0;
    color: #111111;
    font-size: 22px;
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -0.02em;
}

.project-popup-content p {
    margin: 0;
    color: #46433f;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
    font-size: 15px;
    line-height: 1.7;
    overflow: auto;
}

.project-popup-content a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: fit-content;
    margin-top: 4px;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: #89351d;
    text-decoration: none;
    text-transform: uppercase;
}

.project-popup-content a:hover {
    text-decoration: underline;
    text-underline-offset: 4px;
}

.project-popup-content .project-visit-link img {
    display: block;
    width: 18px;
    height: auto;
}

.popup-image {
    display: flex;
    width: 100%;
    height: 110px;
    align-items: center;
    border-radius: 12px;
    border: 1px solid rgba(212, 175, 55, 0.2);
    background: color-mix(in srgb, var(--initiative-bg, #ffffff) 26%, rgba(255, 255, 255, 0.9));
    overflow: hidden;
}

.popup-image img {
    display: block;
    width: 90px;
    height: 90px;
    object-fit: contain;
}

.popup-image span {
    display: grid;
    place-items: center;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #101417;
    color: #f3c64e;
    font-family: "Plus Jakarta Sans", sans-serif;
    font-size: 36px;
    font-weight: 700;
}

.initiative-read-more:hover span {
    text-decoration: underline;
    text-underline-offset: 4px;
}

.initiative-read-more:focus-visible {
    border-radius: 2px;
    outline: 2px solid #89351d;
    outline-offset: 4px;
}

.initiative-read-more img {
    display: block;
}

.initiatives-empty {
    margin: 0;
    padding: 40px 24px;
    color: #5f5e5e;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
}

.initiatives-reveal-ready #projects:not(.is-visible) .initiatives-heading,
.initiatives-reveal-ready #projects:not(.is-visible) .initiative-card {
    opacity: 0;
    transform: translateY(42px);
}

.initiatives-reveal-ready #projects.is-visible .initiatives-heading,
.initiatives-reveal-ready #projects.is-visible .initiative-card {
    opacity: 1;
    transform: translateY(0);
}

@media (max-width: 767px) {
    .initiative-card {
        flex-basis: 170px;
        width: 170px;
        height: 330px;
    }

    .initiative-card-surface {
        inset: 34px 0 0;
    }

    .initiative-card:nth-child(1) .initiative-card-surface,
    .initiative-card:nth-child(5) .initiative-card-surface {
        inset-block: 44px 0;
    }

    .initiative-mark,
    .initiative-mark img,
    .initiative-mark > span {
        width: 72px;
        height: 72px;
    }

    .initiative-card:nth-child(1) .initiative-mark,
    .initiative-card:nth-child(5) .initiative-mark {
        top: 0;
    }

    .initiative-card h3 {
        top: 125px;
        font-size: 14px;
    }

    .initiative-card:nth-child(1) h3,
    .initiative-card:nth-child(5) h3 {
        top: 125px;
    }

    .initiative-card > p,
    .initiative-card .project-default > p {
        top: 170px;
        width: calc(100% - 20px);
        max-height: 50px;
        font-size: 11px;
    }

    .initiative-card:nth-child(1) > p,
    .initiative-card:nth-child(1) .project-default > p,
    .initiative-card:nth-child(5) > p,
    .initiative-card:nth-child(5) .project-default > p {
        top: 170px;
    }

    .initiative-read-more {
        top: 262px;
        font-size: 11px;
    }

    .initiative-card:nth-child(1) .initiative-read-more,
    .initiative-card:nth-child(5) .initiative-read-more {
        top: 262px;
    }
}

@media (min-width: 768px) and (max-width: 1100px) {
    .initiative-card {
        flex-basis: calc((100vw - 88px) / 3);
        width: calc((100vw - 88px) / 3);
    }
}

@media (prefers-reduced-motion: reduce) {
    .initiatives-cubes,
    .initiative-card,
    .initiatives-heading {
        animation: none !important;
        transition: none !important;
    }

    .initiatives-reveal-ready #projects:not(.is-visible) .initiatives-heading,
    .initiatives-reveal-ready #projects:not(.is-visible) .initiative-card {
        opacity: 1;
        transform: none;
    }
}

.carousel-container {
    mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
    -webkit-mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
}

.carousel-track {
    animation: none;
    will-change: transform;
    touch-action: pan-y;
    user-select: none;
}

.carousel-track:hover {
    animation-play-state: paused;
}

/* Pointer dragging is enabled by the scoped script below. */
.carousel-track.carousel-drag-ready {
    animation: none;
    cursor: grab;
}

.carousel-track.carousel-drag-ready.is-dragging {
    cursor: grabbing;
    transition: none !important;
}

.carousel-track.carousel-drag-ready.is-settling {
    transition: transform 180ms ease-out;
}

.gallery-section {
    background: #fff;
    color: #111;
    padding: var(--section-y) 0;
}

.gallery-wrap,
.gallery-empty {
    width: var(--site-width);
    margin-inline: auto;
}

.gallery-marker {
    display: flex;
    align-items: center;
    gap: 8px;
}

.gallery-dash {
    display: block;
    width: 24px;
    height: 2px;
    flex: none;
    background: #89351d;
}

.gallery-kicker {
    margin: 0;
    color: #89351d;
    font-family: "Space Grotesk", Inter, sans-serif;
    font-size: var(--kicker-size);
    font-weight: 700;
    letter-spacing: 1.1px;
    line-height: 1.15;
    text-transform: uppercase;
}

.gallery-title {
    max-width: 16em;
    margin: var(--kicker-gap) 0 0;
    color: #111;
    font-family: "Plus Jakarta Sans", Inter, sans-serif;
    font-size: var(--heading-size);
    font-weight: 700;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

.gallery-empty {
    margin-top: 2rem;
    color: #5a5a52;
    font-size: 0.95rem;
}

.gallery-scroller {
    display: flex;
    gap: 16px;
    margin-top: calc(var(--heading-gap) - 12px);
    overflow-x: auto;
    padding-top: 12px;
    padding-bottom: 20px;
    padding-inline: var(--site-edge);
    scroll-padding-inline: var(--site-edge);
    cursor: grab;
    user-select: none;
    touch-action: pan-x;
    scrollbar-width: none;
    scroll-snap-type: x proximity;
}

.gallery-scroller.is-dragging {
    cursor: grabbing;
    scroll-snap-type: none;
}

.gallery-scroller.is-dragging .gallery-card {
    cursor: grabbing;
    pointer-events: none;
}

.gallery-card {
    --gallery-card-w: min(78vw, clamp(420px, 18vw + 220px, 620px));
    scroll-snap-align: start;
    flex: 0 0 auto;
    display: flex;
    gap: 2px;
    width: var(--gallery-card-w);
    height: calc(var(--gallery-card-w) * 292 / 480);
    border-radius: clamp(8px, 0.6vw, 14px);
    overflow: hidden;
    background: #f7f4ee;
    text-decoration: none;
    color: inherit;
    cursor: grab;
    -webkit-user-drag: none;
    user-select: none;
}

.gallery-card-single .gallery-card-lead {
    flex: 1 1 auto;
}

.gallery-card-lead {
    position: relative;
    flex: 476 1 0;
    min-width: 0;
    height: 100%;
}

.gallery-card-lead > img,
.gallery-card-thumb img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
}

.gallery-card-scrim {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(19, 24, 14, 0) 40%, rgba(19, 24, 14, 0.85) 100%);
    pointer-events: none;
}

.gallery-card-count,
.gallery-card-copy {
    position: absolute;
    z-index: 1;
}

.gallery-card-count {
    top: 12px;
    left: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    height: 28px;
    min-width: 58px;
    padding: 0 10px;
    border: 1px solid #d5cec2;
    border-radius: 8px;
    background: #fff;
    color: #333;
    font-family: Poppins, "Plus Jakarta Sans", Inter, sans-serif;
    font-size: 14px;
    font-weight: 600;
    line-height: 1;
}

.gallery-card-copy {
    left: 16px;
    right: 16px;
    bottom: 16px;
}

.gallery-card-date {
    display: block;
    margin: 0 0 4px;
    color: rgba(255, 255, 255, 0.82);
    font-family: Poppins, "Plus Jakarta Sans", Inter, sans-serif;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.04em;
    line-height: 1.2;
}

.gallery-card-copy h3 {
    margin: 0;
    color: #fff;
    font-family: Poppins, "Plus Jakarta Sans", Inter, sans-serif;
    font-size: clamp(1.25rem, 1.6vw, 26px);
    font-weight: 600;
    line-height: 1.1;
}

.gallery-card-side {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex: 148 1 0;
    min-width: 0;
    height: 100%;
    overflow: hidden;
}

.gallery-card-thumb {
    position: relative;
    flex: 1 1 0;
    min-height: 0;
}

.gallery-scroller::-webkit-scrollbar {
    display: none;
}

.gallery-card {
    transition: translate 0.5s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.5s ease;
}

.gallery-card-lead > img,
.gallery-card-thumb img {
    transition: scale 1s cubic-bezier(0.22, 1, 0.36, 1);
}

.gallery-card:hover {
    translate: 0 -6px;
    box-shadow: 0 22px 40px -22px rgba(19, 24, 14, 0.55);
}

.gallery-card:hover .gallery-card-lead > img,
.gallery-card:hover .gallery-card-thumb img {
    scale: 1.06;
}

.gallery-action {
    display: flex;
    justify-content: center;
    margin-top: calc(var(--cta-gap) - 20px);
}

@media (min-width: 1100px) {
    .gallery-scroller {
        gap: 28px;
    }
}

@keyframes infiniteScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.tooltip-container {
    position: relative;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 16px;
    border: 1px solid rgba(212, 175, 55, 0.18);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
}

.tooltip-container:hover,
.tooltip-container.is-open {
    z-index: 100;
}

.project-default {
    opacity: 1;
    transition: opacity 0.25s ease, transform 0.35s ease;
}

.tooltip-container:hover .project-default {
    opacity: 0;
    transform: scale(0.95);
    pointer-events: none;
}

.tooltip-popup {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 400px;
    min-height: 380px;
    padding: 24px;
    background: #ffffff;
    color: #1e1e1a;
    border-radius: 20px;
    border: 1.5px solid rgba(212, 175, 55, 0.4);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    text-align: left;
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    overflow: auto;
    transform: translate(-50%, -50%) scale(0.85);
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.tooltip-container:hover .tooltip-popup,
.tooltip-container.is-open .tooltip-popup {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translate(-50%, -50%) scale(1);
}

.tooltip-container.is-open .project-default {
    opacity: 0;
    transform: scale(0.95);
    pointer-events: none;
}

.project-popup-content {
    height: 100%;
    min-height: 0;
}

.project-popup-content > div:first-child {
    min-height: 0;
    overflow: auto;
}

.tooltip-popup a {
    position: relative;
    z-index: 2;
}

.popup-image {
    width: 100%;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    padding: 12px;
    overflow: hidden;
    border-radius: 12px;
    background: #ffffff;
    border: 1px solid rgba(212, 175, 55, 0.2);
}

.popup-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.tooltip-popup p::-webkit-scrollbar {
    width: 4px;
}

.tooltip-popup p::-webkit-scrollbar-thumb {
    background: rgba(212, 175, 55, 0.5);
    border-radius: 4px;
}

#projects .tooltip-popup {
    width: min(460px, calc(100vw - 32px));
    min-height: 430px;
    max-height: min(520px, calc(100vh - 32px));
    padding: 24px;
    color: #1e1e1a;
    background: rgba(255, 255, 255, 0.56);
    border-color: rgba(255, 255, 255, 0.78);
    border-radius: 16px;
    box-shadow: 0 22px 48px rgba(31, 38, 48, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.72);
    -webkit-backdrop-filter: blur(28px) saturate(155%);
    backdrop-filter: blur(28px) saturate(155%);
    overflow: auto;
}

#projects .initiatives-viewport:has(.initiative-card:first-child:hover),
#projects .initiatives-viewport:has(.initiative-card:first-child.is-open) {
    -webkit-mask-image: linear-gradient(to right, #000 0%, #000 97%, transparent);
    mask-image: linear-gradient(to right, #000 0%, #000 97%, transparent);
}

#projects .initiative-card:first-child .tooltip-popup {
    left: 0;
    transform: translate(0, -50%) scale(0.85);
}

#projects .initiative-card:first-child:hover .tooltip-popup,
#projects .initiative-card:first-child.is-open .tooltip-popup {
    transform: translate(0, -50%) scale(1);
}

#projects .initiative-card {
    border: 0;
    background: transparent;
    box-shadow: none;
    -webkit-backdrop-filter: none;
    backdrop-filter: none;
}

#projects .initiative-card-surface {
    border-color: rgba(255, 255, 255, 0.68);
    background: rgba(255, 255, 255, 0.48);
    background: color-mix(in srgb, var(--initiative-bg, #ffffff) 20%, rgba(255, 255, 255, 0.4));
    -webkit-backdrop-filter: blur(20px) saturate(145%);
    backdrop-filter: blur(20px) saturate(145%);
}

#projects .project-popup-content {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

#projects .popup-image {
    flex: 0 0 126px;
    width: 126px;
    height: 126px;
    align-self: center;
    margin: 0 0 4px;
    padding: 8px;
    background: rgba(255, 255, 255, 0.22);
    border-color: rgba(255, 255, 255, 0.65);
    border-radius: 50%;
    -webkit-backdrop-filter: blur(12px);
    backdrop-filter: blur(12px);
}

#projects .popup-image img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: contain;
}

#projects .project-popup-content p {
    max-height: 190px;
    line-height: 1.65;
}

@media (max-width: 767px) {
    .initiatives-viewport {
        padding-block: var(--heading-gap) 32px;
    }

    #projects .tooltip-popup {
        min-height: 390px;
        padding: 20px;
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Video Modal Styles */
#videoModal {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

#videoModal .relative {
    animation: scaleIn 0.3s ease;
}

@keyframes scaleIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
    .carousel-track {
        animation: none;
    }
    #videoModal {
        animation: none;
    }
    #videoModal .relative {
        animation: none;
    }
}
</style>

<script>
function playVideo(element, researchId) {
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');
    if (!modal || !container) return;
    
    // Get video data from server
    fetch(`/research/${researchId}/video`)
        .then(response => response.json())
        .then(data => {
            if (data.video_file) {
                // Play uploaded video
                container.innerHTML = `
                    <video controls autoplay class="w-full h-full">
                        <source src="${data.video_file}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                `;
            } else if (data.video_embed_url) {
                // Play embedded video
                container.innerHTML = `
                    <iframe src="${data.video_embed_url}" class="w-full h-full" allowfullscreen></iframe>
                `;
            } else {
                container.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center text-white">
                        <p>No video available</p>
                    </div>
                `;
            }
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error loading video:', error);
            container.innerHTML = `
                <div class="w-full h-full flex items-center justify-center text-white">
                    <p>Error loading video. Please try again.</p>
                </div>
            `;
            modal.classList.remove('hidden');
        });
}

function closeVideoModal(event) {
    if (event && event.target !== event.currentTarget) return;
    const modal = document.getElementById('videoModal');
    const container = document.getElementById('videoContainer');
    if (!modal || !container) return;
    modal.classList.add('hidden');
    container.innerHTML = '';
    document.body.style.overflow = 'auto';
}

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal({ target: document.getElementById('videoModal') });
    }
});

// Counter animation for stats: counts up once the stats scroll into view.
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;

    const duration = 1800;
    const easeOutExpo = (t) => (t >= 1 ? 1 : 1 - Math.pow(2, -10 * t));

    const run = (counter) => {
        const raw = counter.getAttribute('data-target') || '0';
        const target = parseFloat(raw) || 0;
        const decimals = (raw.split('.')[1] || '').length;
        const start = performance.now();
        const tick = (now) => {
            const progress = easeOutExpo(Math.min((now - start) / duration, 1));
            counter.textContent = (target * progress).toFixed(decimals);
            if (progress < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    };

    // Keep the real value in server-rendered HTML, then animate in the browser.
    counters.forEach((counter) => { counter.textContent = '0'; });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            observer.unobserve(entry.target);
            run(entry.target);
        });
    }, { threshold: 0.6 });

    counters.forEach((counter) => observer.observe(counter));
});
</script>

<script>
/* Projects-only pointer carousel: supports mouse dragging and touch swipes. */
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('#projects .carousel-container');
    const track = carousel?.querySelector('.carousel-track');

    if (!carousel || !track || track.children.length < 2) return;

    track.classList.add('carousel-drag-ready');

    let maxPosition = 0;
    let position = 0;
    let lastFrame = 0;
    let pointerId = null;
    let startX = 0;
    let startPosition = 0;
    let dragged = false;
    let suppressClick = false;
    let paused = false;
    let direction = 1;
    const autoSpeed = 18; // slower drift to match the Figma motion cadence more closely

    const measure = () => {
        maxPosition = Math.max(0, track.scrollWidth - carousel.clientWidth);
        position = Math.min(Math.max(position, 0), maxPosition);
    };

    const render = () => {
        track.style.transform = `translate3d(${-position}px, 0, 0)`;
    };

    const animate = (timestamp) => {
        if (!lastFrame) lastFrame = timestamp;
        const elapsed = Math.min(timestamp - lastFrame, 50);
        lastFrame = timestamp;

        if (pointerId === null && !paused && maxPosition) {
            position += direction * (elapsed / 1000) * autoSpeed;
            if (position >= maxPosition) {
                position = maxPosition;
                direction = -1;
            } else if (position <= 0) {
                position = 0;
                direction = 1;
            }
            render();
        }

        requestAnimationFrame(animate);
    };

    const finishDrag = () => {
        if (pointerId === null) return;

        const activePointerId = pointerId;
        pointerId = null;
        track.releasePointerCapture?.(activePointerId);
        track.classList.remove('is-dragging');

        if (dragged) {
            suppressClick = true;
            track.classList.add('is-settling');
            window.setTimeout(() => track.classList.remove('is-settling'), 190);
            window.setTimeout(() => { suppressClick = false; }, 0);
        }

        lastFrame = performance.now();
    };

    const isProjectLink = (event) => Boolean(event.target.closest('a, button'));

    carousel.addEventListener('pointerenter', () => { paused = true; });
    carousel.addEventListener('pointerleave', () => { paused = false; });

    track.querySelectorAll('.tooltip-container').forEach((card) => {
        card.addEventListener('mouseenter', () => card.classList.add('is-open'));
        card.addEventListener('mouseleave', () => card.classList.remove('is-open'));
    });

    track.addEventListener('pointerdown', (event) => {
        if (event.pointerType === 'mouse' && event.button !== 0) return;
        if (isProjectLink(event)) return;

        measure();
        pointerId = event.pointerId;
        startX = event.clientX;
        startPosition = position;
        dragged = false;
        track.classList.add('is-dragging');
        track.setPointerCapture?.(pointerId);
    });

    track.addEventListener('pointermove', (event) => {
        if (event.pointerId !== pointerId) return;

        const delta = event.clientX - startX;
        if (Math.abs(delta) > 5) dragged = true;
        if (!dragged) return;

        position = Math.min(Math.max(startPosition - delta, 0), maxPosition);
        render();
        event.preventDefault();
    });

    track.addEventListener('pointerup', finishDrag);
    track.addEventListener('pointercancel', finishDrag);
    track.addEventListener('lostpointercapture', finishDrag);

    track.addEventListener('click', (event) => {
        if (isProjectLink(event)) return;
        if (suppressClick) {
            event.preventDefault();
            event.stopPropagation();
        }
    }, true);

    window.addEventListener('resize', () => {
        measure();
        render();
    });

    measure();
    render();
    requestAnimationFrame(animate);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const scroller = document.querySelector('#gallery .gallery-scroller');
    if (!scroller) return;

    let pointerId = null;
    let startX = 0;
    let startScroll = 0;
    let dragged = false;
    let suppressClick = false;
    const dragThreshold = 10;

    const canScroll = () => scroller.scrollWidth > scroller.clientWidth + 4;

    const beginDrag = function (event) {
        if (dragged) return;
        dragged = true;
        scroller.classList.add('is-dragging');
        try {
            scroller.setPointerCapture(event.pointerId);
        } catch (error) {}
    };

    scroller.addEventListener('pointerdown', function (event) {
        if (event.pointerType !== 'mouse' || event.button !== 0) return;

        pointerId = event.pointerId;
        startX = event.clientX;
        startScroll = scroller.scrollLeft;
        dragged = false;
        suppressClick = false;
    });

    scroller.addEventListener('pointermove', function (event) {
        if (event.pointerId !== pointerId) return;

        const delta = event.clientX - startX;
        if (!dragged && Math.abs(delta) <= dragThreshold) return;

        beginDrag(event);
        scroller.scrollLeft = startScroll - delta;
        event.preventDefault();
    });

    const finishDrag = function (event) {
        if (pointerId === null) return;
        if (event && event.pointerId !== undefined && event.pointerId !== pointerId) return;

        const activePointerId = pointerId;
        const didDrag = dragged;
        pointerId = null;
        scroller.classList.remove('is-dragging');

        try {
            scroller.releasePointerCapture(activePointerId);
        } catch (error) {}

        if (didDrag) {
            suppressClick = true;
            window.setTimeout(function () {
                suppressClick = false;
            }, 300);
        }

        dragged = false;
    };

    scroller.addEventListener('pointerup', finishDrag);
    scroller.addEventListener('pointercancel', finishDrag);
    scroller.addEventListener('lostpointercapture', finishDrag);

    scroller.addEventListener('click', function (event) {
        if (!event.target.closest('.gallery-card')) return;
        if (!suppressClick) return;
        event.preventDefault();
        event.stopPropagation();
    }, true);

    scroller.addEventListener('dragstart', function (event) {
        event.preventDefault();
    });

    scroller.addEventListener('wheel', function (event) {
        if (!canScroll()) return;
        if (Math.abs(event.deltaY) <= Math.abs(event.deltaX)) return;
        scroller.scrollLeft += event.deltaY;
        event.preventDefault();
    }, { passive: false });
});
</script>
