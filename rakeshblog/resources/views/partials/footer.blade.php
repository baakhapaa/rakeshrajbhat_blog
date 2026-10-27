<footer class="py-12 md:py-16 bg-[#0c1016] text-white/90">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 items-start gap-10 text-left md:grid-cols-12 md:gap-8">
            <div class="md:col-span-4">
                <p class="font-serif italic text-3xl text-[#D4AF37] notranslate" translate="no">Rakesh Rajbhat</p>
                <p class="mt-4 text-sm text-gray-300 leading-relaxed">
                    For the root. For the youth. For the nation.
                </p>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    Founder of Baakhapaa, Skill Sikka, HillyChilly and Future Builders. Transforming education, tourism, technology, and local economies in Nepal.
                </p>
                <p class="mt-6 text-[11px] font-semibold tracking-[0.12em] text-gray-500">
                    © {{ date('Y') }} RAKESH RAJBHAT. ALL RIGHTS RESERVED.
                </p>
            </div>

            <div class="md:col-span-2">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Socials</h3>
                <div class="mt-3 flex flex-col items-start gap-2">
                    <a href="https://www.linkedin.com/in/raacb/" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold tracking-[0.06em] text-gray-400 hover:text-[#D4AF37] transition-colors">LinkedIn</a>
                    <a href="https://www.facebook.com/raacb/" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold tracking-[0.06em] text-gray-400 hover:text-[#D4AF37] transition-colors">Facebook</a>
                    <a href="https://www.instagram.com/raa_case7/" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold tracking-[0.06em] text-gray-400 hover:text-[#D4AF37] transition-colors">Instagram</a>
                </div>
            </div>

            <div class="md:col-span-2">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pages</h3>
                <div class="mt-3 flex flex-col items-start gap-2">
                    <a href="{{ route('contact') }}" class="text-xs font-semibold tracking-[0.06em] text-gray-400 hover:text-[#D4AF37] transition-colors">Contact</a>
                    <a href="{{ route('privacy') }}" class="text-xs font-semibold tracking-[0.06em] text-gray-400 hover:text-[#D4AF37] transition-colors">Privacy</a>
                    <a href="{{ route('terms') }}" class="text-xs font-semibold tracking-[0.06em] text-gray-400 hover:text-[#D4AF37] transition-colors">Terms</a>
                </div>
            </div>

            <section class="w-full rounded-xl border border-[#3a414b] bg-[#151a20] p-4 md:col-span-4" aria-labelledby="newsletter-heading" data-newsletter-card>
                <div class="flex flex-col gap-3">
                    <div class="text-center">
                        <h2 id="newsletter-heading" class="text-xs font-semibold uppercase tracking-wider text-gray-400">Newsletter</h2>
                        <p class="mt-1 text-xs text-gray-400">Get an email when a new article, research piece, or project is published.</p>
                    </div>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="w-full">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-2">
                            <label for="newsletter-email" class="sr-only">Email address</label>
                            <input id="newsletter-email" name="email" type="email" required autocomplete="email"
                                value="{{ old('email') }}" placeholder="you@example.com"
                                class="flex-1 rounded-md border border-[#3a414b] bg-[#0c1016] px-3 py-2 text-xs text-white placeholder-gray-500 focus:border-[#D4AF37] focus:outline-none focus:ring-1 focus:ring-[#D4AF37]">
                            <button type="submit" class="rounded-md bg-[#D4AF37] px-4 py-2 text-xs font-bold text-[#0b0e12] hover:bg-[#c4a030] whitespace-nowrap">
                                Subscribe
                            </button>
                        </div>
                        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="absolute -left-[9999px]">
                        <label for="newsletter-consent" class="mt-2 flex items-start gap-2 text-left text-[10px] md:text-[11px] text-gray-400">
                            <input id="newsletter-consent" type="checkbox" name="consent" value="1" required class="mt-0.5 accent-[#D4AF37] shrink-0">
                            <span>I agree to receive emails. <a href="{{ route('privacy') }}" class="text-[#D4AF37] underline">Privacy Policy</a>.</span>
                        </label>
                        @error('email') <p class="mt-1 text-[11px] text-red-300">{{ $message }}</p> @enderror
                        @error('consent') <p class="mt-1 text-[11px] text-red-300">{{ $message }}</p> @enderror
                    </form>
                    @if(session('newsletter_success'))
                        <p class="mt-2 rounded-md bg-green-900/30 px-3 py-2 text-xs text-green-300" role="status">{{ session('newsletter_success') }}</p>
                    @endif
                    @if(session('newsletter_error'))
                        <p class="mt-2 rounded-md bg-red-900/30 px-3 py-2 text-xs text-red-300" role="alert">{{ session('newsletter_error') }}</p>
                    @endif
                </div>
            </section>
        </div>
    </div>
</footer>
