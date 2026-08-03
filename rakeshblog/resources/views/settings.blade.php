@extends('layouts.app')

@section('title', 'Settings · Rakesh Rajbhat')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#f2f2f2] text-[#1e1e1a]">
    <div class="max-w-4xl mx-auto px-6">
    
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Settings Header -->
            <div class="bg-gradient-to-r from-[#D4AF37] to-[#c4a030] px-8 py-8">
                <h1 class="text-3xl font-serif font-bold text-white">Account Settings</h1>
                <p class="text-white/80 mt-1">Manage your account preferences and security</p>
            </div>

            <!-- Settings Content -->
            <div class="p-8">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Update Profile Form -->
                <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <h2 class="text-xl font-bold mb-4">Personal Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition">
                        </div>
                    </div>

                    <hr class="border-gray-200 my-6">

                    <h2 class="text-xl font-bold mb-4">Change Password</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"
                                placeholder="Enter your current password">
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" id="new_password" name="new_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"
                                placeholder="Enter new password (min 8 characters)">
                        </div>
                        
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition"
                                placeholder="Confirm your new password">
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-3 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                            Save Changes
                        </button>
                        <a href="{{ route('profile') }}" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-all">
                            Cancel
                        </a>
                    </div>
                </form>

                <!-- Danger Zone -->
                <div class="mt-12 pt-6 border-t-2 border-red-200">
                    <h3 class="text-lg font-bold text-red-600 mb-4">Danger Zone</h3>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <p class="text-sm text-red-700 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                        <form action="{{ route('account.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition-all">
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection