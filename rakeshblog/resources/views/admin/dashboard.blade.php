@extends('admin.layouts.app')

@section('title', 'Dashboard · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- =========================================================
        DASHBOARD HEADER
    ========================================================== --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-11 h-11 rounded-xl bg-[#D4AF37]/10 border border-[#D4AF37]/20 flex items-center justify-center">
                        <i class="fas fa-chart-line text-[#D4AF37] text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-serif font-bold text-white">Dashboard</h1>
                        <p class="text-gray-500 text-xs mt-0.5">Administration overview</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <i class="far fa-clock text-[#D4AF37]"></i>
                <span>
                    Welcome back,
                    <span class="text-white font-medium">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                </span>
            </div>
        </div>
    </div>

    {{-- =========================================================
        STATISTICS
    ========================================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- TOTAL USERS --}}
        <div class="dashboard-card group">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="icon-wrapper"><i class="fas fa-user-friends"></i></span>
                        <span class="stat-label">Total Users</span>
                    </div>
                    <p class="stat-number">{{ \App\Models\User::count() }}</p>
                    <p class="stat-description">Registered accounts</p>
                </div>
                <div class="stat-icon gold"><i class="fas fa-users"></i></div>
            </div>
        </div>

        {{-- TOTAL BLOGS --}}
        <div class="dashboard-card group">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="icon-wrapper"><i class="fas fa-newspaper"></i></span>
                        <span class="stat-label">Total Blogs</span>
                    </div>
                    <p class="stat-number">{{ \App\Models\Blog::count() ?? 0 }}</p>
                    <p class="stat-description">Articles created</p>
                </div>
                <div class="stat-icon gold"><i class="fas fa-file-alt"></i></div>
            </div>
        </div>

        {{-- TOTAL QUIZZES --}}
        <div class="dashboard-card group">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="icon-wrapper"><i class="fas fa-puzzle-piece"></i></span>
                        <span class="stat-label">Total Quizzes</span>
                    </div>
                    <p class="stat-number">{{ \App\Models\Quiz::count() ?? 0 }}</p>
                    <p class="stat-description">Interactive quizzes</p>
                </div>
                <div class="stat-icon purple"><i class="fas fa-brain"></i></div>
            </div>
        </div>

        {{-- PUBLISHED BLOGS --}}
        <div class="dashboard-card group published-card">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="icon-wrapper green-icon"><i class="fas fa-check"></i></span>
                        <span class="stat-label">Published Blogs</span>
                    </div>
                    <p class="stat-number">{{ \App\Models\Blog::where('is_published', true)->count() ?? 0 }}</p>
                    <p class="stat-description">Live on the platform</p>
                </div>
                <div class="stat-icon green"><i class="fas fa-globe"></i></div>
            </div>
        </div>
    </div>

    {{-- =========================================================
        QUICK ACTIONS + ADMIN INFORMATION
    ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- =====================================================
            QUICK ACTIONS
        ====================================================== --}}
        <div class="dashboard-section">
            <div class="section-header">
                <div class="flex items-center gap-3">
                    <div class="section-icon"><i class="fas fa-bolt"></i></div>
                    <div>
                        <h2 class="section-title">Quick Actions</h2>
                        <p class="section-subtitle">Frequently used administration tools</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 p-5">
                {{-- NEW BLOG --}}
                <a href="{{ route('admin.blogs.create') }}" class="action-card group">
                    <div class="action-icon gold"><i class="fas fa-pen-nib"></i></div>
                    <div>
                        <p class="action-title">New Blog</p>
                        <p class="action-description">Create article</p>
                    </div>
                    <i class="fas fa-arrow-right action-arrow"></i>
                </a>

                {{-- USERS --}}
                <a href="{{ route('admin.users.index') }}" class="action-card group">
                    <div class="action-icon blue"><i class="fas fa-user-cog"></i></div>
                    <div>
                        <p class="action-title">Users</p>
                        <p class="action-description">Manage accounts</p>
                    </div>
                    <i class="fas fa-arrow-right action-arrow"></i>
                </a>

                {{-- BLOGS --}}
                <a href="{{ route('admin.blogs.index') }}" class="action-card group">
                    <div class="action-icon purple"><i class="fas fa-folder-open"></i></div>
                    <div>
                        <p class="action-title">Blogs</p>
                        <p class="action-description">Manage content</p>
                    </div>
                    <i class="fas fa-arrow-right action-arrow"></i>
                </a>

                {{-- SETTINGS --}}
                <a href="{{ route('admin.settings') }}" class="action-card group">
                    <div class="action-icon gray"><i class="fas fa-sliders-h"></i></div>
                    <div>
                        <p class="action-title">Settings</p>
                        <p class="action-description">System preferences</p>
                    </div>
                    <i class="fas fa-arrow-right action-arrow"></i>
                </a>
            </div>
        </div>

        {{-- =====================================================
            ADMIN INFORMATION
        ====================================================== --}}
        <div class="dashboard-section">
            <div class="section-header">
                <div class="flex items-center gap-3">
                    <div class="section-icon"><i class="fas fa-user-shield"></i></div>
                    <div>
                        <h2 class="section-title">Admin Information</h2>
                        <p class="section-subtitle">Current administrator details</p>
                    </div>
                </div>
            </div>
            <div class="p-5">
                {{-- LOGGED IN USER --}}
                <div class="info-row">
                    <div class="info-label">
                        <div class="info-icon"><i class="fas fa-user"></i></div>
                        <span>Logged in as</span>
                    </div>
                    <span class="info-value">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                </div>

                {{-- EMAIL --}}
                <div class="info-row">
                    <div class="info-label">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <span>Email</span>
                    </div>
                    <span class="info-value truncate max-w-[220px]">{{ Auth::guard('admin')->user()->email ?? 'admin@example.com' }}</span>
                </div>

                {{-- LAST LOGIN --}}
                <div class="info-row">
                    <div class="info-label">
                        <div class="info-icon"><i class="fas fa-history"></i></div>
                        <span>Last Login</span>
                    </div>
                    <span class="info-value">
                        @if(Auth::guard('admin')->user()->last_login_at)
                            {{ Auth::guard('admin')->user()->last_login_at->diffForHumans() }}
                        @else
                            First login
                        @endif
                    </span>
                </div>

                {{-- TOTAL USERS --}}
                <div class="info-row">
                    <div class="info-label">
                        <div class="info-icon"><i class="fas fa-users"></i></div>
                        <span>Total Users</span>
                    </div>
                    <span class="info-value highlight">{{ \App\Models\User::count() }}</span>
                </div>

                {{-- TOTAL BLOGS --}}
                <div class="info-row">
                    <div class="info-label">
                        <div class="info-icon"><i class="fas fa-newspaper"></i></div>
                        <span>Total Blogs</span>
                    </div>
                    <span class="info-value highlight">{{ \App\Models\Blog::count() ?? 0 }}</span>
                </div>

                {{-- COMMENTS --}}
                <div class="info-row last">
                    <div class="info-label">
                        <div class="info-icon"><i class="fas fa-comment-dots"></i></div>
                        <span>Total Comments</span>
                    </div>
                    <span class="info-value highlight">{{ \App\Models\Comment::count() ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
        RECENT ACTIVITY
    ========================================================== --}}
    <div class="dashboard-section overflow-hidden">
        {{-- HEADER --}}
        <div class="section-header">
            <div class="flex items-center gap-3">
                <div class="section-icon"><i class="fas fa-history"></i></div>
                <div>
                    <h2 class="section-title">Recent Activity</h2>
                    <p class="section-subtitle">Latest users who joined the platform</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="view-all-link">
                View All
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        {{-- USERS --}}
        <div class="p-5">
            @php
                $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get();
            @endphp

            @if($recentUsers->count() > 0)
                <div class="space-y-2">
                    @foreach($recentUsers as $user)
                        <div class="activity-row">
                            {{-- USER AVATAR --}}
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="activity-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div class="min-w-0">
                                    <p class="text-white text-sm font-medium truncate">{{ $user->name }}</p>
                                    <p class="text-gray-500 text-xs flex items-center gap-1.5 truncate">
                                        <i class="far fa-envelope text-[10px] text-[#D4AF37]"></i>
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>

                            {{-- USER META --}}
                            <div class="flex items-center gap-4">
                                {{-- DATE --}}
                                <span class="activity-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $user->created_at->diffForHumans() }}
                                </span>

                                {{-- STATUS --}}
                                @if($user->is_active)
                                    <span class="status-badge active">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="status-badge inactive">
                                        <span class="status-dot"></span>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-user-plus"></i></div>
                    <h3>No users yet</h3>
                    <p>New registered users will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- =============================================================
    DASHBOARD STYLES
============================================================= --}}
<style>
    /* =========================================================
       BASE
    ========================================================== */
    .dashboard-card,
    .dashboard-section {
        background: #1a1f26;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
    }

    .dashboard-card {
        border-radius: 14px;
        padding: 22px;
    }

    .dashboard-card:hover,
    .dashboard-section:hover {
        border-color: rgba(212, 175, 55, 0.22);
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.18);
    }

    /* =========================================================
       STATISTICS
    ========================================================== */
    .stat-label {
        color: rgba(255, 255, 255, 0.58);
        font-size: 13px;
        font-weight: 500;
    }

    .stat-number {
        color: #fff;
        font-size: 30px;
        line-height: 1;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 7px;
    }

    .stat-description {
        color: rgba(255, 255, 255, 0.32);
        font-size: 11px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover .stat-icon {
        transform: translateY(-3px);
    }

    .stat-icon.gold {
        color: #D4AF37;
        background: rgba(212, 175, 55, 0.10);
        border: 1px solid rgba(212, 175, 55, 0.12);
    }

    .stat-icon.green {
        color: #34d399;
        background: rgba(52, 211, 153, 0.10);
        border: 1px solid rgba(52, 211, 153, 0.12);
    }

    .stat-icon.purple {
        color: #a78bfa;
        background: rgba(167, 139, 250, 0.10);
        border: 1px solid rgba(167, 139, 250, 0.12);
    }

    .icon-wrapper {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #D4AF37;
        background: rgba(212, 175, 55, 0.08);
        font-size: 10px;
    }

    .green-icon {
        color: #34d399 !important;
        background: rgba(52, 211, 153, 0.08) !important;
    }

    /* =========================================================
       SECTION HEADERS
    ========================================================== */
    .section-header {
        min-height: 76px;
        padding: 18px 22px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #D4AF37;
        background: rgba(212, 175, 55, 0.09);
        border: 1px solid rgba(212, 175, 55, 0.10);
        font-size: 15px;
    }

    .section-title {
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        margin: 0;
    }

    .section-subtitle {
        color: rgba(255, 255, 255, 0.32);
        font-size: 11px;
        margin-top: 3px;
    }

    /* =========================================================
       QUICK ACTIONS
    ========================================================== */
    .action-card {
        position: relative;
        min-height: 92px;
        padding: 15px;
        border-radius: 11px;
        background: rgba(255, 255, 255, 0.025);
        border: 1px solid rgba(255, 255, 255, 0.045);
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .action-card:hover {
        background: rgba(255, 255, 255, 0.045);
        border-color: rgba(212, 175, 55, 0.20);
        transform: translateY(-2px);
        text-decoration: none;
    }

    .action-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .action-icon.gold {
        color: #D4AF37;
        background: rgba(212, 175, 55, 0.10);
    }

    .action-icon.blue {
        color: #60a5fa;
        background: rgba(96, 165, 250, 0.10);
    }

    .action-icon.purple {
        color: #a78bfa;
        background: rgba(167, 139, 250, 0.10);
    }

    .action-icon.gray {
        color: #94a3b8;
        background: rgba(148, 163, 184, 0.10);
    }

    .action-title {
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        margin: 0;
    }

    .action-description {
        color: rgba(255, 255, 255, 0.32);
        font-size: 10px;
        margin-top: 3px;
    }

    .action-arrow {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.15);
        font-size: 10px;
        transition: all 0.25s ease;
    }

    .action-card:hover .action-arrow {
        color: #D4AF37;
        right: 10px;
    }

    /* =========================================================
       ADMIN INFO
    ========================================================== */
    .info-row {
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.045);
    }

    .info-row.last {
        border-bottom: none;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.52);
        font-size: 12px;
    }

    .info-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #D4AF37;
        background: rgba(212, 175, 55, 0.07);
        font-size: 10px;
    }

    .info-value {
        color: rgba(255, 255, 255, 0.82);
        font-size: 12px;
        text-align: right;
    }

    .info-value.highlight {
        color: #D4AF37;
        font-weight: 600;
    }

    /* =========================================================
       VIEW ALL
    ========================================================== */
    .view-all-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #D4AF37;
        font-size: 11px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .view-all-link:hover {
        color: #f0d36b;
        text-decoration: none;
    }

    .view-all-link i {
        font-size: 9px;
        transition: transform 0.2s ease;
    }

    .view-all-link:hover i {
        transform: translateX(3px);
    }

    /* =========================================================
       ACTIVITY
    ========================================================== */
    .activity-row {
        min-height: 68px;
        padding: 10px 12px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        transition: background 0.2s ease;
    }

    .activity-row:hover {
        background: rgba(255, 255, 255, 0.025);
    }

    .activity-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #D4AF37;
        background: rgba(212, 175, 55, 0.10);
        border: 1px solid rgba(212, 175, 55, 0.15);
        font-size: 12px;
        font-weight: 700;
    }

    .activity-date {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.32);
        font-size: 10px;
        white-space: nowrap;
    }

    .activity-date i {
        color: rgba(212, 175, 55, 0.7);
    }

    /* =========================================================
       STATUS
    ========================================================== */
    .status-badge {
        min-width: 72px;
        padding: 5px 9px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 10px;
        font-weight: 600;
    }

    .status-badge.active {
        color: #34d399;
        background: rgba(52, 211, 153, 0.08);
        border: 1px solid rgba(52, 211, 153, 0.15);
    }

    .status-badge.inactive {
        color: #f87171;
        background: rgba(248, 113, 113, 0.08);
        border: 1px solid rgba(248, 113, 113, 0.15);
    }

    .status-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    /* =========================================================
       EMPTY STATE
    ========================================================== */
    .empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 15px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(212, 175, 55, 0.5);
        background: rgba(212, 175, 55, 0.05);
        border: 1px solid rgba(212, 175, 55, 0.08);
        font-size: 20px;
    }

    .empty-state h3 {
        color: rgba(255, 255, 255, 0.75);
        font-size: 14px;
        font-weight: 600;
        margin: 0;
    }

    .empty-state p {
        color: rgba(255, 255, 255, 0.28);
        font-size: 11px;
        margin-top: 5px;
        margin-bottom: 0;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================== */
    @media (max-width: 640px) {
        .section-header {
            align-items: flex-start;
        }

        .activity-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .activity-row > div:last-child {
            width: 100%;
            padding-left: 51px;
        }

        .activity-date {
            display: none;
        }

        .info-value {
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

    @media (max-width: 400px) {
        .action-card {
            padding: 12px;
        }

        .action-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
        }

        .action-description {
            display: none;
        }
    }
</style>
@endsection