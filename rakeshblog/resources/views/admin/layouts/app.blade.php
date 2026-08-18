<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin · Rakesh Rajbhat')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    
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

        /* CKEditor Dark Theme Overrides */
        .ck-editor__editable {
            min-height: 300px !important;
            background: #1a1f26 !important;
            color: #e5e7eb !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .ck-editor__editable p {
            color: #e5e7eb !important;
        }
        .ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .ck.ck-editor__main > .ck-editor__editable.ck-focused {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 1px #D4AF37 !important;
        }
        .ck.ck-toolbar {
            background: #0f1419 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .ck.ck-toolbar .ck-button {
            color: #e5e7eb !important;
        }
        .ck.ck-toolbar .ck-button:hover {
            background: rgba(212, 175, 55, 0.1) !important;
        }
        .ck.ck-toolbar .ck-button.ck-on {
            background: rgba(212, 175, 55, 0.2) !important;
            color: #D4AF37 !important;
        }
        .ck.ck-dropdown .ck-dropdown__panel {
            background: #1a1f26 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .ck.ck-list__item .ck-button {
            color: #e5e7eb !important;
        }
        .ck.ck-list__item .ck-button:hover {
            background: rgba(212, 175, 55, 0.1) !important;
        }
        .ck.ck-list__item .ck-button.ck-on {
            background: rgba(212, 175, 55, 0.2) !important;
            color: #D4AF37 !important;
        }
        .ck.ck-input {
            background: #0f1419 !important;
            color: #e5e7eb !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .ck.ck-input:focus {
            border-color: #D4AF37 !important;
        }
        .ck.ck-labeled-field-view__status {
            color: #e5e7eb !important;
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

        // CKEditor Initialization Function (to be called on pages with editor)
        function initCKEditor(selector = '#content', config = {}) {
            const element = document.querySelector(selector);
            if (!element) return;

            const defaultConfig = {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'alignment', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'imageUpload', '|',
                        'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        'undo', 'redo'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                },
                language: 'en',
                height: 500,
                removePlugins: ['Title'],
                ...config
            };

            ClassicEditor
                .create(element, defaultConfig)
                .then(editor => {
                    console.log('CKEditor initialized successfully');
                    window.editor = editor;
                })
                .catch(error => {
                    console.error('CKEditor Error:', error);
                });
        }
    </script>
    
    @stack('scripts')
</body>
</html>