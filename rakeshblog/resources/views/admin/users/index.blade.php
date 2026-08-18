@extends('admin.layouts.app')

@section('title', 'User Management · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white flex items-center gap-3">
                <i class="fas fa-users text-[#D4AF37]"></i>
                User Management
            </h1>
            <p class="text-gray-400 text-sm mt-1">Manage all registered users</p>
        </div>
        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="{{ route('admin.users.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                <i class="fas fa-download"></i>
                Export CSV
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
    <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
    <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- Info Message --}}
    @if (session('info'))
    <div class="bg-blue-500/20 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
        <i class="fas fa-info-circle"></i>
        {{ session('info') }}
    </div>
    @endif

    {{-- Filters --}}
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-4 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email or phone..." class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
            </div>
            {{-- Role --}}
            <div class="min-w-[150px]">
                <select name="role" class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                    <option value="">All Roles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                </select>
            </div>
            {{-- Status --}}
            <div class="min-w-[150px]">
                <select name="status" class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            {{-- Search Button --}}
            <button type="submit" class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2">
                <i class="fas fa-search"></i>
                Search
            </button>
            {{-- Clear Filters --}}
            @if (request()->has('search') || request()->has('role') || request()->has('status'))
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-white/20 text-white/70 rounded-lg hover:bg-white/5 transition flex items-center gap-2">
                <i class="fas fa-times"></i>
                Clear
            </a>
            @endif
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px]">
                {{-- Table Header --}}
                <thead>
                    <tr class="border-b border-white/10 bg-[#0b0e12]">
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1 hover:text-white transition">
                                ID
                                @if (request('sort') == 'id')
                                <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1 hover:text-white transition">
                                User
                                @if (request('sort') == 'name')
                                <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Points</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1 hover:text-white transition">
                                Joined
                                @if (request('sort') == 'created_at')
                                <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider min-w-[240px]">Actions</th>
                    </tr>
                </thead>
                {{-- Table Body --}}
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4 px-4 text-sm text-gray-400">#{{ $user->id }}</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#D4AF37] text-[#0b0e12] flex items-center justify-center font-bold text-sm">
                                    {{ $user->initials ?? strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-white font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-300">{{ $user->email }}</td>
                        <td class="py-4 px-4 text-sm text-gray-400">{{ $user->phone ?? '-' }}</td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $user->role == 'admin' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}
                                {{ $user->role == 'editor' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                                {{ !$user->role || $user->role == 'user' ? 'bg-gray-500/20 text-gray-400 border border-gray-500/30' : '' }}">
                                {{ ucfirst($user->role ?? 'User') }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $user->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="text-[#D4AF37] font-bold">{{ number_format($user->total_points ?? 0) }}</span>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>

                        {{-- Actions --}}
                        <td class="py-4 px-4 min-w-[240px]">
                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                {{-- Edit --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1.5
                                          text-amber-400 bg-amber-500/10 border border-amber-500/20
                                          hover:bg-amber-500/20 hover:text-amber-300
                                          rounded-md transition-all duration-200"
                                   title="Edit User">
                                    <i class="fas fa-pen text-xs"></i>
                                    <span class="text-xs font-medium">Edit</span>
                                </a>

                                @if($user->id !== auth()->id())

                                    {{-- Toggle Form --}}
                                    <form id="toggle-form-{{ $user->id }}"
                                          action="{{ route('admin.users.toggle-status', $user->id) }}"
                                          method="POST"
                                          class="hidden">
                                        @csrf
                                    </form>

                                    {{-- Delete --}}
                                    <button type="button"
                                            onclick="confirmDelete({{ $user->id }}, @js($user->name))"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5
                                                   text-rose-400 bg-rose-500/10 border border-rose-500/20
                                                   hover:bg-rose-500/20 hover:text-rose-300
                                                   rounded-md transition-all duration-200"
                                            title="Delete User">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                        <span class="text-xs font-medium">Delete</span>
                                    </button>

                                    {{-- Delete Form --}}
                                    <form id="delete-form-{{ $user->id }}"
                                          action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center text-gray-400">
                            <i class="fas fa-users text-4xl block mb-3 opacity-20"></i>
                            <p>No users found</p>
                            <p class="text-sm text-gray-500 mt-1">Try adjusting your search filters</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if ($users->hasPages())
        <div class="px-6 py-4 border-t border-white/10">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

{{-- JavaScript --}}
<script>
    function toggleUserStatus(userId, isActive, userName) {
        const message = isActive ?
            `Are you sure you want to deactivate "${userName}"?` :
            `Are you sure you want to activate "${userName}"?`;
        if (confirm(message)) {
            const form = document.getElementById('toggle-form-' + userId);
            if (form) {
                form.submit();
            }
        }
    }

    function confirmDelete(userId, userName) {
        const message =
            `Are you sure you want to delete "${userName}"?\n\nThis action cannot be undone.`;
        if (confirm(message)) {
            const form = document.getElementById('delete-form-' + userId);
            if (form) {
                form.submit();
            }
        }
    }
</script>
@endsection