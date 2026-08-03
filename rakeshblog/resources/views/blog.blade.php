@extends('layouts.app')

@section('title', 'Blog · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-[#D4AF37] font-bold text-xs tracking-widest mb-4 uppercase">Latest Articles</p>
            <h1 class="text-5xl font-serif font-bold mb-6">Blog &amp; Insights</h1>
            <p class="text-[#3a3a34] max-w-2xl mx-auto">Thoughts, stories and ideas from my journey in building opportunities for Nepal.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Blog Post 1 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-[#D4AF37]/20 to-[#D4AF37]/5 flex items-center justify-center">
                    <span class="text-6xl">📚</span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span>January 15, 2024</span>
                        <span>•</span>
                        <span class="text-[#D4AF37] font-semibold">Education</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 hover:text-[#D4AF37] transition-colors">
                        <a href="#">The Future of Education in Nepal</a>
                    </h3>
                    <p class="text-gray-600 text-sm">Exploring how technology and practical learning can transform Nepal's education system.</p>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-[#D4AF37] hover:underline">Read More →</a>
                </div>
            </article>

            <!-- Blog Post 2 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-blue-500/20 to-blue-500/5 flex items-center justify-center">
                    <span class="text-6xl">💻</span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span>January 10, 2024</span>
                        <span>•</span>
                        <span class="text-[#D4AF37] font-semibold">Technology</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 hover:text-[#D4AF37] transition-colors">
                        <a href="#">Building Digital Skills for Youth</a>
                    </h3>
                    <p class="text-gray-600 text-sm">How Skill Sikka is empowering young people with digital skills for the future.</p>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-[#D4AF37] hover:underline">Read More →</a>
                </div>
            </article>

            <!-- Blog Post 3 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-emerald-500/20 to-emerald-500/5 flex items-center justify-center">
                    <span class="text-6xl">🏔️</span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span>January 5, 2024</span>
                        <span>•</span>
                        <span class="text-[#D4AF37] font-semibold">Tourism</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 hover:text-[#D4AF37] transition-colors">
                        <a href="#">Reimagining Tourism in Nepal</a>
                    </h3>
                    <p class="text-gray-600 text-sm">How HillyChilly is gamifying tourism to promote local destinations and culture.</p>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-[#D4AF37] hover:underline">Read More →</a>
                </div>
            </article>

            <!-- Blog Post 4 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-purple-500/20 to-purple-500/5 flex items-center justify-center">
                    <span class="text-6xl">🌱</span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span>December 28, 2023</span>
                        <span>•</span>
                        <span class="text-[#D4AF37] font-semibold">Sustainability</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 hover:text-[#D4AF37] transition-colors">
                        <a href="#">Building Sustainable Communities</a>
                    </h3>
                    <p class="text-gray-600 text-sm">How Kholso is creating regenerative living spaces celebrating culture.</p>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-[#D4AF37] hover:underline">Read More →</a>
                </div>
            </article>

            <!-- Blog Post 5 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-amber-500/20 to-amber-500/5 flex items-center justify-center">
                    <span class="text-6xl">🚀</span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span>December 20, 2023</span>
                        <span>•</span>
                        <span class="text-[#D4AF37] font-semibold">Entrepreneurship</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 hover:text-[#D4AF37] transition-colors">
                        <a href="#">Empowering Young Entrepreneurs</a>
                    </h3>
                    <p class="text-gray-600 text-sm">How Future Builders is creating a youth movement for entrepreneurship.</p>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-[#D4AF37] hover:underline">Read More →</a>
                </div>
            </article>

            <!-- Blog Post 6 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="h-48 bg-gradient-to-r from-red-500/20 to-red-500/5 flex items-center justify-center">
                    <span class="text-6xl">🇳🇵</span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span>December 15, 2023</span>
                        <span>•</span>
                        <span class="text-[#D4AF37] font-semibold">Nation</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 hover:text-[#D4AF37] transition-colors">
                        <a href="#">Nation First: A Vision for Nepal</a>
                    </h3>
                    <p class="text-gray-600 text-sm">Building a self-reliant Nepal through education, tourism and technology.</p>
                    <a href="#" class="inline-block mt-4 text-sm font-semibold text-[#D4AF37] hover:underline">Read More →</a>
                </div>
            </article>
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="inline-block bg-[#D4AF37] text-[#0b0e12] px-8 py-3 font-semibold rounded-sm hover:brightness-110 transition-all">
                Load More Posts
            </a>
        </div>
    </div>
</section>
@endsection