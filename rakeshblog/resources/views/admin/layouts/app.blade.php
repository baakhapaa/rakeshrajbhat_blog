<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin · Rakesh Rajbhat')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            background: #0b0e12;
            font-family: 'Inter', sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
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
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0b0e12;
        }
        ::-webkit-scrollbar-thumb {
            background: #D4AF37;
            border-radius: 3px;
        }
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background: rgba(212, 175, 55, 0.05);
            color: #D4AF37;
        }
        .sidebar-link.active {
            background: rgba(212, 175, 55, 0.1);
            color: #D4AF37;
            border-right: 2px solid #D4AF37;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-[#0f1419] border-r border-white/5 flex-shrink-0 overflow-y-auto">
            @include('admin.partials.sidebar')
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-[#0f1419] border-b border-white/5 px-6 py-4 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Mobile menu button -->
                        <button type="button" id="mobileMenuToggle" class="lg:hidden text-white/70 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-xl font-semibold text-white">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-white/60 hidden sm:block">Welcome, {{ Auth::guard('admin')->user()->name }}</span>
                        <div class="w-8 h-8 rounded-full gold-bg text-[#0b0e12] flex items-center justify-center font-bold">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Drawer -->
    <div id="mobileDrawer" class="fixed inset-0 z-50 hidden">
        <!-- Overlay -->
        <div id="drawerOverlay" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <!-- Drawer -->
        <div class="absolute top-0 left-0 h-full w-72 bg-[#0f1419] shadow-2xl overflow-y-auto">
            @include('admin.partials.sidebar')
        </div>
    </div>

    <script>
        // Mobile drawer toggle
        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            document.getElementById('mobileDrawer').classList.remove('hidden');
        });

        document.getElementById('drawerOverlay').addEventListener('click', function() {
            document.getElementById('mobileDrawer').classList.add('hidden');
        });

        // Close drawer on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('mobileDrawer').classList.add('hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>