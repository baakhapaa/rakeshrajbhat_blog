<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController as FrontendBlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\StatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// PUBLIC ROUTES
// ==========================================

// Home & Blog
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [FrontendBlogController::class, 'index'])->name('blog');

// Authentication Routes (Public)
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
});

// Password Reset Routes (OTP Based)
Route::controller(AuthController::class)->group(function () {
    Route::get('/forgot-password', 'showForgotPassword')->name('password.request');
    Route::post('/forgot-password', 'sendOtp')->name('password.send-otp');
    Route::get('/verify-otp', 'showVerifyOtp')->name('password.verify-otp');
    Route::post('/verify-otp', 'verifyOtp')->name('password.verify-otp.submit');
});

// ==========================================
// PROTECTED ROUTES (Requires Authentication)
// ==========================================

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'show')->name('profile');
        Route::get('/settings', 'settings')->name('settings');
        Route::put('/settings', 'update')->name('settings.update');
        Route::delete('/account', 'destroy')->name('account.delete');
    });
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ==========================================
// ADMIN ROUTES
// ==========================================

Route::prefix('admin')->name('admin.')->group(function () {
    
    // ------------------------------------------
    // Admin Guest Routes (Not Logged In)
    // ------------------------------------------
    Route::middleware(['guest'])->group(function () {
        Route::controller(AdminAuthController::class)->group(function () {
            Route::get('/login', 'showLogin')->name('login');
            Route::post('/login', 'login');
        });
    });
    
    // ------------------------------------------
    // Admin Protected Routes (Must Be Logged In)
    // ------------------------------------------
    Route::middleware(['admin.auth'])->group(function () {
        
        // Dashboard & Logout
        Route::controller(AdminAuthController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::post('/logout', 'logout')->name('logout');
        });
        
        Route::resource('stats', StatController::class);
        Route::resource('team-members', TeamMemberController::class);
        Route::resource('blogs', AdminBlogController::class);
        Route::resource('users', UserController::class);
        Route::resource('comments', CommentController::class);
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
        
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
    });
});