@extends('layouts.app')

@section('title', 'Reset Password · Rakesh Rajbhat')

@section('title', 'Choose a New Password | Rakesh Rajbhat')
@section('robots', 'noindex,nofollow')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] flex items-center">
    <div class="max-w-md mx-auto w-full px-6">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-serif font-bold text-[#1e1e1a]">Reset Password</h1>
                <p class="text-gray-500 mt-2">Enter your new password below</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? '' }}">
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required readonly
                        class="w-full px-4 py-3 text-black border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition @error('password') border-red-500 @enderror"
                        placeholder="Min 8 characters">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"
                        placeholder="Confirm your password">
                </div>

                <button type="submit" class="w-full bg-[#D4AF37] text-[#0b0e12] py-3 rounded-lg font-semibold hover:bg-[#c4a030] transition-all hover:shadow-lg">
                    Reset Password
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#D4AF37] hover:underline">
                    ← Back to Login
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
