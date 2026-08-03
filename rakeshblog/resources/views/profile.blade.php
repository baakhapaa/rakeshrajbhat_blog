@extends('layouts.app')

@section('title', 'Profile · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-[#D4AF37] to-[#c4a030] px-8 py-12">
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white">
                        <span class="text-4xl font-bold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-serif font-bold text-white">{{ Auth::user()->name }}</h1>
                        <p class="text-white/80">{{ Auth::user()->email }}</p>
                        <p class="text-white/70 text-sm mt-1">Member since {{ Auth::user()->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="p-8">
                <h2 class="text-xl font-bold mb-6">Profile Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500 uppercase font-semibold">Full Name</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->name }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500 uppercase font-semibold">Email Address</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500 uppercase font-semibold">Account Created</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="text-xs text-gray-500 uppercase font-semibold">Last Updated</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->updated_at->format('M d, Y') }}</p>
                    </div>
                    
                    @if(Auth::user()->ip_address)
                    <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                        <label class="text-xs text-gray-500 uppercase font-semibold">IP Address</label>
                        <p class="text-lg font-medium mt-1">{{ Auth::user()->ip_address }}</p>
                    </div>
                    @endif
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 flex gap-4">
                    <a href="{{ route('settings') }}" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection