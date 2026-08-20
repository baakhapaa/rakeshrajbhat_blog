@extends('layouts.app')

@section('title', 'Contact Us · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f8f6f0] text-[#1e1e1a]">
    <div class="max-w-5xl mx-auto px-6">
        <!-- Page Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1 bg-[#D4AF37]/10 text-[#D4AF37] text-sm font-semibold rounded-full mb-4">
                <i class="fas fa-heart mr-1"></i> We'd Love to Hear From You
            </span>
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4 text-[#1e1e1a]">Let's Connect</h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
                Have a question, idea, or just want to say hello? Reach out and we'll get back to you as soon as possible.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <div class="p-8 md:p-10">
                    <h2 class="text-2xl font-serif font-bold mb-2">Send a Message</h2>
                    <p class="text-gray-500 text-sm mb-6">Fill in the form below and we'll respond within 24 hours.</p>

                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-4 rounded-lg mb-6 flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 text-xl mt-0.5"></i>
                            <div>
                                <p class="font-semibold">Message Sent!</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-600 px-4 py-4 rounded-lg mb-6">
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user text-[#D4AF37] mr-1"></i>Full Name *
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition hover:border-[#D4AF37]/50"
                                    placeholder="John Doe">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-[#D4AF37] mr-1"></i>Email Address *
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition hover:border-[#D4AF37]/50"
                                    placeholder="john@example.com">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag text-[#D4AF37] mr-1"></i>Subject *
                            </label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition hover:border-[#D4AF37]/50"
                                placeholder="What would you like to talk about?">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment text-[#D4AF37] mr-1"></i>Your Message *
                            </label>
                            <textarea id="message" name="message" rows="6" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition resize-none hover:border-[#D4AF37]/50"
                                placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-between mt-1">
                                <p class="text-xs text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>Minimum 10 characters
                                </p>
                                <span id="charCount" class="text-xs text-gray-400">0 / 5000</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-[#D4AF37] to-[#c4a030] text-[#0b0e12] px-6 py-4 rounded-xl font-semibold hover:from-[#c4a030] hover:to-[#b8922a] transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3 group">
                            <span>Send Message</span>
                            <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info Sidebar -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Info -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6 md:p-8">
                        <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                            <i class="fas fa-address-card text-[#D4AF37]"></i>
                            <span>Contact Information</span>
                        </h3>
                        
                        <div class="space-y-5">
                            <div class="flex items-start gap-4 group hover:translate-x-1 transition-transform">
                                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[#D4AF37]/20 transition">
                                    <i class="fas fa-envelope text-[#D4AF37] text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Email</p>
                                    <a href="mailto:admin@rakeshrajbhat.com" class="text-gray-700 hover:text-[#D4AF37] transition font-medium">
                                        admin@rakeshrajbhat.com
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 group hover:translate-x-1 transition-transform">
                                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[#D4AF37]/20 transition">
                                    <i class="fas fa-phone text-[#D4AF37] text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Phone</p>
                                    <a href="tel:+9771234567890" class="text-gray-700 hover:text-[#D4AF37] transition font-medium">
                                        +977 123-456-7890
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 group hover:translate-x-1 transition-transform">
                                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[#D4AF37]/20 transition">
                                    <i class="fas fa-map-marker-alt text-[#D4AF37] text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Location</p>
                                    <p class="text-gray-700 font-medium">Nepal</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 group hover:translate-x-1 transition-transform">
                                <div class="w-12 h-12 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[#D4AF37]/20 transition">
                                    <i class="fas fa-clock text-[#D4AF37] text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Working Hours</p>
                                    <p class="text-gray-700 font-medium">Mon - Fri: 11:00 AM - 6:00 PM</p>
                                    <p class="text-sm text-gray-400">Weekend: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6 md:p-8">
                        <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                            <i class="fas fa-share-alt text-[#D4AF37]"></i>
                            <span>Connect With Us</span>
                        </h3>
                        
                        <div class="grid grid-cols-5 gap-3">
                            <a href="https://www.facebook.com/raacb/" class="w-full aspect-square rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center hover:bg-[#D4AF37]/20 transition-all hover:-translate-y-1 hover:shadow-lg text-[#D4AF37] hover:text-[#b8922a]">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/raacb/" class="w-full aspect-square rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center hover:bg-[#D4AF37]/20 transition-all hover:-translate-y-1 hover:shadow-lg text-[#D4AF37] hover:text-[#b8922a]">
                                <i class="fab fa-linkedin text-xl"></i>
                            </a>
                            <a href="https://www.instagram.com/raa_case7/" class="w-full aspect-square rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center hover:bg-[#D4AF37]/20 transition-all hover:-translate-y-1 hover:shadow-lg text-[#D4AF37] hover:text-[#b8922a]">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="https://www.youtube.com/channel/UCtydr8KirarNpQ9sj2QSXQw" class="w-full aspect-square rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center hover:bg-[#D4AF37]/20 transition-all hover:-translate-y-1 hover:shadow-lg text-[#D4AF37] hover:text-[#b8922a]">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                            <a href="https://github.com/baakhapaa" class="w-full aspect-square rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center hover:bg-[#D4AF37]/20 transition-all hover:-translate-y-1 hover:shadow-lg text-[#D4AF37] hover:text-[#b8922a]">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        </div>
                        <p class="text-center text-xs text-gray-400 mt-4">Follow us for updates and more</p>
                    </div>
                </div>

                <!-- Quick Response -->
                <div class="bg-gradient-to-r from-[#D4AF37]/10 to-[#c4a030]/10 rounded-2xl p-6 border border-[#D4AF37]/20 text-center">
                    <i class="fas fa-bolt text-[#D4AF37] text-2xl mb-2"></i>
                    <p class="font-semibold text-gray-700">Quick Response</p>
                    <p class="text-sm text-gray-500">We aim to respond within 24 hours</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Character counter for message
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('message');
        const charCount = document.getElementById('charCount');
        
        if (textarea && charCount) {
            textarea.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count + ' / 5000';
                
                if (count > 4500) {
                    charCount.style.color = '#ef4444';
                } else if (count > 4000) {
                    charCount.style.color = '#f59e0b';
                } else {
                    charCount.style.color = '#9ca3af';
                }
            });
        }
    });
</script>

<style>
    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }
    
    /* Hover effects for social icons */
    .aspect-square {
        aspect-ratio: 1 / 1;
    }
    
    /* Custom focus styles */
    input:focus, textarea:focus {
        outline: none;
    }
    
    /* Placeholder styling */
    ::placeholder {
        color: #a0aec0;
        font-weight: 300;
    }
    
    /* Gradient animation for submit button */
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    
    .bg-gradient-to-r {
        background-size: 200% auto;
    }
    
    button:hover .bg-gradient-to-r {
        animation: shimmer 1.5s ease-in-out infinite;
    }
</style>
@endsection