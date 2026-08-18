<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Helpers\ActivityLogger;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('admin.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $admin = Auth::guard('admin')->user();
            $admin->last_login_at = now();
            $admin->last_login_ip = $request->ip();
            $admin->save();
            
            // Log admin login
            ActivityLogger::log('admin_login', 'Admin logged in', ['email' => $admin->email]);
            
            return redirect()->intended('/admin/dashboard');
        }

        // Log failed login attempt
        ActivityLogger::log('failed_login', 'Failed admin login attempt', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Handle logout
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Log admin logout
        if ($admin) {
            ActivityLogger::log('admin_logout', 'Admin logged out', ['email' => $admin->email]);
        }
        
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}