@extends('admin.layouts.app')

@section('title', 'Dashboard · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-serif font-bold text-white mb-6">Dashboard</h1>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-[#1a1f26] rounded-xl p-6 border border-white/5 hover:border-[#D4AF37]/30 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/60 text-sm">Total Users</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Blogs -->
        <div class="bg-[#1a1f26] rounded-xl p-6 border border-white/5 hover:border-[#D4AF37]/30 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/60 text-sm">Total Blogs</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Blog::count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="bg-[#1a1f26] rounded-xl p-6 border border-white/5 hover:border-[#D4AF37]/30 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/60 text-sm">Admins</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Admin::count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-[#D4AF37]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Published Blogs -->
        <div class="bg-[#1a1f26] rounded-xl p-6 border border-white/5 hover:border-[#D4AF37]/30 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/60 text-sm">Published Blogs</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ \App\Models\Blog::where('is_published', true)->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5">
            <h2 class="text-lg font-semibold text-white">Recent Activity</h2>
        </div>
        <div class="p-6">
            @php
                $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get();
            @endphp
            @if($recentUsers->count() > 0)
                <div class="space-y-3">
                    @foreach($recentUsers as $user)
                        <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#D4AF37]/20 text-[#D4AF37] flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-white text-sm">{{ $user->name }}</p>
                                    <p class="text-white/40 text-xs">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-white/40">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-white/40 py-8">
                    <svg class="w-16 h-16 mx-auto mb-4 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>No recent activity to display.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div class="bg-[#1a1f26] rounded-xl p-6 border border-white/5">
            <h3 class="text-white font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.blogs.create') }}" class="text-center p-4 rounded-lg bg-white/5 hover:bg-[#D4AF37]/10 transition-all duration-300 group">
                    <svg class="w-8 h-8 mx-auto mb-2 text-[#D4AF37] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="text-sm text-white/70 group-hover:text-white">New Blog</span>
                </a>
                <a href="{{ route('admin.users.create') }}" class="text-center p-4 rounded-lg bg-white/5 hover:bg-[#D4AF37]/10 transition-all duration-300 group">
                    <svg class="w-8 h-8 mx-auto mb-2 text-[#D4AF37] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span class="text-sm text-white/70 group-hover:text-white">Add User</span>
                </a>
                <a href="{{ route('admin.stats.index') }}" class="text-center p-4 rounded-lg bg-white/5 hover:bg-[#D4AF37]/10 transition-all duration-300 group">
                    <svg class="w-8 h-8 mx-auto mb-2 text-[#D4AF37] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="text-sm text-white/70 group-hover:text-white">Manage Stats</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="text-center p-4 rounded-lg bg-white/5 hover:bg-[#D4AF37]/10 transition-all duration-300 group">
                    <svg class="w-8 h-8 mx-auto mb-2 text-[#D4AF37] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm text-white/70 group-hover:text-white">Settings</span>
                </a>
            </div>
        </div>

        <div class="bg-[#1a1f26] rounded-xl p-6 border border-white/5">
            <h3 class="text-white font-semibold mb-4">Admin Info</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between text-white/60">
                    <span>Logged in as</span>
                    <span class="text-white">{{ Auth::guard('admin')->user()->name }}</span>
                </div>
                <div class="flex justify-between text-white/60">
                    <span>Email</span>
                    <span class="text-white">{{ Auth::guard('admin')->user()->email }}</span>
                </div>
                <div class="flex justify-between text-white/60">
                    <span>Last Login</span>
                    <span class="text-white">{{ Auth::guard('admin')->user()->last_login_at ? Auth::guard('admin')->user()->last_login_at->diffForHumans() : 'First login' }}</span>
                </div>
                <div class="flex justify-between text-white/60">
                    <span>Total Users</span>
                    <span class="text-white">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="flex justify-between text-white/60">
                    <span>Total Blogs</span>
                    <span class="text-white">{{ \App\Models\Blog::count() ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection