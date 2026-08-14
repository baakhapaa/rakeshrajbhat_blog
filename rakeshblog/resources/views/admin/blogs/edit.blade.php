@extends('admin.layouts.app')

@section('title', 'Edit Blog · Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.blogs.index') }}" class="text-white/60 hover:text-white mr-4">
            ← Back
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Edit Blog</h1>
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
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-white/70 text-sm font-medium mb-2">Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}" required
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('title')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-white/70 text-sm font-medium mb-2">Category</label>
                <input type="text" id="category" name="category" value="{{ old('category', $blog->category) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('category')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="mb-4">
                <label for="excerpt" class="block text-white/70 text-sm font-medium mb-2">Excerpt (Short Description)</label>
                <textarea id="excerpt" name="excerpt" rows="3"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">{{ old('excerpt', $blog->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="content" class="block text-white/70 text-sm font-medium mb-2">Content *</label>
                <x-ckeditor id="content" name="content" value="{{ old('content', html_entity_decode($blog->content)) }}" height="600" />
                @error('content')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image Upload -->
            <div class="mb-4">
                <label for="featured_image" class="block text-white/70 text-sm font-medium mb-2">Featured Image</label>
                
                <!-- Tab Navigation -->
                <div class="flex gap-2 mb-4 border-b border-white/10">
                    <button type="button" onclick="switchTab('upload')" id="tabUpload" class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition border-b-2 border-transparent">
                        Upload from PC
                    </button>
                    <button type="button" onclick="switchTab('url')" id="tabUrl" class="px-4 py-2 text-sm font-medium text-[#D4AF37] border-b-2 border-[#D4AF37] transition">
                        Enter Image URL
                    </button>
                </div>

                <!-- Tab 1: Upload from PC -->
                <div id="uploadTab" class="upload-tab hidden">
                    <!-- Current Image Preview -->
                    @if($blog->featured_image)
                        <div id="imagePreviewContainer" class="mb-3">
                            <div class="relative inline-block">
                                <img id="imagePreview" src="{{ $blog->featured_image }}" alt="Featured Image" class="w-48 h-32 object-cover rounded-lg border border-white/10">
                                <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <div id="imagePreviewContainer" class="hidden mb-3">
                            <div class="relative inline-block">
                                <img id="imagePreview" src="#" alt="Featured Image" class="w-48 h-32 object-cover rounded-lg border border-white/10">
                                <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- File Input -->
                    <div class="flex items-center gap-4">
                        <input type="file" id="featured_image_file" name="featured_image_file" accept="image/*"
                            class="hidden" onchange="previewImage(event)">
                        <button type="button" onclick="document.getElementById('featured_image_file').click()"
                            class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition">
                            Choose New Image
                        </button>
                        <span id="fileName" class="text-white/40 text-sm">No file chosen</span>
                    </div>
                    <p class="text-xs text-white/30 mt-2">Accepted formats: JPG, PNG, GIF, WebP (Max 5MB)</p>
                </div>

                <!-- Tab 2: Enter Image URL -->
                <div id="urlTab" class="url-tab">
                    <div class="flex items-center gap-4">
                        <input type="text" id="image_url_input" placeholder="https://example.com/image.jpg"
                            class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition"
                            value="{{ old('featured_image', $blog->featured_image) }}">
                        <button type="button" onclick="setImageUrl()"
                            class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg font-semibold hover:bg-[#c4a030] transition">
                            Set URL
                        </button>
                    </div>
                    
                    <!-- URL Preview -->
                    @if($blog->featured_image)
                        <div id="urlPreviewContainer" class="mt-3">
                            <div class="relative inline-block">
                                <img id="urlPreview" src="{{ $blog->featured_image }}" alt="Featured Image" class="w-48 h-32 object-cover rounded-lg border border-white/10">
                                <button type="button" onclick="removeUrlImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <div id="urlPreviewContainer" class="hidden mt-3">
                            <div class="relative inline-block">
                                <img id="urlPreview" src="#" alt="Featured Image" class="w-48 h-32 object-cover rounded-lg border border-white/10">
                                <button type="button" onclick="removeUrlImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Hidden input for image URL -->
                <input type="hidden" id="featured_image_url" name="featured_image" value="{{ old('featured_image', $blog->featured_image) }}">
                
                @error('featured_image')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags -->
            <div class="mb-4">
                <label for="tags" class="block text-white/70 text-sm font-medium mb-2">Tags (comma separated)</label>
                <input type="text" id="tags" name="tags" value="{{ old('tags', is_array($blog->tags) ? implode(', ', $blog->tags) : $blog->tags) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition" placeholder="education, technology, future">
                @error('tags')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publish -->
            <div class="mb-6">
                <label class="flex items-center text-white/70 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" 
                        {{ old('is_published', $blog->is_published ?? false) ? 'checked' : '' }}
                        class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37] w-4 h-4">
                    <span class="text-sm font-medium">Published</span>
                </label>
                @if($blog->is_published)
                    <p class="text-xs text-green-400/70 mt-1">✓ This blog is currently published and visible to the public.</p>
                @else
                    <p class="text-xs text-yellow-400/70 mt-1">⚠ This blog is currently a draft and not visible to the public.</p>
                @endif
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                    Update Blog
                </button>
                <a href="{{ route('admin.blogs.index') }}" class="border border-white/20 text-white/70 px-6 py-2 rounded-lg font-semibold hover:bg-white/5 transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // ==========================================
    // TAB SWITCHING
    // ==========================================
    function switchTab(tab) {
        const uploadTab = document.getElementById('uploadTab');
        const urlTab = document.getElementById('urlTab');
        const tabUpload = document.getElementById('tabUpload');
        const tabUrl = document.getElementById('tabUrl');
        
        if (tab === 'upload') {
            uploadTab.classList.remove('hidden');
            urlTab.classList.add('hidden');
            tabUpload.classList.add('border-[#D4AF37]', 'text-[#D4AF37]');
            tabUpload.classList.remove('border-transparent', 'text-white/60');
            tabUrl.classList.remove('border-[#D4AF37]', 'text-[#D4AF37]');
            tabUrl.classList.add('border-transparent', 'text-white/60');
        } else {
            uploadTab.classList.add('hidden');
            urlTab.classList.remove('hidden');
            tabUrl.classList.add('border-[#D4AF37]', 'text-[#D4AF37]');
            tabUrl.classList.remove('border-transparent', 'text-white/60');
            tabUpload.classList.remove('border-[#D4AF37]', 'text-[#D4AF37]');
            tabUpload.classList.add('border-transparent', 'text-white/60');
        }
    }

    // ==========================================
    // UPLOAD FROM PC
    // ==========================================
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const container = document.getElementById('imagePreviewContainer');
                preview.src = e.target.result;
                container.classList.remove('hidden');
                
                // Upload the image via AJAX
                uploadImage(file);
            };
            reader.readAsDataURL(file);
            
            document.getElementById('fileName').textContent = file.name;
        }
    }

    function removeImage() {
        document.getElementById('imagePreview').src = '#';
        document.getElementById('imagePreviewContainer').classList.add('hidden');
        document.getElementById('featured_image_file').value = '';
        document.getElementById('featured_image_url').value = '';
        document.getElementById('fileName').textContent = 'No file chosen';
    }

    function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value;

        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page.');
            return;
        }

        // Show loading state
        const btn = document.querySelector('#uploadTab button');
        const originalText = btn?.textContent;
        if (btn) {
            btn.textContent = 'Uploading...';
            btn.disabled = true;
        }

        fetch('{{ route("admin.upload-image") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(text);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('featured_image_url').value = data.path;
                console.log('Image uploaded:', data.path);
                showToast('Image uploaded successfully!', 'success');
            } else {
                showToast('Failed to upload image: ' + (data.message || 'Please try again.'), 'error');
            }
        })
        .catch(error => {
            console.error('Upload Error:', error);
            showToast('Error uploading image: ' + error.message, 'error');
        })
        .finally(() => {
            if (btn) {
                btn.textContent = originalText || 'Choose New Image';
                btn.disabled = false;
            }
        });
    }

    // ==========================================
    // ENTER IMAGE URL
    // ==========================================
    function setImageUrl() {
        const url = document.getElementById('image_url_input').value.trim();
        if (!url) {
            showToast('Please enter a valid image URL.', 'error');
            return;
        }

        // Validate URL
        try {
            new URL(url);
        } catch {
            showToast('Please enter a valid URL (e.g., https://example.com/image.jpg)', 'error');
            return;
        }

        // Set the hidden input value
        document.getElementById('featured_image_url').value = url;
        
        // Show preview
        const preview = document.getElementById('urlPreview');
        const container = document.getElementById('urlPreviewContainer');
        preview.src = url;
        container.classList.remove('hidden');
        
        showToast('Image URL set successfully!', 'success');
    }

    function removeUrlImage() {
        document.getElementById('urlPreview').src = '#';
        document.getElementById('urlPreviewContainer').classList.add('hidden');
        document.getElementById('image_url_input').value = '';
        document.getElementById('featured_image_url').value = '';
    }

    // ==========================================
    // TOAST NOTIFICATION
    // ==========================================
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            info: '#3b82f6'
        };
        toast.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 14px 24px;
            background: ${colors[type] || colors.success};
            color: white;
            border-radius: 8px;
            z-index: 9999;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease;
            max-width: 400px;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);

    // Auto-switch to URL tab if there's an existing image
    document.addEventListener('DOMContentLoaded', function() {
        @if($blog->featured_image)
            // Switch to URL tab if there's an existing image
            switchTab('url');
            
            // Set the URL input value
            document.getElementById('image_url_input').value = '{{ $blog->featured_image }}';
            document.getElementById('featured_image_url').value = '{{ $blog->featured_image }}';
            
            // Show preview
            const preview = document.getElementById('urlPreview');
            const container = document.getElementById('urlPreviewContainer');
            if (preview && container) {
                preview.src = '{{ $blog->featured_image }}';
                container.classList.remove('hidden');
            }
        @endif
    });
</script>
@endsection