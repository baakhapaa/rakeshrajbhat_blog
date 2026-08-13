<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login · Rakesh Rajbhat</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #0b0e12 0%, #1a1f26 100%);
            font-family: 'Inter', sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .login-card:hover {
            border-color: rgba(212, 175, 55, 0.3);
        }
        .gold-text {
            color: #D4AF37;
        }
        .gold-border {
            border-color: #D4AF37;
        }
        .gold-bg {
            background-color: #D4AF37;
        }
        .gold-bg:hover {
            background-color: #c4a030;
        }
        .input-dark {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .input-dark:focus {
            border-color: #D4AF37;
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }
        .input-dark::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="login-card rounded-2xl p-8">
            <div class="text-center mb-8">
                <div class="w-20 h-20 rounded-full gold-bg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-[#0b0e12]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-serif font-bold text-white">Admin Login</h1>
                <p class="text-white/60 mt-2">Access the admin dashboard</p>
            </div>

            @if (session('status'))
                <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white/70 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 input-dark rounded-lg transition"
                        placeholder="admin@example.com">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-white/70 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 input-dark rounded-lg transition"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-white/60">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]">
                        Remember me
                    </label>
                    <a href="#" class="text-sm text-[#D4AF37] hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" class="w-full gold-bg text-[#0b0e12] py-3 rounded-lg font-semibold transition-all hover:shadow-lg hover:shadow-[#D4AF37]/20">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-white/40 hover:text-[#D4AF37] transition-colors">
                    ← Back to Website
                </a>
            </div>
        </div>

        <div class="text-center mt-6">
            <p class="text-xs text-white/30">
                &copy; {{ date('Y') }} Rakesh Rajbhat. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>