<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use App\Models\PasswordResetOtp;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Rate limiting
        $throttleKey = 'login_' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Too many login attempts. Please wait {$seconds} seconds."
            ])->onlyInput('email');
        }

        $credentials['email'] = strtolower($credentials['email']);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            try {
                $user->ip_address = $request->ip();
                $user->last_login_ip = $request->ip();
                $user->last_login_at = now();
                $user->save();
            } catch (\Exception $e) {
                \Log::warning('Could not update login tracking: ' . $e->getMessage());
            }
            
            // Log successful login
            ActivityLogger::log('user_login', 'User logged in', [
                'email' => $user->email,
                'ip' => $request->ip()
            ]);
            
            return redirect()->intended('/');
        }

        RateLimiter::hit($throttleKey, 60);

        // Log failed login attempt
        ActivityLogger::log('failed_login', 'Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show register page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'ip_address' => $request->ip(),
            'phone' => $request->phone ?? null,
        ]);

        // Log registration
        ActivityLogger::log('user_registered', 'User registered', [
            'email' => $user->email,
            'ip' => $request->ip()
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful!');
    }

    // Show forgot password form
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Rate limiting for OTP
        $throttleKey = 'otp_send_' . strtolower($request->email);
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Too many attempts. Please wait {$seconds} seconds."
                ], 429);
            }
            return back()->withErrors(['email' => "Too many attempts. Please wait {$seconds} seconds."]);
        }

        $email = strtolower($request->email);
        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if (!$user) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'We could not find a user with that email address.'
                ], 404);
            }
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete old OTPs
        PasswordResetOtp::where('email', $email)->delete();

        // Store new OTP
        PasswordResetOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP via email
        $emailSent = $this->sendOtpEmail($user->name, $email, $otp);

        if (!$emailSent) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again.'
                ], 500);
            }
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        RateLimiter::hit($throttleKey, 60);
        session(['reset_email' => $email]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'A new OTP has been sent to your email address.'
            ]);
        }

        return redirect()->route('password.verify-otp')->with('status', 'We have sent a 6-digit OTP to your email address.');
    }

    // Show OTP verification form
    public function showVerifyOtp()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Please start the password reset process again.']);
        }

        return view('auth.verify-otp', ['email' => session('reset_email')]);
    }

    // Verify OTP and reset password
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Session expired. Please try again.']);
        }

        // Find the OTP record
        $otpRecord = PasswordResetOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        if (!$otpRecord->isValid()) {
            if ($otpRecord->is_used) {
                return back()->withErrors(['otp' => 'This OTP has already been used. Please request a new one.']);
            }
            if ($otpRecord->expires_at->isPast()) {
                return back()->withErrors(['otp' => 'This OTP has expired. Please request a new one.']);
            }
        }

        // Mark OTP as used
        $otpRecord->update(['is_used' => true]);

        // Find the user and update password
        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session
        session()->forget(['reset_email', 'reset_token']);

        // Log password reset
        ActivityLogger::log('password_reset', 'User reset their password', [
            'email' => $email
        ]);

        return redirect()->route('login')->with('status', 'Your password has been reset successfully! You can now login with your new password.');
    }

    // Send OTP via email
    private function sendOtpEmail($name, $email, $otp)
    {
        $subject = 'Password Reset OTP - Rakesh Rajbhat';
        
        $html = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { text-align: center; padding: 20px 0; border-bottom: 3px solid #D4AF37; }
                    .otp-box { background: #f8f6f0; padding: 30px; text-align: center; border-radius: 8px; margin: 30px 0; }
                    .otp-code { font-size: 36px; font-weight: bold; color: #D4AF37; letter-spacing: 8px; }
                    .footer { text-align: center; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 12px; }
                    .expiry { color: #999; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1 style='color: #D4AF37; font-family: Playfair Display, serif;'>Rakesh Rajbhat</h1>
                        <p style='color: #666;'>Password Reset OTP</p>
                    </div>
                    
                    <p>Hello <strong>{$name}</strong>,</p>
                    <p>You requested to reset your password. Use the 6-digit OTP below to verify your identity:</p>
                    
                    <div class='otp-box'>
                        <div class='otp-code'>{$otp}</div>
                        <p class='expiry'>This OTP is valid for 10 minutes.</p>
                    </div>
                    
                    <p>If you didn't request this, please ignore this email.</p>
                    
                    <div class='footer'>
                        <p>&copy; " . date('Y') . " Rakesh Rajbhat. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        try {
            Mail::send([], [], function ($message) use ($email, $subject, $html) {
                $message->to($email)
                        ->subject($subject)
                        ->html($html);
            });
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
    }

    // Handle logout
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log logout
        if ($user) {
            ActivityLogger::log('user_logout', 'User logged out', [
                'email' => $user->email
            ]);
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}