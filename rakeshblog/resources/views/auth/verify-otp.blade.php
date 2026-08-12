@extends('layouts.app')

@section('title', 'Verify OTP & Reset Password · Rakesh Rajbhat')

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
                <h1 class="text-3xl font-serif font-bold text-[#1e1e1a]">Verify OTP</h1>
                <p class="text-gray-500 mt-2">Enter the 6-digit code sent to your email</p>
                <p class="text-sm text-gray-400 mt-1">We sent it to: <strong>{{ $email ?? session('reset_email') }}</strong></p>
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

            <form action="{{ route('password.verify-otp.submit') }}" method="POST" id="otpForm">
                @csrf
                
                <!-- OTP Input -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Enter 6-Digit OTP</label>
                    <div class="flex gap-3 justify-center">
                        @for($i = 1; $i <= 6; $i++)
                            <input type="text" 
                                   id="otp_{{ $i }}" 
                                   name="otp_parts[]" 
                                   maxlength="1" 
                                   class="w-14 h-14 text-center text-2xl font-bold border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"
                                   required
                                   autofocus
                                   oninput="moveToNext(this, {{ $i }})"
                                   onkeydown="moveToPrev(this, {{ $i }})"
                                   onpaste="handlePaste(event)">
                        @endfor
                    </div>
                    <input type="hidden" name="otp" id="otp_combined" value="">
                </div>

                <hr class="border-gray-200 my-6">

                <!-- New Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="Min 8 characters">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Password must be at least 8 characters</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"
                            placeholder="Confirm your password">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="w-full bg-[#D4AF37] text-[#0b0e12] py-3 rounded-lg font-semibold hover:bg-[#c4a030] transition-all hover:shadow-lg">
                    Verify OTP & Reset Password
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Didn't receive the code? 
                    <form action="{{ route('password.send-otp') }}" method="POST" class="inline" id="resendForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email ?? session('reset_email') }}">
                        <button type="submit" id="resendBtn" class="text-[#D4AF37] font-semibold hover:underline">
                            Resend OTP
                        </button>
                    </form>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#D4AF37] hover:underline">
                    ← Back to Login
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    }

    function moveToNext(input, index) {
        if (input.value.length === 1) {
            const nextInput = document.getElementById('otp_' + (index + 1));
            if (nextInput) {
                nextInput.focus();
            }
        }
        updateOtp();
    }

    function moveToPrev(input, index) {
        if (event.key === 'Backspace' && input.value.length === 0) {
            const prevInput = document.getElementById('otp_' + (index - 1));
            if (prevInput) {
                prevInput.focus();
            }
        }
        updateOtp();
    }

    function updateOtp() {
        let otp = '';
        for (let i = 1; i <= 6; i++) {
            const input = document.getElementById('otp_' + i);
            if (input) {
                otp += input.value;
            }
        }
        const combined = document.getElementById('otp_combined');
        if (combined) {
            combined.value = otp;
        }
    }

    function handlePaste(event) {
        event.preventDefault();
        const paste = (event.clipboardData || window.clipboardData).getData('text');
        const digits = paste.replace(/\D/g, '').slice(0, 6);
        
        for (let i = 0; i < digits.length; i++) {
            const input = document.getElementById('otp_' + (i + 1));
            if (input) {
                input.value = digits[i];
            }
        }
        
        const nextIndex = Math.min(digits.length, 5);
        const nextInput = document.getElementById('otp_' + (nextIndex + 1));
        if (nextInput) {
            nextInput.focus();
        }
        
        updateOtp();
    }

    // Resend OTP with AJAX
    document.getElementById('resendForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const btn = document.getElementById('resendBtn');
        const originalText = btn.textContent;
        
        btn.textContent = 'Sending...';
        btn.disabled = true;
        btn.style.opacity = '0.6';
        
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.message || 'Failed to send OTP. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        })
        .finally(() => {
            btn.textContent = originalText;
            btn.disabled = false;
            btn.style.opacity = '1';
        });
    });
</script>

<style>
    input[name="otp_parts[]"]:focus {
        outline: none;
        border-color: #D4AF37;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
    }
    input[name="otp_parts[]"] {
        transition: all 0.2s ease;
    }
</style>
@endsection