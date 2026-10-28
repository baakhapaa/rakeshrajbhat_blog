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
                height: 1119px;
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
                opacity: 0.06;
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
                height: 1119px;
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
            .hero-lead {
                left: 415px;
                top: 233px;
                width: 539px;
                margin: 0;
                font-family: Poppins, "Plus Jakarta Sans", sans-serif;
                font-size: 38px;
                font-weight: 500;
                line-height: 92px;
                letter-spacing: -1.26px;
                color: #111111;
                white-space: nowrap;
            }
            .hero-title {
                left: 419px;
                top: 314px;
                margin: 0;
                font-family: Poppins, "Plus Jakarta Sans", sans-serif;
                font-size: 81px;
                font-weight: 600;
                line-height: 81px;
                letter-spacing: -1.26px;
                color: #111111;
                white-space: nowrap;
            }
            .hero-title span { display: block; }
            .hero-body {
                left: 418px;
                top: 512px;
                margin: 0;
                font-size: 21px;
                font-weight: 400;
                line-height: 36px;
                letter-spacing: 2px;
                color: #59554f;
                white-space: nowrap;
            }
            .hero-body span { display: block; }
            .hero-body .hero-body-lead { font-weight: 500; }
            .hero-body strong { font-weight: 700; }
            .hero-body .hero-body-note { font-style: italic; color: #46433f; }
            .hero-body.is-plain { width: 900px; white-space: normal; }
            .hero-actions {
                left: 419px;
                top: 628px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }
            .hero-btn {
                height: 53px;
                border-radius: 9999px;
                display: inline-flex;
                align-items: center;
                font-size: 14px;
                line-height: 21px;
                text-decoration: none;
                white-space: nowrap;
            }
            .hero-btn-primary {
                background: #b36855;
                color: #faf7f2;
                font-weight: 700;
                padding: 10px 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12), 0 2px 4px -2px rgba(0, 0, 0, 0.43);
            }
            .hero-btn-primary:hover { filter: brightness(1.05); }
            .hero-btn-primary img { margin-left: 8px; }
            .hero-btn-secondary {
                color: #000000;
                font-weight: 500;
                padding: 11px 21px;
                border: 1px solid #d5cec2;
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
            .hero-pill {
                left: 368px;
                top: 941px;
                width: 563px;
                height: 54px;
                border-radius: 52px;
                background: rgba(217, 217, 217, 0.2);
            }
            .hero-tag {
                left: 402px;
                top: 951px;
                width: 515px;
                margin: 0;
                font-family: Poppins, "Plus Jakarta Sans", sans-serif;
                font-size: 18px;
                font-weight: 500;
                line-height: 31px;
                letter-spacing: 1px;
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
                    padding: 40px 20px 0;
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
                #heroCanvas > .hero-pill,
                #heroCanvas > .hero-warm { display: none; }
                #heroCanvas > .hero-lead {
                    order: 1;
                    font-size: 20px;
                    line-height: 1.35;
                    letter-spacing: -0.4px;
                    white-space: normal;
                }
                #heroCanvas > .hero-title {
                    order: 2;
                    margin-top: 8px;
                    font-size: clamp(34px, 8.6vw, 56px);
                    line-height: 1.08;
                    letter-spacing: -0.8px;
                    white-space: normal;
                }
                #heroCanvas > .hero-body {
                    order: 3;
                    margin-top: 18px;
                    max-width: 640px;
                    font-size: 15px;
                    line-height: 1.7;
                    letter-spacing: 0.5px;
                    white-space: normal;
                }
                #heroCanvas > .hero-body .hero-body-note { margin-top: 4px; }
                #heroCanvas > .hero-actions {
                    order: 4;
                    margin-top: 24px;
                    flex-wrap: wrap;
                    gap: 10px;
                }
                #heroCanvas > .hero-actions .hero-btn { height: 48px; }
                #heroCanvas > .hero-actions .hero-btn-primary { padding: 10px 20px; }
                #heroCanvas > .hero-actions .hero-btn-secondary { padding: 11px 18px; }
                #heroCanvas > .hero-tag {
                    order: 5;
                    margin-top: 28px;
                    padding: 11px 20px;
                    border-radius: 52px;
                    background: rgba(217, 217, 217, 0.2);
                    -webkit-backdrop-filter: blur(4px);
                    backdrop-filter: blur(4px);
                    box-shadow:
                        inset 1.5px 1.5px 1px rgba(255, 255, 255, 0.85),
                        inset -1px -1px 1px rgba(255, 255, 255, 0.45),
                        0 6px 20px -8px rgba(0, 0, 0, 0.12);
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
                    width: calc(100% + 40px);
                    max-width: 760px;
                    height: auto;
                    aspect-ratio: 1154.061 / 930.639;
                    margin: 28px -20px 0;
                    transform: none;
                }
            }
            @media (prefers-reduced-motion: reduce) {
                .hero-cubes,
                .hero-badge { animation: none; }
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
        <div id="heroFit" class="hero-fit">
            <div id="heroCanvas" class="hero-canvas">
                <div class="hero-cubes hero-cubes-a" aria-hidden="true"></div>
                <div class="hero-cubes hero-cubes-b" aria-hidden="true"></div>
                <div class="hero-warm" aria-hidden="true"></div>
                <img class="hero-glow" src="{{ asset('images/hero/figma/ellipse9.svg') }}" alt="" width="1769" height="1692">
                <div class="hero-portrait">
                    <img src="{{ asset('images/hero/hero-portrait.png') }}" alt="{{ $homeContent['name'] }}">
                </div>
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
                @if($heroLead !== '')
                    <p class="hero-lead">{{ $heroLead }}</p>
                @endif
                <div class="hero-badge hero-badge-baakhapaa" aria-hidden="true"><span><img src="{{ asset('images/hero/figma/badge-baakhapaa.png') }}" alt="" width="545" height="545"></span></div>
                <div class="hero-badge hero-badge-hillychilly" aria-hidden="true"><span><img src="{{ asset('images/hero/figma/badge-hillychilly.png') }}" alt="" width="545" height="545"></span></div>
                <div class="hero-badge hero-badge-skillsikka" aria-hidden="true"><span><img src="{{ asset('images/hero/figma/badge-skillsikka.png') }}" alt="" width="547" height="547"></span></div>
                <img class="hero-arc hero-arc-1" src="{{ asset('images/hero/figma/arc-1.svg') }}" alt="" width="608.976" height="720.521">
                <img class="hero-arc hero-arc-2" src="{{ asset('images/hero/figma/arc-2.svg') }}" alt="" width="410.827" height="549.7">
                <div class="hero-arc hero-arc-3" aria-hidden="true"><img src="{{ asset('images/hero/figma/arc-3.svg') }}" alt="" width="843.457" height="321.101"></div>
                <img class="hero-haze hero-haze-a" src="{{ asset('images/hero/figma/ellipse8.svg') }}" alt="" width="1281" height="1281">
                @if($heroTagline !== '')
                    <div class="hero-pill hero-glass" aria-hidden="true"></div>
                    <p class="hero-tag">{{ $heroTagline }}</p>
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
                if (!stage || !fit || !canvas) return;
                var stacked = window.matchMedia('(max-width: 1023px)');
                function applyHeroScale() {
                    if (stacked.matches) {
                        canvas.style.transform = '';
                        fit.style.height = '';
                        stage.style.paddingTop = Math.round(header ? header.getBoundingClientRect().height : 0) + 'px';
                        return;
                    }
                    var scale = fit.clientWidth / 2305;
                    canvas.style.transform = 'scale(' + scale + ')';
                    fit.style.height = Math.round(1119 * scale) + 'px';
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
    <section id="about-me" class="scroll-mt-20 border-b border-[#efeeeb] bg-[#fbf9f6] text-[#1b1c1a]">
        <div class="mx-auto w-full max-w-[1920px] px-6 pb-16 pt-20 sm:px-10 md:pb-24 md:pt-28 lg:px-16 lg:pb-[113px] lg:pt-[160px] xl:px-24 2xl:px-[196px]">
            <div class="grid items-end gap-12 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)] lg:gap-x-16">
                <div class="lg:pt-[39px]">
                    <div class="flex items-center gap-2">
                        <span class="block h-0.5 w-6 shrink-0 bg-[#89351d]" aria-hidden="true"></span>
                        <p class="font-grotesk text-sm font-bold uppercase leading-4 tracking-[1.1px] text-[#89351d]">{{ $aboutContent['label'] }}</p>
                    </div>
                    <h2 class="pt-3 font-jakarta text-[2rem] font-bold leading-tight tracking-[-0.6px] text-[#1b1c1a] sm:text-[44px] sm:leading-[48px] sm:tracking-[-1.1px]">
                        {{ $aboutContent['heading_line_1'] }}@if(filled($aboutContent['heading_line_2'])) {{ $aboutContent['heading_line_2'] }}@endif
                    </h2>
                    @if(!empty($aboutContent['media_url']))
                        <div class="mt-8 max-w-[840px]">
                            @if(($aboutContent['media_type'] ?? null) === 'video')
                                <video src="{{ $aboutContent['media_url'] }}" controls playsinline preload="metadata" class="w-full rounded-2xl bg-[#1e1e1a]"></video>
                            @else
                                <img src="{{ $aboutContent['media_url'] }}" alt="" class="w-full rounded-2xl object-cover">
                            @endif
                        </div>
                    @endif
                    <div class="flex max-w-[840px] flex-col gap-10 pt-10 lg:gap-[50px] lg:pt-[51px]">
                        <div class="rounded-2xl border-l-4 border-[#89351d] bg-[#f5f3f0] py-6 pl-7 pr-6">
                            <p class="font-jakarta text-[1.35rem] font-bold leading-8 text-[#1b1c1a] sm:text-[31px] sm:leading-[40px]">{{ $aboutContent['paragraph_1'] }}</p>
                        </div>
                        @if(filled($aboutContent['paragraph_2']))
                            <p class="font-jakarta text-[17px] font-bold leading-9 text-[#5f5e5e]">{{ $aboutContent['paragraph_2'] }}</p>
                        @endif
                        @if(filled($aboutContent['paragraph_3']))
                            <p class="font-jakarta text-lg font-normal leading-[1.35] text-[#5f5e5e]">{{ $aboutContent['paragraph_3'] }}</p>
                        @endif
                    </div>
                    @if(filled($aboutContent['button_label']))
                        <div class="pt-12 lg:pt-20">
                            <a href="{{ \App\Models\Setting::linkHref($aboutContent['button_url'] ?: '#projects') }}" @if(str_starts_with((string) $aboutContent['button_url'], 'http')) target="_blank" rel="noopener noreferrer" @endif class="inline-flex items-center rounded-full bg-[#b36855] px-6 py-2.5 font-jakarta text-sm font-medium leading-[21px] text-[#faf7f2] shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.12),0px_2px_4px_-2px_rgba(0,0,0,0.43)] transition hover:brightness-110">
                                <span>{{ $aboutContent['button_label'] }}</span>
                                <span class="inline-flex pl-2">
                                    <img src="{{ asset('images/about-arrow.svg') }}" alt="" width="9.46875" height="3.75">
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="w-full self-end overflow-hidden">
                    <img
                        src="{{ asset('images/rakeshrajbhat.jpg') }}"
                        alt="{{ $homeContent['name'] ?? 'Rakesh Rajbhat' }}"
                        class="aspect-[4/5] h-auto w-full object-cover lg:aspect-[5/6] 2xl:aspect-auto 2xl:h-[738px]"
                    >
                </div>
            </div>
        </div>
    </section>

    <!-- About/Mission Section -->
    @php
        $missionItems = [
            ['number' => '01', 'title' => 'Education', 'body' => 'Making learning practical, accessible and future-ready.'],
            ['number' => '02', 'title' => 'Youth Empowerment', 'body' => 'Equipping young minds with skills, confidence and purpose.'],
            ['number' => '03', 'title' => 'Technology', 'body' => 'Using technology to solve real problems in communities.'],
            ['number' => '04', 'title' => 'Local Economy', 'body' => 'Creating opportunities that strengthen local communities.'],
            ['number' => '05', 'title' => 'Sustainability', 'body' => 'Building projects that respect nature and culture.'],
            ['number' => '06', 'title' => 'Nation First', 'body' => 'Every step I take is for Nepal and her future.'],
        ];
    @endphp
    <section id="about" class="mission-scroll text-[#1e1e1a] scroll-mt-20" aria-labelledby="mission-heading">
        <div class="mission-scroll__list">
            <p class="mission-scroll__kicker">My Mission</p>
            @foreach($missionItems as $item)
                <div class="mission-scroll__listItem">
                    <div class="mission-scroll__listNum">{{ $item['number'] }}</div>
                    <h3 class="mission-scroll__listTitle">{{ $item['title'] }}</h3>
                    <p class="mission-scroll__listBody">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mission-scroll__track" id="missionTrack">
            <div class="mission-scroll__sticky" id="missionSticky">
                <div class="mission-scroll__dialZone" aria-hidden="true">
                    <div class="mission-scroll__dialBaseOuter"></div>
                    <div class="mission-scroll__dialBaseInner"></div>
                    <div class="mission-scroll__dialBaseCenter"></div>
                    <div class="mission-scroll__dialCanvas" id="missionDial">
                        @foreach($missionItems as $item)
                            <div class="mission-scroll__marker">
                                <div class="mission-scroll__markerContent">
                                    <span class="mission-scroll__markerNum">{{ $item['number'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mission-scroll__textZone">
                    <p id="mission-heading" class="mission-scroll__kicker">My Mission</p>
                    <div class="mission-scroll__textViewport" id="missionText">
                        @foreach($missionItems as $item)
                            <article class="mission-scroll__reason">
                                <h3 class="mission-scroll__headline">{{ $item['title'] }}</h3>
                                <p class="mission-scroll__body">{{ $item['body'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            margin: 0 0 12px;
            color: #D4AF37;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }
        .mission-scroll__list { display: none; max-width: 40rem; margin: 0 auto; padding: 72px 24px 80px; }
        .mission-scroll__listItem + .mission-scroll__listItem { margin-top: 28px; padding-top: 28px; border-top: 1px solid rgba(30, 30, 26, 0.08); }
        .mission-scroll__listNum { color: #D4AF37; font-size: 12px; font-weight: 700; letter-spacing: 0.14em; }
        .mission-scroll__listTitle { margin: 8px 0 0; font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; }
        .mission-scroll__listBody { margin: 8px 0 0; color: #5a5a52; font-size: 15px; line-height: 1.6; }
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
            width: 40%;
            height: 100%;
            pointer-events: none;
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, #000 12%, #000 88%, transparent 100%);
            mask-image: linear-gradient(to bottom, transparent 0%, #000 12%, #000 88%, transparent 100%);
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
            transform: rotate(var(--angle)) translateX(calc(var(--dial-size) * 0.4375 + var(--number-margin)));
        }
        .mission-scroll__markerContent {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }
        .mission-scroll__markerNum {
            display: inline-block;
            font-family: 'Playfair Display', serif;
            font-size: 72px;
            font-weight: 700;
            letter-spacing: -0.03em;
            transform-origin: left center;
            will-change: transform, color, opacity;
        }
        .mission-scroll__textZone {
            position: absolute;
            left: 38%;
            width: 54%;
            top: 50%;
            transform: translateY(-28px);
            z-index: 2;
        }
        .mission-scroll__textViewport { position: relative; height: 190px; width: 100%; overflow: hidden; }
        .mission-scroll__reason {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            opacity: 0;
            will-change: transform, opacity;
        }
        .mission-scroll__headline {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 3.4vw, 56px);
            font-weight: 700;
            line-height: 1.1;
            color: #1e1e1a;
            will-change: transform;
        }
        .mission-scroll__body {
            margin: 16px 0 0;
            max-width: 36rem;
            color: #5a5a52;
            font-size: 18px;
            line-height: 1.6;
            will-change: transform;
        }
        @media (max-width: 1100px) {
            .mission-scroll__textZone { left: 42%; width: 52%; }
        }
        @media (max-width: 768px) {
            .mission-scroll {
                --dial-size: min(72vw, 320px);
                --dial-center: -0.16;
                --number-margin: 8px;
            }
            .mission-scroll__sticky {
                top: 5rem;
                height: calc(100svh - 5rem);
            }
            .mission-scroll__dialZone { width: 42%; }
            .mission-scroll__markerNum { font-size: 32px; }
            .mission-scroll__textZone {
                left: 40%;
                width: 56%;
                padding-right: 20px;
            }
            .mission-scroll__textViewport { height: 160px; }
            .mission-scroll__headline { font-size: 28px; }
            .mission-scroll__body { margin-top: 10px; font-size: 15px; line-height: 1.5; }
        }
        @media (prefers-reduced-motion: reduce) {
            .mission-scroll__track { display: none !important; height: auto !important; }
            .mission-scroll__list { display: block !important; }
        }
    </style>
    <script>
        (function () {
            const section = document.getElementById('about');
            const track = document.getElementById('missionTrack');
            const sticky = document.getElementById('missionSticky');
            const canvas = document.getElementById('missionDial');
            const viewport = document.getElementById('missionText');
            if (!section || !track || !sticky || !canvas || !viewport) return;

            const CONFIG = { angleStep: 28, exitY: 135, stiffness: 85, damping: 26, mass: 0.3, headlineYOffset: 45, bodyYOffset: 25, scrollPadding: 0 };
            function applyMotionScale() {
                const narrow = window.innerWidth <= 768;
                CONFIG.exitY = narrow ? 64 : 135;
                CONFIG.headlineYOffset = narrow ? 20 : 45;
                CONFIG.bodyYOffset = narrow ? 12 : 25;
            }
            const COLOR_FADED = 'rgba(30, 30, 26, 0.18)';
            const COLOR_ACTIVE = '#D4AF37';
            const markers = Array.from(canvas.querySelectorAll('.mission-scroll__marker'));
            const nums = Array.from(canvas.querySelectorAll('.mission-scroll__markerNum'));
            const articles = Array.from(viewport.querySelectorAll('.mission-scroll__reason'));
            const headlines = Array.from(viewport.querySelectorAll('.mission-scroll__headline'));
            const bodies = Array.from(viewport.querySelectorAll('.mission-scroll__body'));
            const total = articles.length;
            if (total < 2) return;

            markers.forEach(function (marker, index) {
                marker.style.setProperty('--angle', (index * CONFIG.angleStep) + 'deg');
            });

            const clamp = function (value, min, max) { return Math.min(Math.max(value, min), max); };
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
                if (str[0] === '#') {
                    const hex = str.slice(1);
                    return [parseInt(hex.slice(0, 2), 16), parseInt(hex.slice(2, 4), 16), parseInt(hex.slice(4, 6), 16), 1];
                }
                const parts = str.match(/rgba?\(([^)]+)\)/)[1].split(',').map(Number);
                return [parts[0], parts[1], parts[2], parts[3] === undefined ? 1 : parts[3]];
            }
            function lerpColor(a, b, t) {
                const A = parseColor(a);
                const B = parseColor(b);
                const ch = function (i) { return Math.sqrt(A[i] * A[i] + (B[i] * B[i] - A[i] * A[i]) * t); };
                const alpha = A[3] + (B[3] - A[3]) * t;
                return 'rgba(' + Math.round(ch(0)) + ', ' + Math.round(ch(1)) + ', ' + Math.round(ch(2)) + ', ' + alpha.toFixed(4) + ')';
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
                canvas.style.transform = 'rotate(' + interpolate(progress, [pad, 1 - pad], [0, -(total - 1) * CONFIG.angleStep]) + 'deg)';

                for (let i = 0; i < total; i++) {
                    const s = pad + (i / (total - 1)) * (1 - 2 * pad);
                    const scale = interpolate(progress, [s - step * 0.8, s, s + step * 0.8], [0.5, 1, 0.5]);
                    const opacity = interpolate(progress, [s - step * 0.9, s, s + step * 0.9], [0.3, 1, 0.3]);
                    const cRange = [s - step * 0.6, s, s + step * 0.6];
                    let color = COLOR_FADED;
                    if (progress > cRange[0] && progress < cRange[2]) {
                        color = progress < cRange[1]
                            ? lerpColor(COLOR_FADED, COLOR_ACTIVE, (progress - cRange[0]) / (cRange[1] - cRange[0]))
                            : lerpColor(COLOR_ACTIVE, COLOR_FADED, (progress - cRange[1]) / (cRange[2] - cRange[1]));
                    }
                    nums[i].style.transform = 'scale(' + scale.toFixed(4) + ')';
                    nums[i].style.opacity = opacity.toFixed(4);
                    nums[i].style.color = color;

                    const y = interpolate(progress, [s - step * 0.8, s, s + step * 0.8], [CONFIG.exitY, 0, -CONFIG.exitY]);
                    const cardOpacity = interpolate(progress, [s - step * 0.6, s - step * 0.2, s + step * 0.2, s + step * 0.6], [0, 1, 1, 0]);
                    articles[i].style.transform = 'translate3d(0, ' + y.toFixed(2) + 'px, 0)';
                    articles[i].style.opacity = cardOpacity.toFixed(4);
                    articles[i].style.visibility = cardOpacity < 0.002 ? 'hidden' : 'visible';
                    headlines[i].style.transform = 'translate3d(0, ' + interpolate(progress, [s - step * 0.6, s, s + step * 0.6], [CONFIG.headlineYOffset, 0, -CONFIG.headlineYOffset]).toFixed(2) + 'px, 0)';
                    bodies[i].style.transform = 'translate3d(0, ' + interpolate(progress, [s - step * 0.5, s, s + step * 0.5], [CONFIG.bodyYOffset, 0, -CONFIG.bodyYOffset]).toFixed(2) + 'px, 0)';
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

            window.addEventListener('resize', layout);
            layout();
            render();
            requestAnimationFrame(frame);
        })();
    </script>

    <!-- Projects Section -->
    <section id="projects" class="py-28 bg-[#fff6e0] scroll-mt-20 overflow-visible">
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 mb-8">
            <div class="flex justify-between items-end">
                <div>
                    @php
                        $projectsSection = \App\Models\Setting::getProjectsSection();
                    @endphp
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-2 uppercase">{{ $projectsSection['label'] }}</p>
                    <h2 class="text-4xl font-serif font-bold text-[#1e1e1a]">{{ $projectsSection['title'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Infinite Carousel Outer Container -->
        <div class="carousel-container relative w-full py-16">
            <!-- Scrolling Track -->
            <div class="carousel-track flex items-center gap-8 w-max">

                {{-- FIRST SET --}}
                @forelse($projects ?? [] as $project)
                    <div class="tooltip-container w-[300px] shrink-0 bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all">
                        <!-- Normal Card Content -->
                        <div class="project-default w-full flex flex-col items-center">
                            <div class="project-image w-20 h-20 rounded-full flex items-center justify-center mb-5 overflow-hidden border-2 border-[#D4AF37]/20 bg-white">
                                @if($project->image)
                                    <img src="{{ $project->image_url }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background-color: {{ $project->color ?? '#D4AF37' }}20;">
                                        <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                    </div>
                                @endif
                            </div>
                            <h4 class="font-bold text-[#1e1e1a] mb-2 text-lg"> {{ $project->name }} </h4>
                            <p class="text-xs text-gray-600 mb-4 flex-grow line-clamp-2"> {{ $project->short_description ?? 'Hover to learn more' }} </p>
                            <span class="text-[#D4AF37] text-xs font-bold flex items-center gap-1"> Learn More →</span>
                        </div>

                        <!-- Popup Content -->
                        <div class="tooltip-popup">
                            <div class="project-popup-content flex flex-col justify-between h-full">
                                <div>
                                    <div class="popup-image">
                                        @if($project->image)
                                            <img src="{{ $project->image_url }}" alt="{{ $project->name }}">
                                        @else
                                            <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                        @endif
                                    </div>
                                    <h5 class="font-bold text-xl text-[#1e1e1a] mb-2"> {{ $project->name }} </h5>

                                    <p class="text-sm text-gray-700 leading-relaxed max-h-[140px] overflow-y-auto pr-1">
                                        {{ $project->description ?? $project->long_description ?? $project->short_description }}
                                    </p>
                                </div>

                                @if($project->url)
                                    <div class="pt-4 mt-2 border-t border-gray-100">
                                        <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] font-semibold text-sm hover:underline">
                                            Visit Website <span>→</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No projects available yet.</p>
                @endforelse

                {{-- Only one project set is rendered so the homepage DOM remains unique. --}}
                @if(false)
                @foreach($projects ?? [] as $project)
                    <div class="tooltip-container w-[300px] shrink-0 bg-white/80 p-8 text-center rounded-xl shadow-gold-sm flex flex-col items-center border border-[#D4AF37]/15 hover:border-[#D4AF37] hover:bg-white transition-all">
                        <!-- Normal Card Content -->
                        <div class="project-default w-full flex flex-col items-center">
                            <div class="project-image w-20 h-20 rounded-full flex items-center justify-center mb-5 overflow-hidden border-2 border-[#D4AF37]/20 bg-white">
                                @if($project->image)
                                    <img src="{{ $project->image_url }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background-color: {{ $project->color ?? '#D4AF37' }}20;">
                                        <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                    </div>
                                @endif
                            </div>
                            <h4 class="font-bold text-[#1e1e1a] mb-2 text-lg"> {{ $project->name }} </h4>
                            <p class="text-xs text-gray-600 mb-4 flex-grow line-clamp-2"> {{ $project->short_description ?? 'Hover to learn more' }} </p>
                            <span class="text-[#D4AF37] text-xs font-bold flex items-center gap-1"> Learn More →</span>
                        </div>

                        <!-- Popup Content -->
                        <div class="tooltip-popup">
                            <div class="project-popup-content flex flex-col justify-between h-full">
                                <div>
                                    <div class="popup-image">
                                        @if($project->image)
                                            <img src="{{ $project->image_url }}" alt="{{ $project->name }}">
                                        @else
                                            <span style="color: {{ $project->color ?? '#D4AF37' }};" class="text-3xl font-bold">📦</span>
                                        @endif
                                    </div>
                                    <h5 class="font-bold text-xl text-[#1e1e1a] mb-2"> {{ $project->name }} </h5>

                                    <p class="text-sm text-gray-700 leading-relaxed max-h-[140px] overflow-y-auto pr-1">
                                        {{ $project->description ?? $project->long_description ?? $project->short_description }}
                                    </p>
                                </div>

                                @if($project->url)
                                    <div class="pt-4 mt-2 border-t border-gray-100">
                                        <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] font-semibold text-sm hover:underline">
                                            Visit Website <span>→</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Impact Stats -->
    <section id="impact" class="scroll-mt-20 bg-[#010a19] py-16">
        <div class="mx-auto flex w-full max-w-[1640px] flex-col items-center gap-10 px-4 sm:px-6 lg:flex-row lg:items-center lg:gap-8 xl:px-8">
            <div class="w-full shrink-0 lg:w-[250px]">
                <div class="flex items-center gap-2">
                    <span class="block h-0.5 w-6 shrink-0 bg-[#b36855]" aria-hidden="true"></span>
                    @php $statsSection = \App\Models\Setting::getStatsSection(); @endphp
                    <p class="font-grotesk text-sm font-bold uppercase leading-4 tracking-[1.1px] text-[#b36855]">{{ $statsSection['title'] }}</p>
                </div>
                <h2 class="mt-3 font-poppins text-[2.4rem] font-bold leading-[1.2] tracking-[-1px] text-white sm:text-[50px] sm:leading-[62px] sm:tracking-[-1.15px]">
                    {{ $statsSection['description'] }}
                </h2>
            </div>
            <div class="w-full min-w-0 flex-1 overflow-hidden rounded-2xl border border-[#1e2530] bg-[#12161e] shadow-[0px_25px_50px_-12px_rgba(0,0,0,0.25)]">
                <div class="grid grid-cols-2 gap-px bg-[#1c232d] md:grid-cols-3 xl:grid-cols-6">
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
                        <div class="flex min-h-[220px] flex-col items-center justify-between bg-[#12161e] px-4 py-10 text-center">
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

    <!-- Research Section -->
<section id="research" class="py-24 bg-gradient-to-b from-[#f2efe8] to-[#faf8f5] text-[#1e1e1a] scroll-mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Section Title -->
        @php
            $researchSection = \App\Models\Setting::getResearchSection();
        @endphp
        <div class="text-center mb-10">
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#1e1e1a] leading-tight">{{ $researchSection['title'] }}</h2>
            <p class="text-[#5a5a52] mt-4 max-w-2xl mx-auto text-lg leading-relaxed">{{ $researchSection['paragraph'] }}</p>
        </div>

        <div class="mb-12 flex flex-wrap items-center justify-center gap-3" id="researchFilters">
            <button type="button" data-research-filter="all" class="research-pill inline-flex items-center gap-2 rounded-full bg-[#D4AF37] px-4 py-2 text-sm font-semibold text-[#1e1e1a] shadow-sm transition" aria-pressed="true">
                <i class="fa-solid fa-table-cells text-[#1e1e1a]" aria-hidden="true"></i>
                All
            </button>
            <button type="button" data-research-filter="vision" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-eye text-[#D4AF37]" aria-hidden="true"></i>
                Vision
            </button>
            <button type="button" data-research-filter="research" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-file-lines text-[#D4AF37]" aria-hidden="true"></i>
                Research
            </button>
            <button type="button" data-research-filter="media" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-video text-[#D4AF37]" aria-hidden="true"></i>
                Media
            </button>
            <button type="button" data-research-filter="blog" class="research-pill inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#4a4a42] shadow-sm transition" aria-pressed="false">
                <i class="fa-solid fa-newspaper text-[#D4AF37]" aria-hidden="true"></i>
                Blog
            </button>
        </div>

        @php
            $categories = [
                'vision' => [
                    'label' => 'Vision for Nepal',
                    'icon' => 'fa-eye',
                    'emoji' => '🌟',
                    'description' => 'Big ideas for a better tomorrow',
                ],
                'research' => [
                    'label' => 'Research & Papers',
                    'icon' => 'fa-book',
                    'emoji' => '📚',
                    'description' => 'Evidence-based insights',
                ],
                'media' => [
                    'label' => 'Media & Stories',
                    'icon' => 'fa-video',
                    'emoji' => '🎬',
                    'description' => 'Inspiring stories from the field',
                ],
                'blog' => [
                    'label' => 'Blog',
                    'icon' => 'fa-newspaper',
                    'emoji' => '📰',
                    'description' => 'Three featured stories',
                ],
            ];
            $homeBlogs = isset($featuredBlogs) ? $featuredBlogs->take(3) : collect();
            $spotlightResearch = $spotlightResearch ?? collect();
        @endphp

        <div data-research-panel="all" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach(['vision', 'research'] as $key)
                @php $category = $categories[$key]; @endphp
                <div class="space-y-5">
                    @include('partials.home-study-heading', ['category' => $category])
                    @if(isset($spotlightResearch[$key]) && $spotlightResearch[$key]->isNotEmpty())
                        @include('partials.home-research-card', ['item' => $spotlightResearch[$key]->first(), 'category' => $category])
                    @else
                        <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                            <p class="text-sm text-[#5a5a52] font-medium">No featured item yet</p>
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="space-y-5">
                @include('partials.home-study-heading', ['category' => $categories['blog']])
                @if($homeBlogs->isNotEmpty())
                    @include('partials.home-blog-card', ['blog' => $homeBlogs->first()])
                @else
                    <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                        <p class="text-sm text-[#5a5a52] font-medium">No featured blogs yet</p>
                    </div>
                @endif
            </div>
        </div>

        @foreach(['vision', 'research', 'media'] as $key)
            @php $category = $categories[$key]; @endphp
            <div data-research-panel="{{ $key }}" class="hidden">
                <div class="mb-5">
                    @include('partials.home-study-heading', ['category' => $category])
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @if(isset($featuredResearch[$key]) && $featuredResearch[$key]->isNotEmpty())
                        @foreach($featuredResearch[$key]->take(3) as $item)
                            @include('partials.home-research-card', ['item' => $item, 'category' => $category])
                        @endforeach
                    @else
                        <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                            <p class="text-sm text-[#5a5a52] font-medium">Nothing added to home yet</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div data-research-panel="blog" class="hidden">
            <div class="mb-5">
                @include('partials.home-study-heading', ['category' => $categories['blog']])
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @forelse($homeBlogs as $blog)
                    @include('partials.home-blog-card', ['blog' => $blog])
                @empty
                    <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100/50">
                        <p class="text-sm text-[#5a5a52] font-medium">No featured blogs yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-16">
            <a href="{{ route('research.featured') }}"
                class="inline-flex items-center gap-3 px-8 py-3.5 bg-gradient-to-r from-[#D4AF37] to-[#c4a030] text-[#0b0e12] font-medium rounded-2xl hover:shadow-xl hover:shadow-[#D4AF37]/25 transition-all duration-300 hover:-translate-y-0.5 group">
                    <span>Explore All Research</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
            <p class="text-xs text-[#8a8a82] mt-3">Discover insights, stories, and ideas that inspire change</p>
        </div>
    </div>
    <script>
        document.querySelectorAll('[data-research-filter]').forEach(function (button) {
            button.addEventListener('click', function () {
                const filter = button.getAttribute('data-research-filter');
                document.querySelectorAll('[data-research-filter]').forEach(function (item) {
                    const active = item === button;
                    item.classList.toggle('bg-[#D4AF37]', active);
                    item.classList.toggle('text-[#1e1e1a]', active);
                    item.classList.toggle('bg-white', !active);
                    item.classList.toggle('text-[#4a4a42]', !active);
                    item.setAttribute('aria-pressed', active ? 'true' : 'false');
                    const icon = item.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('text-[#1e1e1a]', active);
                        icon.classList.toggle('text-[#D4AF37]', !active);
                    }
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
        <div class="relative bg-white rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button onclick="closeResearchDetail()" class="sticky top-4 right-4 float-right z-10 text-gray-400 hover:text-[#D4AF37] bg-white/95 backdrop-blur-sm rounded-full p-2.5 shadow-lg transition-all duration-300 hover:scale-110 ml-4 border border-gray-100">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Content -->
            <div class="px-8 pb-8 pt-4" id="researchDetailContent">
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

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeVideoModal()"></div>
    <div class="relative max-w-4xl w-full bg-black rounded-2xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
        <button onclick="closeVideoModal()" class="absolute top-4 right-4 z-10 text-white hover:text-[#D4AF37] bg-black/50 rounded-full p-2 transition-all duration-300 hover:scale-110">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div id="videoContainer" class="aspect-video">
            <!-- Video will be loaded here -->
        </div>
    </div>
</div>

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
                const categoryIcons = {
                    'Vision': 'fa-eye',
                    'Research Papers': 'fa-book',
                    'Media': 'fa-video'
                };
                const categoryColors = {
                    'Vision': 'bg-amber-50 text-amber-700 border-amber-200',
                    'Research Papers': 'bg-blue-50 text-blue-700 border-blue-200',
                    'Media': 'bg-purple-50 text-purple-700 border-purple-200'
                };
                const categoryEmojis = {
                    'Vision': '🌟',
                    'Research Papers': '📚',
                    'Media': '🎬'
                };

                const escapeHtml = (str) => {
                    if (!str) return '';
                    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                };

                const formatResearchContent = (value) => {
                    if (!value) return '';
                    if (!/<\/?[a-z][\s\S]*>/i.test(value)) {
                        return `<div class="text-[#3a3a34] leading-relaxed whitespace-pre-wrap">${escapeHtml(value)}</div>`;
                    }
                    return `<div class="text-[#3a3a34] leading-relaxed [&_h2]:mb-2 [&_h2]:font-serif [&_h2]:text-2xl [&_h2]:font-bold [&_h3]:mb-2 [&_h3]:text-xl [&_h3]:font-bold [&_p]:mb-3 [&_strong]:font-bold [&_ul]:mb-3 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:mb-3 [&_ol]:list-decimal [&_ol]:pl-5">${value}</div>`;
                };

                content.innerHTML = `
                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 border
                            ${categoryColors[item.category] || 'bg-gray-50 text-gray-700 border-gray-200'}">
                            <span>${categoryEmojis[item.category] || '📄'}</span>
                            ${escapeHtml(item.category)}
                        </span>
                        ${item.is_featured ? '<span class="px-3 py-1.5 bg-[#D4AF37]/10 text-[#D4AF37] text-xs font-semibold rounded-full flex items-center gap-1 border border-[#D4AF37]/20"><i class="fas fa-star text-[10px]"></i> Featured</span>' : ''}
                        ${item.created_at ? `<span class="text-xs text-[#8a8a82] flex items-center gap-1"><i class="far fa-calendar-alt"></i> ${new Date(item.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</span>` : ''}
                    </div>

                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#1e1e1a] mb-4 leading-tight">${escapeHtml(item.title)}</h2>

                    ${item.image_url ? `
                        <div class="mb-6 rounded-2xl overflow-hidden shadow-md">
                            <img src="${item.image_url}" alt="${escapeHtml(item.title)}" class="w-full max-h-96 object-cover">
                        </div>
                    ` : ''}

                    ${item.video_url || item.video_file ? `
                        <div class="mb-6 rounded-2xl overflow-hidden bg-black shadow-md">
                            ${item.video_file ?
                                `<video controls class="w-full h-full"><source src="${item.video_file}" type="video/mp4">Your browser does not support the video tag.</video>` :
                                item.video_embed_url ?
                                `<iframe src="${item.video_embed_url}" class="w-full h-full aspect-video" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>` :
                                `<div class="w-full h-full aspect-video flex items-center justify-center text-white"><p>No video available</p></div>`
                            }
                        </div>
                    ` : ''}

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-[#8a8a82] uppercase tracking-wider mb-2 flex items-center gap-2">
                            <span class="w-6 h-0.5 bg-[#D4AF37]"></span>
                            About
                        </h4>
                        <p class="text-[#3a3a34] leading-relaxed text-base">${escapeHtml(item.description)}</p>
                    </div>

                    ${item.content ? `
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-[#8a8a82] uppercase tracking-wider mb-2 flex items-center gap-2">
                                <span class="w-6 h-0.5 bg-[#D4AF37]"></span>
                                Full Story
                            </h4>
                            ${formatResearchContent(item.content)}
                        </div>
                    ` : ''}

                    ${item.link_url ? `
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <a href="${item.link_url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#D4AF37] hover:text-[#c4a030] transition font-medium">
                                <i class="fas fa-external-link-alt"></i>
                                Visit Link
                            </a>
                        </div>
                    ` : ''}
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

    <section id="news" class="scroll-mt-20 bg-[#fbf9f6] pb-16 pt-16 text-[#1b1c1a] lg:pb-28 lg:pt-24">
        @php
            $newsContent = \App\Models\Setting::getNewsContent();
            $newsItems = $newsItems ?? collect();
        @endphp
        <div class="mx-auto w-full max-w-[1648px] px-6 lg:px-12">
            <div class="max-w-xl">
                <div class="flex items-center gap-2">
                    <span class="block h-0.5 w-6 shrink-0 bg-[#89351d]" aria-hidden="true"></span>
                    <p class="font-grotesk text-sm font-bold uppercase leading-4 tracking-[1.1px] text-[#89351d]">{{ $newsContent['label'] }}</p>
                </div>
                <h2 class="pt-1 font-jakarta text-[2rem] font-bold leading-tight tracking-[-0.6px] text-[#1b1c1a] sm:text-[40px] sm:leading-[48px] sm:tracking-[-1px]">{{ $newsContent['heading'] }}</h2>
                <p class="max-w-xl pt-2 font-jakarta text-base leading-6 text-[#5f5e5e]">{{ $newsContent['intro'] }}</p>
            </div>

            @if($newsItems->isNotEmpty())
                <div class="mt-12 grid grid-cols-1 items-stretch gap-8 md:grid-cols-2 lg:grid-cols-3 lg:gap-[46px]">
                    @foreach($newsItems as $item)
                        @include('partials.news-card', ['item' => $item])
                    @endforeach
                </div>
                <div class="mt-12 flex justify-center">
                    <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 rounded-full px-8 py-3.5 font-grotesk text-base font-semibold leading-[18px] tracking-[1.04px] text-[#89351d]">
                        <span>View All Updates</span>
                        <img src="{{ asset('images/news-all-arrow.svg') }}" alt="" width="15" height="10.5">
                    </a>
                </div>
            @else
                <p class="mt-12 text-center font-jakarta text-sm text-[#5f5e5e]">News will appear here once a link is added.</p>
            @endif
        </div>
    </section>

    @include('partials.news-modal')

    <section id="gallery" class="gallery-section py-24 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            @php
                $gallerySection = \App\Models\Setting::getGallerySection();
            @endphp
            <div class="gallery-head">
                <div>
                    <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-3 uppercase">{{ $gallerySection['label'] }}</p>
                    <h2 class="gallery-title font-serif font-bold text-[#1e1e1a] leading-tight">{{ $gallerySection['title'] }}</h2>
                </div>
                <p class="gallery-intro text-[#5a5a52] leading-relaxed">
                    {{ $gallerySection['paragraph'] }}
                </p>
            </div>

            @if($galleryCollections->isNotEmpty())
                <div class="gallery-scroller" tabindex="0" aria-label="Photo collections">
                    @foreach($galleryCollections as $collection)
                        @php
                            $previewImages = $collection->images->take(4);
                            $lead = $previewImages->first();
                            $sideImages = $previewImages->slice(1, 3);
                        @endphp
                        <a href="{{ route('gallery.show', $collection) }}" class="gallery-card {{ $sideImages->isEmpty() ? 'gallery-card-single' : '' }}" aria-label="View {{ $collection->title }}">
                            <div class="gallery-card-lead">
                                <img src="{{ $lead->url }}" alt="{{ $collection->title }}" draggable="false">
                                <span class="gallery-card-count">{{ $collection->images->count() }} {{ \Illuminate\Support\Str::plural('photograph', $collection->images->count()) }}</span>
                                <div class="gallery-card-lead-copy">
                                    <span class="gallery-card-date">{{ $collection->created_at->format('M Y') }}</span>
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
                <p class="mt-4 text-xs text-[#8a8a82]">Drag or scroll sideways to move through the collections. Click on a collection to see every photograph.</p>
            @else
                <p class="text-sm text-[#8a8a82]">{{ $gallerySection['empty'] }}</p>
            @endif
        </div>
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
@endsection

<style>
#projects {
    overflow: hidden !important;
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
    background: #f7f4ee;
    color: #1e1e1a;
}

.gallery-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 2rem;
    margin-bottom: 2.5rem;
}

.gallery-head > div {
    flex: 1 0 auto;
}

.gallery-title {
    font-size: clamp(2rem, 3.1vw, 3.15rem);
}

.gallery-intro {
    flex: 0 1 280px;
    max-width: 280px;
    text-align: right;
}

@media (max-width: 760px) {
    .gallery-head {
        flex-direction: column;
        align-items: flex-start;
    }

    .gallery-intro {
        flex-basis: auto;
        max-width: 28rem;
        text-align: left;
    }
}

.gallery-scroller {
    display: flex;
    gap: 1.25rem;
    overflow-x: auto;
    padding-bottom: 1.35rem;
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
    scroll-snap-align: start;
    flex: 0 0 auto;
    display: flex;
    width: min(82vw, 460px);
    height: 320px;
    border-radius: 0.75rem;
    overflow: hidden;
    border: 1px solid rgba(30, 30, 26, 0.08);
    box-shadow: 0 1px 2px rgba(30, 30, 26, 0.06);
    background: #e7e1d6;
    text-decoration: none;
    color: inherit;
    cursor: grab;
    -webkit-user-drag: none;
    user-select: none;
}

.gallery-card:hover {
    box-shadow: 0 10px 24px rgba(30, 30, 26, 0.12);
}

.gallery-card-single .gallery-card-lead {
    width: 100%;
}

.gallery-card-lead {
    position: relative;
    flex: 1 1 auto;
    min-width: 0;
}

.gallery-card-lead img,
.gallery-card-thumb img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
}

.gallery-card-lead::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(30, 30, 26, 0.58), rgba(30, 30, 26, 0.05) 46%, transparent);
}

.gallery-card-count,
.gallery-card-lead-copy {
    position: absolute;
    z-index: 1;
}

.gallery-card-count {
    top: 1rem;
    left: 1rem;
    padding: 0.3rem 0.7rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.86);
    color: #735A12;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.gallery-card-lead-copy {
    left: 0;
    right: 0;
    bottom: 0;
    padding: 1.25rem;
}

.gallery-card-date {
    margin: 0 0 0.3rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.04em;
}

.gallery-card-lead-copy h3 {
    color: #fff;
    font-family: "Playfair Display", serif;
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1.15;
}

.gallery-card-side {
    display: flex;
    flex-direction: column;
    flex: 0 0 124px;
    width: 124px;
    overflow: hidden;
}

.gallery-card-thumb {
    position: relative;
    flex: 1 1 0;
    min-height: 0;
    border-left: 1px solid rgba(255, 255, 255, 0.7);
}

.gallery-card-thumb + .gallery-card-thumb {
    border-top: 1px solid rgba(255, 255, 255, 0.7);
}

.gallery-scroller::-webkit-scrollbar {
    display: none;
}

@media (max-width: 640px) {
    .gallery-card {
        height: 280px;
    }

    .gallery-card-side {
        flex-basis: 104px;
        width: 104px;
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

// Counter animation for stats
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const updateCounter = () => {
            const target = parseInt(counter.getAttribute('data-target'));
            const current = parseInt(counter.innerText);
            const increment = Math.ceil(target / speed);

            if (current < target) {
                counter.innerText = Math.min(current + increment, target);
                setTimeout(updateCounter, 1);
            } else {
                counter.innerText = target;
            }
        };

        // Keep the real value in server-rendered HTML, then animate in the browser.
        counter.innerText = '0';
        updateCounter();
    });
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
    const autoSpeed = 30; // pixels per second, matching the existing 30s carousel rhythm

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
