@extends('layouts.app')

@section('title', 'News & Updates · Rakesh Rajbhat')

@section('meta_description', $newsContent['intro'])

@section('content')
<section class="py-20 md:py-28 bg-gradient-to-b from-[#f8f6f1] to-[#f2efe8]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-3 uppercase">{{ $newsContent['label'] }}</p>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold text-[#1e1e1a] leading-tight">{{ $newsContent['heading'] }}</h1>
            <p class="text-[#5a5a52] mt-4 text-lg leading-relaxed max-w-2xl mx-auto">{{ $newsContent['intro'] }}</p>
        </div>

        @if($newsItems->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($newsItems as $item)
                    @include('partials.news-card', ['item' => $item])
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 rounded-full bg-white/80 flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <i class="fas fa-newspaper text-4xl text-[#D4AF37]/30"></i>
                </div>
                <p class="text-lg font-medium text-[#1e1e1a]">No news yet</p>
                <p class="text-sm text-[#8a8a82] mt-1">Stories will appear here as they are added.</p>
            </div>
        @endif

        <div class="text-center mt-16">
            <a href="{{ route('home') }}#news" class="inline-flex items-center gap-2 text-[#8a8a82] hover:text-[#D4AF37] transition font-medium">
                <i class="fas fa-arrow-left text-xs"></i>
                Back to Home
            </a>
        </div>
    </div>
</section>

@include('partials.news-modal')
@endsection
