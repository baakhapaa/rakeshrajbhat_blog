@extends('admin.layouts.app')

@section('title', 'Edit User · Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-white/60 hover:text-white mr-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Edit User</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                </div>

                <div>
                    <label for="email" class="block text-gray-300 text-sm font-medium mb-2">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                </div>

                <div>
                    <label for="phone" class="block text-gray-300 text-sm font-medium mb-2">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                           placeholder="+977 123-456-7890">
                </div>

                <div>
                    <label for="role" class="block text-gray-300 text-sm font-medium mb-2">Role</label>
                    <select id="role" name="role" class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center text-white/70">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                               class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]">
                        <span class="text-sm font-medium">Active</span>
                    </label>
                    <p class="text-xs text-white/30 mt-1">Inactive users cannot log in</p>
                </div>

                <div class="border-t border-white/10 pt-4">
                    <p class="text-sm text-gray-400 mb-3">Change Password (leave blank to keep current)</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-gray-300 text-sm font-medium mb-2">New Password</label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-gray-300 text-sm font-medium mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                        <i class="fas fa-save mr-2"></i> Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="border border-white/20 text-white/70 px-6 py-2 rounded-lg font-semibold hover:bg-white/5 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection