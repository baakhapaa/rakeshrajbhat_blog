@php
    $footer = \App\Models\Setting::getFooter();
    $footerTagline = preg_replace('/\.\s+/', '.    ', $footer['tagline']);
@endphp
<footer class="site-footer">
    <style>
        .site-footer {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            color: #111111;
            padding: 56px 0 28px;
        }
        .site-footer .hero-cubes {
            position: absolute;
            pointer-events: none;
            z-index: 0;
            background-image: url("{{ asset('images/hero/hero-cubes.jpg') }}");
            background-repeat: repeat-y;
            opacity: 0.1;
            filter: contrast(1.5) brightness(1.25);
        }
        .site-footer .hero-cubes-a {
            inset: 0;
            background-size: 5239px 11342px;
            background-position: -1467px 0;
            animation: heroCubesA 180s linear infinite;
        }
        .site-footer .hero-cubes-b {
            inset: 0;
            width: auto;
            height: auto;
            left: 0;
            top: 0;
            background-size: 2298px 5802px;
            background-position: 0 -2292px;
            animation: heroCubesB 95s linear infinite;
        }
        .site-footer__inner {
            position: relative;
            z-index: 1;
            width: min(1440px, calc(100% - 120px));
            margin: 0 auto;
        }
        .site-footer__top {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto minmax(320px, 500px);
            column-gap: clamp(40px, 4vw, 72px);
            row-gap: 36px;
            align-items: start;
        }
        .site-footer__name {
            margin: 0;
            color: #955443;
            font-family: Poppins, "Plus Jakarta Sans", sans-serif;
            font-size: clamp(34px, 3.2vw, 52px);
            font-weight: 600;
            line-height: 1.05;
        }
        .site-footer__logo {
            display: block;
            height: 52px;
            width: auto;
            object-fit: contain;
        }
        .site-footer__pill {
            display: inline-block;
            margin: 22px 0 0;
            padding: 8px 22px;
            border-radius: 43px;
            background: rgba(217, 217, 217, 0.2);
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
            box-shadow:
                inset 1.5px 1.5px 1px rgba(255, 255, 255, 0.85),
                inset -1px -1px 1px rgba(255, 255, 255, 0.45),
                0 6px 20px -8px rgba(0, 0, 0, 0.12);
            color: #111111;
            font-family: Poppins, "Plus Jakarta Sans", sans-serif;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.45;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .site-footer__intro {
            max-width: 460px;
            margin: 22px 0 0;
            color: #151515;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 15px;
            font-weight: 400;
            line-height: 1.65;
        }
        .site-footer__links {
            display: flex;
            justify-self: end;
            gap: clamp(36px, 4vw, 72px);
            padding-top: 0;
        }
        .site-footer__col h2 {
            margin: 0 0 12px;
            color: #111111;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .site-footer__col a {
            display: block;
            padding: 5px 0;
            color: #111111;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.3;
            text-decoration: none;
        }
        .site-footer__col a:hover { color: #955443; }
        .site-footer__card {
            background: rgba(255, 255, 255, 0.28);
            border-radius: 15px;
            padding: 28px 36px 20px;
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
            box-shadow:
                inset 1.5px 1.5px 1px rgba(255, 255, 255, 0.85),
                inset -1px -1px 1px rgba(255, 255, 255, 0.45),
                0 6px 20px -8px rgba(0, 0, 0, 0.12);
        }
        .site-footer__card h2 {
            margin: 0;
            color: #111111;
            font-family: Poppins, "Plus Jakarta Sans", sans-serif;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.3;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .site-footer__note {
            margin: 8px 0 0;
            color: #242424;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.5;
        }
        .site-footer__row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 16px;
        }
        .site-footer__row input[type="email"] {
            flex: 1;
            min-width: 0;
            height: 42px;
            border: 0;
            border-radius: 8px;
            background: rgba(11, 15, 20, 0.06);
            padding: 0 12px;
            color: #111111;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 15px;
        }
        .site-footer__row input[type="email"]::placeholder { color: #4b4b4b; }
        .site-footer__row input[type="email"]:focus {
            outline: 1px solid #b36855;
        }
        .site-footer__row button {
            height: 40px;
            padding: 0 22px;
            border: 0;
            border-radius: 9999px;
            background: #b36855;
            color: #faf7f2;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 15px;
            font-weight: 700;
            line-height: 21px;
            cursor: pointer;
            flex: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12), 0 2px 4px -2px rgba(0, 0, 0, 0.43);
        }
        .site-footer__row button:hover { background: #a35b49; }
        .site-footer__consent {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 12px;
            color: #363636;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.4;
        }
        .site-footer__consent input {
            appearance: none;
            width: 20px;
            height: 18px;
            margin: 1px 0 0;
            border: 1px solid #85898c;
            border-radius: 2px;
            background: #ffffff;
            flex: none;
            cursor: pointer;
        }
        .site-footer__consent input:checked {
            background: #b36855;
            border-color: #b36855;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 8.2 6.4 11l6.1-6.4' fill='none' stroke='%23ffffff' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 14px 14px;
        }
        .site-footer__consent a {
            color: #b36855;
            font-weight: 600;
            text-decoration: none;
        }
        .site-footer__consent a:hover { text-decoration: underline; }
        .site-footer__trap {
            position: absolute;
            left: -9999px;
        }
        .site-footer__msg {
            margin: 10px 0 0;
            border-radius: 8px;
            padding: 8px 10px;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 13px;
            line-height: 1.4;
        }
        .site-footer__msg--ok { background: #e8f6ec; color: #1c6b34; }
        .site-footer__msg--bad { background: #fdecec; color: #9b2c2c; }
        .site-footer__bottom { margin-top: 36px; text-align: center; }
        .site-footer__rule {
            height: 1px;
            margin: 0 0 16px;
            border: 0;
            background: #000000;
            opacity: 0.25;
        }
        .site-footer__copy {
            margin: 0;
            color: #111111;
            font-family: "Plus Jakarta Sans", Inter, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 21px;
        }
        @media (min-width: 981px) {
            .site-footer__links { padding-top: 58px; }
        }
        @media (max-width: 1023px) {
            .site-footer .hero-cubes-a {
                background-repeat: repeat;
                background-size: 780px 1688px;
                background-position: 50% 0;
                animation-name: heroCubesM;
                animation-duration: 60s;
            }
            .site-footer .hero-cubes-b { display: none; }
        }
        @media (max-width: 980px) {
            .site-footer { padding: 40px 0 24px; }
            .site-footer__inner { width: min(1440px, calc(100% - 40px)); }
            .site-footer__links { justify-self: start; }
            .site-footer__top { grid-template-columns: 1fr; gap: 28px; }
            .site-footer__links { padding-top: 0; gap: 28px; }
        }
        @media (max-width: 640px) {
            .site-footer__links { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
            .site-footer__row { flex-direction: column; align-items: stretch; }
            .site-footer__row button { height: 42px; }
        }
        @keyframes heroCubesA { to { background-position: -1467px 11342px; } }
        @keyframes heroCubesB { to { background-position: 0 3510px; } }
        @keyframes heroCubesM { to { background-position: 50% 1688px; } }
        @media (prefers-reduced-motion: reduce) {
            .site-footer .hero-cubes { animation: none; }
        }
    </style>
    <div class="hero-cubes hero-cubes-a" aria-hidden="true"></div>
    <div class="hero-cubes hero-cubes-b" aria-hidden="true"></div>
    <div class="site-footer__inner">
        <div class="site-footer__top">
            <div>
                @if($footer['logo'])
                    <img class="site-footer__logo" src="{{ $footer['logo'] }}" alt="{{ $footer['name'] }}">
                @else
                    <p class="site-footer__name notranslate" translate="no">{{ $footer['name'] }}</p>
                @endif
                @if($footer['tagline'] !== '')
                    <p class="site-footer__pill">{{ $footerTagline }}</p>
                @endif
                @if($footer['intro'] !== '')
                    <p class="site-footer__intro">{{ $footer['intro'] }}</p>
                @endif
            </div>

            <div class="site-footer__links">
                <div class="site-footer__col">
                    <h2>{{ $footer['socials_heading'] }}</h2>
                    @foreach($footer['socials'] as $item)
                        <a href="{{ \App\Models\Setting::navHref($item['url']) }}" @if(str_starts_with($item['url'], 'http')) target="_blank" rel="noopener noreferrer" @endif>{{ $item['label'] }}</a>
                    @endforeach
                </div>
                <div class="site-footer__col">
                    <h2>{{ $footer['pages_heading'] }}</h2>
                    @foreach($footer['pages'] as $item)
                        <a href="{{ \App\Models\Setting::navHref($item['url']) }}" @if(str_starts_with($item['url'], 'http')) target="_blank" rel="noopener noreferrer" @endif>{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>

            <section class="site-footer__card" aria-labelledby="newsletter-heading">
                <h2 id="newsletter-heading">{{ $footer['newsletter_heading'] }}</h2>
                <p class="site-footer__note">{{ $footer['newsletter_note'] }}</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="site-footer__row">
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input id="newsletter-email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}" placeholder="you@example.com">
                        <button type="submit">Subscribe</button>
                    </div>
                    <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="site-footer__trap">
                    <div class="site-footer__consent">
                        <input id="newsletter-consent" type="checkbox" name="consent" value="1" required>
                        <span><label for="newsletter-consent">I agree to receive emails.</label> <a href="{{ route('privacy') }}">privacy policy</a>.</span>
                    </div>
                    @error('email') <p class="site-footer__msg site-footer__msg--bad">{{ $message }}</p> @enderror
                    @error('consent') <p class="site-footer__msg site-footer__msg--bad">{{ $message }}</p> @enderror
                </form>
                @if(session('newsletter_success'))
                    <p class="site-footer__msg site-footer__msg--ok" role="status">{{ session('newsletter_success') }}</p>
                @endif
                @if(session('newsletter_error'))
                    <p class="site-footer__msg site-footer__msg--bad" role="alert">{{ session('newsletter_error') }}</p>
                @endif
            </section>
        </div>
        <div class="site-footer__bottom">
            <hr class="site-footer__rule">
            <p class="site-footer__copy">{{ $footer['copyright_text'] }}</p>
        </div>
    </div>
</footer>
