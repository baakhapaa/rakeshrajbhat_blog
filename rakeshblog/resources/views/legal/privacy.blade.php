@extends('layouts.app')

@section('title', 'Privacy Policy | Rakesh Rajbhat')
@section('meta_description', 'Learn how Rakesh Rajbhat’s website collects, uses and protects information submitted through the website.')

@section('content')
<section class="min-h-screen bg-[#f8f6f0] pt-32 pb-20 text-[#1e1e1a]">
    <article class="max-w-3xl mx-auto px-5 sm:px-6 lg:px-8">
        <p class="text-[#735A12] font-bold text-xs tracking-widest uppercase mb-3">Legal</p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">Privacy Policy</h1>
        <p class="text-sm text-[#4a4a42] mb-10">Last updated: September 4, 2026</p>

        <div class="space-y-8 text-[#3a3a34] leading-7">
            <p>This policy explains how the Rakesh Rajbhat website handles personal information submitted through its contact, bootcamp, partnership and account-related features.</p>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Information we collect</h2><p>We may collect the information you provide, such as your name, email address, phone number, organization, location and message. If you create an account or use connected features, we may also process the information needed to provide those features.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">How we use information</h2><p>Information is used to respond to inquiries, assess program or partnership requests, operate requested website features, protect the website from misuse and meet applicable legal obligations. We do not sell personal information.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Sharing and service providers</h2><p>Information may be shared only with people who need it to respond to your request or operate the website, and with service providers that support hosting, email delivery, security or form processing. They may use it only to provide those services.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Retention and security</h2><p>We retain information only for as long as reasonably necessary for the purpose it was collected, legal requirements and record keeping. Reasonable technical and organizational safeguards are used, but no online system can guarantee absolute security.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Your choices</h2><p>You may request access to, correction of or deletion of personal information held about you, subject to legal and operational requirements. To make a request or ask a privacy question, use the <a href="{{ route('contact') }}" class="text-[#735A12] underline">Contact page</a>.</p></section>
            <section><h2 class="text-2xl font-serif font-bold text-[#1e1e1a] mb-3">Changes to this policy</h2><p>We may update this policy as the website or its services change. The current version and its update date will always appear on this page.</p></section>
        </div>
    </article>
</section>
@endsection
