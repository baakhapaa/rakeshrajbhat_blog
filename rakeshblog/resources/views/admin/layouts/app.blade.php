<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin · Rakesh Rajbhat')</title>
    @include('partials.favicon')
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Editor -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@8.8.2/tinymce.min.js"></script>
    
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

        .tox-tinymce {
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 0.5rem;
        }
        .tox .tox-toolbar__primary,
        .tox .tox-toolbar-overlord,
        .tox .tox-edit-area__iframe {
            background: #0f1419;
        }
        .messages-summary::-webkit-details-marker {
            display: none;
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
                        
                        <!-- Profile Picture / Avatar -->
                        @php
                            $admin = Auth::guard('admin')->user();
                            $avatar = $admin->profile_pic ?? null;
                            $initial = strtoupper(substr($admin->name, 0, 1));
                        @endphp
                        
                        @if($avatar)
                            <img src="{{ $avatar }}" alt="{{ $admin->name }}" 
                                class="w-8 h-8 rounded-full object-cover border-2 border-[#D4AF37]">
                        @else
                            <div class="w-8 h-8 rounded-full gold-bg text-[#0b0e12] flex items-center justify-center font-bold text-sm">
                                {{ $initial }}
                            </div>
                        @endif
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
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobileMenuToggle');
            const mobileDrawer = document.getElementById('mobileDrawer');
            const drawerOverlay = document.getElementById('drawerOverlay');

            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    mobileDrawer.classList.remove('hidden');
                });
            }

            if (drawerOverlay) {
                drawerOverlay.addEventListener('click', function() {
                    mobileDrawer.classList.add('hidden');
                });
            }

            // Close drawer on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    mobileDrawer.classList.add('hidden');
                }
            });
        });

        function fitEditorToSlot(editor) {
            const element = editor.getElement && editor.getElement();
            const slot = element && element.closest('[data-editor-slot]');
            if (!slot) return;
            const height = Math.floor(slot.getBoundingClientRect().height);
            if (height < 160) return;
            const container = editor.getContainer();
            if (!container) return;
            container.style.width = '100%';
            container.style.height = height + 'px';
        }

        window.resizePageEditors = function () {
            if (!window.tinymce) return;
            const editors = tinymce.get() || [];
            editors.forEach(fitEditorToSlot);
        };

        if (!window.__editorResizeBound) {
            window.__editorResizeBound = true;
            window.addEventListener('resize', window.resizePageEditors);
        }

        function initCKEditor(selector = '#content', config = {}) {
            const element = document.querySelector(selector);
            if (!element || typeof tinymce === 'undefined' || tinymce.get(element.id)) {
                return;
            }

            const fullHeight = config.height === 'full';

            tinymce.init({
                selector: selector,
                base_url: 'https://cdn.jsdelivr.net/npm/tinymce@8.8.2',
                suffix: '.min',
                license_key: 'gpl',
                width: '100%',
                height: fullHeight ? 480 : (Number(config.height) || 500),
                menubar: false,
                branding: false,
                promotion: false,
                statusbar: !fullHeight,
                skin: 'oxide-dark',
                toolbar_mode: 'wrap',
                plugins: 'lists link image table media',
                toolbar: 'blocks | bold italic underline strikethrough | fontsize forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image blockquote table media | undo redo',
                block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4',
                font_size_formats: '12px 14px 16px 18px 20px 24px 28px 32px',
                content_style: [
                    'body { background:#1a1f26; color:#e5e7eb; font-family: Inter, Helvetica, Arial, sans-serif; font-size:16px; line-height:1.6; margin:1rem; }',
                    'h1,h2,h3,h4 { color:#f8fafc; font-weight:700; line-height:1.25; margin:0.75em 0 0.35em; }',
                    'h1 { font-size:2rem; } h2 { font-size:1.5rem; } h3 { font-size:1.25rem; } h4 { font-size:1.1rem; }',
                    'a { color:#D4AF37; }',
                    'ul,ol { padding-left:1.4rem; }',
                    'blockquote { border-left:3px solid #D4AF37; margin-left:0; padding-left:1rem; color:#d1d5db; }'
                ].join(' '),
                setup: function (editor) {
                    editor.on('init', function () {
                        window.editor = editor;
                        if (fullHeight) fitEditorToSlot(editor);
                    });
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>