@extends('layouts.app')

@section('title', 'Forgot Password · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] flex items-center">
    <div class="max-w-md mx-auto w-full px-6">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-serif font-bold text-[#1e1e1a]">Forgot Password</h1>
                <p class="text-gray-500 mt-2">Enter your email and we'll send you a 6-digit OTP</p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.send-otp') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition @error('email') border-red-500 @enderror"
                        placeholder="you@example.com">
                </div>

                <button type="submit" class="w-full bg-[#D4AF37] text-[#0b0e12] py-3 rounded-lg font-semibold hover:bg-[#c4a030] transition-all hover:shadow-lg">
                    Send OTP
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#D4AF37] hover:underline">
                    ← Back to Login
                </a>
            </div>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-500">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-[#D4AF37] font-semibold hover:underline">Sign Up</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection