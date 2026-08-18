@extends('admin.layouts.app')

@section('title', 'Activity Logs · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white flex items-center gap-3">
                <i class="fas fa-history text-[#D4AF37]"></i>
                Activity Logs
            </h1>
            <p class="text-gray-400 text-sm mt-1">Track all user activities across the platform</p>
        </div>
        {{-- <div class="flex gap-3 mt-4 md:mt-0">
            <button onclick="if(confirm('Are you sure you want to clear all activity logs?')) document.getElementById('clear-form').submit();" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                <i class="fas fa-trash-alt"></i> Clear All
            </button> --}}
            <form id="clear-form" action="{{ route('admin.activity.logs.clear') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-4 mb-6">
        <form method="GET" action="{{ route('admin.activity.logs') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by user, activity, IP..."
                       class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
            </div>
            <div class="min-w-[180px]">
                <select name="activity_type" class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                    <option value="">All Activities</option>
                    @foreach($activityTypes as $type)
                        <option value="{{ $type }}" {{ request('activity_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2">
                <i class="fas fa-search"></i> Search
            </button>
            @if(request()->has('search') || request()->has('activity_type'))
                <a href="{{ route('admin.activity.logs') }}" class="px-4 py-2 border border-white/20 text-white/70 rounded-lg hover:bg-white/5 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-[#0b0e12]">
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.activity.logs', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center gap-1 hover:text-white transition">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">User</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Activity</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">IP Address</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Browser</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.activity.logs', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="flex items-center gap-1 hover:text-white transition">
                                Time
                                @if(request('sort') == 'created_at')
                                    <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="py-4 px-4 text-sm text-gray-400">#{{ $log->id }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#D4AF37]/20 text-[#D4AF37] flex items-center justify-center font-bold text-sm">
                                        {{ $log->user_name ? strtoupper(substr($log->user_name, 0, 1)) : 'G' }}
                                    </div>
                                    <div>
                                        <p class="text-white text-sm font-medium">{{ $log->user_name ?? 'Guest' }}</p>
                                        <p class="text-xs text-gray-400">{{ $log->user_email ?? 'No email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $log->activity == 'login' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : '' }}
                                    {{ $log->activity == 'logout' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
                                    {{ $log->activity == 'quiz_submitted' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                                    {{ $log->activity == 'comment_posted' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}
                                    {{ $log->activity == 'blog_created' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                                    {{ $log->activity == 'blog_updated' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : '' }}
                                    {{ $log->activity == 'blog_deleted' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
                                    {{ !in_array($log->activity, ['login', 'logout', 'quiz_submitted', 'comment_posted', 'blog_created', 'blog_updated', 'blog_deleted']) ? 'bg-gray-500/20 text-gray-400 border border-gray-500/30' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $log->activity)) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-400 font-mono">{{ $log->ip_address ?? '-' }}</td>
                            <td class="py-4 px-4 text-sm text-gray-400">{{ $log->browser ?? '-' }}</td>
                            <td class="py-4 px-4 text-sm text-gray-400">
                                <span title="{{ $log->formatted_date ?? $log->created_at->format('M d, Y h:i A') }}">
                                    {{ $log->time_ago ?? $log->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <button onclick="if(confirm('Delete this log entry?')) document.getElementById('delete-form-{{ $log->id }}').submit();" 
                                        class="p-1.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded transition" 
                                        title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                                <form id="delete-form-{{ $log->id }}" action="{{ route('admin.activity.logs.destroy', $log->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400">
                                <i class="fas fa-history text-5xl block mb-4 text-white/10"></i>
                                <p class="text-lg font-medium">No activity logs found</p>
                                <p class="text-sm text-gray-500 mt-1">Activities will appear here once users start interacting</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-white/10">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">Total Logs</p>
            <p class="text-2xl font-bold text-white">{{ \App\Models\ActivityLog::count() }}</p>
        </div>
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">Today</p>
            <p class="text-2xl font-bold text-white">{{ \App\Models\ActivityLog::whereDate('created_at', today())->count() }}</p>
        </div>
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">This Week</p>
            <p class="text-2xl font-bold text-white">{{ \App\Models\ActivityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}</p>
        </div>
        <div class="bg-[#1a1f26] rounded-xl p-4 border border-white/5">
            <p class="text-gray-400 text-xs">This Month</p>
            <p class="text-2xl font-bold text-white">{{ \App\Models\ActivityLog::whereMonth('created_at', now()->month)->count() }}</p>
        </div>
    </div>
</div>
@endsection