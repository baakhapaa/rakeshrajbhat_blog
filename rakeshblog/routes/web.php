<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendBlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ResearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BootcampController;

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
Route::get('/blog/{slug}', [FrontendBlogController::class, 'show'])->name('blog.show');

// ==========================================
// BLOG FEATURES
// ==========================================
Route::get('/blog/category/{category}', [FrontendBlogController::class, 'byCategory'])->name('blog.category');
Route::get('/blog/search', [FrontendBlogController::class, 'search'])->name('blog.search');
Route::get('/blog/archive/{year}/{month}', [FrontendBlogController::class, 'archive'])->name('blog.archive');
Route::get('/blog/feed', [FrontendBlogController::class, 'feed'])->name('blog.feed');

// ==========================================
// BLOG API ROUTES (AJAX)
// ==========================================
Route::get('/api/blog/popular', [FrontendBlogController::class, 'popular'])->name('api.blog.popular');
Route::get('/api/blog/featured', [FrontendBlogController::class, 'featured'])->name('api.blog.featured');
Route::get('/api/blog/latest', [FrontendBlogController::class, 'latest'])->name('api.blog.latest');
Route::get('/api/blog/categories', [FrontendBlogController::class, 'categories'])->name('api.blog.categories');
Route::get('/api/blog/archives', [FrontendBlogController::class, 'archives'])->name('api.blog.archives');

// ==========================================
// HOME API ROUTES (AJAX)
// ==========================================
Route::get('/api/projects', [HomeController::class, 'getProjects'])->name('api.projects');
Route::get('/api/projects/{slug}', [HomeController::class, 'getProject'])->name('api.project');
Route::get('/api/featured-blogs', [HomeController::class, 'getFeaturedBlogs'])->name('api.featured-blogs');
Route::get('/api/latest-blogs', [HomeController::class, 'getLatestBlogs'])->name('api.latest-blogs');

// ==========================================
// RESEARCH API ROUTES
// ==========================================
Route::get('/research/{id}/video', [ResearchController::class, 'getVideoData'])->name('research.video');
Route::get('/research/featured', [ResearchController::class, 'featured'])->name('research.featured');

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

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// ==========================================
// BOOTCAMP ROUTES 
// ==========================================
Route::get('/bootcamp', [BootcampController::class, 'index'])->name('bootcamp');
Route::post('/bootcamp', [BootcampController::class, 'submit'])->name('bootcamp.submit');

// ==========================================
// WORK WITH ME ROUTE
// ==========================================
Route::view('/work-with-me', 'partials.work-with-me')->name('work-with-me');
Route::post('/work-with-me/send', [ContactController::class, 'sendWorkWithMe'])->name('work-with-me.send');

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
    
    // Comment Routes (CRUD)
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Comment Like Routes
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::post('/comments/{id}/unlike', [CommentController::class, 'unlike'])->name('comments.unlike');
    
    // Quiz Routes
    Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/submit/{quizId}', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::post('/quiz/reset', [QuizController::class, 'reset'])->name('quiz.reset');
    Route::get('/quiz/history', [QuizController::class, 'history'])->name('quiz.history');
    Route::get('/quiz/retake/{quizId}', [QuizController::class, 'retake'])->name('quiz.retake');
    Route::get('/quiz/leaderboard', [QuizController::class, 'leaderboard'])->name('quiz.leaderboard');
    Route::get('/quiz/results/{userId?}', [QuizController::class, 'getResults'])->name('quiz.results');
    Route::get('/quiz/stats/{userId?}', [QuizController::class, 'getStats'])->name('quiz.stats');
});

// ==========================================
// ADMIN ROUTES
// ==========================================

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Admin Guest Routes (Not Logged In)
    Route::middleware(['guest'])->group(function () {
        Route::controller(AdminAuthController::class)->group(function () {
            Route::get('/login', 'showLogin')->name('login');
            Route::post('/login', 'login');
        });
    });
    
    // Admin Protected Routes (Must Be Logged In)
    Route::middleware(['admin.auth'])->group(function () {
        
        // Dashboard & Logout
        Route::controller(AdminAuthController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::post('/logout', 'logout')->name('logout');
        });
        
        // Image Upload Routes
        Route::post('/upload-image', [ImageController::class, 'upload'])->name('upload-image');
        Route::delete('/delete-image', [ImageController::class, 'delete'])->name('delete-image');
        
        // Resource Routes
        Route::resource('stats', StatController::class);       
        Route::resource('team-members', TeamMemberController::class);
        Route::resource('blogs', AdminBlogController::class);
        
        // ==========================================
        // RESEARCH ROUTES
        // ==========================================
        Route::resource('research', ResearchController::class);
        Route::post('/research/{id}/toggle-status', [ResearchController::class, 'toggleStatus'])->name('research.toggle-status');
        Route::post('/research/{id}/toggle-featured', [ResearchController::class, 'toggleFeatured'])->name('research.toggle-featured');
        Route::post('/research/reorder', [ResearchController::class, 'reorder'])->name('research.reorder');
        
        // ==========================================
        // USER MANAGEMENT ROUTES
        // ==========================================
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
        
        // ==========================================
        // ADMIN BLOG FEATURES
        // ==========================================
        Route::post('/blogs/{id}/toggle-publish', [AdminBlogController::class, 'togglePublish'])->name('blogs.toggle-publish');
        Route::patch('/blogs/{id}/toggle-featured', [AdminBlogController::class, 'toggleFeatured'])->name('blogs.toggle-featured');
        
        // ==========================================
        // ADMIN QUIZ ROUTES
        // ==========================================
        Route::get('/blogs/{blogId}/quizzes/create', [AdminQuizController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [AdminQuizController::class, 'store'])->name('quizzes.store');
        Route::get('/quizzes/{id}/edit', [AdminQuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('/quizzes/{id}', [AdminQuizController::class, 'update'])->name('quizzes.update');
        Route::delete('/quizzes/{id}', [AdminQuizController::class, 'destroy'])->name('quizzes.destroy');
        Route::post('/quizzes/add-question', [AdminQuizController::class, 'addQuestion'])->name('quizzes.add-question');
        Route::delete('/quizzes/remove-question/{id}', [AdminQuizController::class, 'removeQuestion'])->name('quizzes.remove-question');
        Route::get('/blogs/{blogId}/quiz', [AdminQuizController::class, 'index'])->name('quizzes.index');
        
        // ==========================================
        // ADMIN COMMENT ROUTES
        // ==========================================
        Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('/comments/{id}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
        Route::post('/comments/{id}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
        
        // ==========================================
        // ACTIVITY LOGS ROUTES
        // ==========================================
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
        Route::delete('/activity-logs/{id}', [ActivityLogController::class, 'destroy'])->name('activity.logs.destroy');
        Route::post('/activity-logs/clear', [ActivityLogController::class, 'clearAll'])->name('activity.logs.clear');
        Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity.logs.export');
        
        // ==========================================
        // PROJECTS ROUTES
        // ==========================================
        Route::resource('projects', ProjectController::class);
        Route::post('/projects/{id}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
        Route::post('/projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');
        
        // ==========================================
        // SETTINGS ROUTES
        // ==========================================
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
        Route::put('/settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.update-general');
    });
});