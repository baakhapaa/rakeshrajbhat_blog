@extends('layouts.app')

@section('title', 'Terms of Use | Rakesh Rajbhat')
@section('meta_description', 'Terms governing the use of the Rakesh Rajbhat website and its public content and services.')

@section('content')
<section class="min-h-screen bg-[#f8f6f0] pt-32 pb-20 text-[#1e1e1a]">
    <article class="max-w-3xl mx-auto px-5 sm:px-6 lg:px-8">
        <p class="text-[#735A12] font-bold text-xs tracking-widest uppercase mb-3">Legal</p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">Terms of Use</h1>
        <p class="text-sm text-[#4a4a42] mb-10">Last updated: September 4, 2026</p>

        <div class="space-y-8 text-[#3a3a34] leading-7">
            <p>These Terms of Use govern your use of the Rakesh Rajbhat website. By using this website, you agree to these terms.</p>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Website content</h2><p>Unless otherwise stated, the website’s text, design, graphics and original media are protected by applicable intellectual-property laws. You may share links to public pages, but may not reproduce, republish or commercially use material without prior permission.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Acceptable use</h2><p>You must not misuse the website, interfere with its security or operation, submit unlawful or harmful content, impersonate another person, attempt unauthorized access or use automated methods that place unreasonable load on the service.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Inquiries and accounts</h2><p>Submitting a form does not create a contract, partnership, employment relationship or obligation to provide services. Where accounts, comments, quizzes or connected learning features are available, users are responsible for providing accurate information and keeping account credentials secure.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">External links</h2><p>This website may link to third-party websites. Those sites are governed by their own terms and privacy practices, and we are not responsible for their content or availability.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Disclaimer and changes</h2><p>Website content is provided for general information and may change without notice. We may update these terms or suspend features when necessary. Continued use after an update means you accept the updated terms.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Contact</h2><p>For questions about these terms, please use the <a href="{{ route('contact') }}" class="text-[#735A12] underline">Contact page</a>.</p></section>
        </div>
    </article>
</section>
@endsection
