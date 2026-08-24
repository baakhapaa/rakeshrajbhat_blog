@extends('admin.layouts.app')

@section('title', 'Create Blog · Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.blogs.index') }}" class="text-white/60 hover:text-white mr-4 transition">
            ← Back
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Create New Blog</h1>
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
        <form action="{{ route('admin.blogs.store') }}" method="POST" id="blogForm" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-300 text-sm font-medium mb-2">Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                @error('title')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-gray-300 text-sm font-medium mb-2">Category</label>
                <input type="text" id="category" name="category" value="{{ old('category') }}"
                    class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                    placeholder="e.g., Technology, Education, Tourism">
                @error('category')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="mb-4">
                <label for="excerpt" class="block text-gray-300 text-sm font-medium mb-2">Excerpt (Short Description)</label>
                <textarea id="excerpt" name="excerpt" rows="3"
                    class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content with CKEditor -->
            <div class="mb-4">
                <label for="content" class="block text-gray-300 text-sm font-medium mb-2">Content *</label>
                <x-ckeditor id="content" name="content" value="{{ old('content') }}" height="600" />
                @error('content')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image Upload -->
            <div class="mb-4">
                <label for="featured_image" class="block text-gray-300 text-sm font-medium mb-2">Featured Image</label>
                
                <div class="flex gap-2 mb-4 border-b border-white/10">
                    <button type="button" onclick="switchTab('upload')" id="tabUpload" class="px-4 py-2 text-sm font-medium text-[#D4AF37] border-b-2 border-[#D4AF37] transition">
                        Upload from PC
                    </button>
                    <button type="button" onclick="switchTab('url')" id="tabUrl" class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition border-b-2 border-transparent">
                        Enter Image URL
                    </button>
                </div>

                <!-- Tab 1: Upload from PC -->
                <div id="uploadTab" class="upload-tab">
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
                    <div class="flex items-center gap-4">
                        <input type="file" id="featured_image_file" name="featured_image_file" accept="image/*"
                            class="hidden" onchange="previewImage(event)">
                        <button type="button" onclick="document.getElementById('featured_image_file').click()"
                            class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition">
                            Choose Image
                        </button>
                        <span id="fileName" class="text-white/40 text-sm">No file chosen</span>
                    </div>
                    <p class="text-xs text-white/30 mt-2">Accepted formats: JPG, PNG, GIF, WebP (Max 5MB)</p>
                </div>

                <!-- Tab 2: Enter Image URL -->
                <div id="urlTab" class="url-tab hidden">
                    <div class="flex items-center gap-4">
                        <input type="text" id="image_url_input" placeholder="https://example.com/image.jpg"
                            class="flex-1 px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                        <button type="button" onclick="setImageUrl()"
                            class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg font-semibold hover:bg-[#c4a030] transition">
                            Set URL
                        </button>
                    </div>
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
                </div>

                <input type="hidden" id="featured_image_url" name="featured_image" value="{{ old('featured_image') }}">
                @error('featured_image')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags -->
            <div class="mb-4">
                <label for="tags" class="block text-gray-300 text-sm font-medium mb-2">Tags (comma separated)</label>
                <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                    class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition" placeholder="education, technology, future">
                @error('tags')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publish -->
            <div class="mb-6">
                <label class="flex items-center text-white/70 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                        class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37] w-4 h-4">
                    <span class="text-sm font-medium">Publish immediately</span>
                </label>
                <p class="text-xs text-white/30 mt-1">If unchecked, the blog will be saved as a draft.</p>
            </div>

            <!-- Featured -->
            <div class="mb-6">
                <label class="flex items-center text-white/70 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37] w-4 h-4">
                    <span class="text-sm font-medium">⭐ Mark as Featured</span>
                </label>
                <p class="text-xs text-white/30 mt-1">Featured blogs appear on the homepage.</p>
            </div>

            <!-- ========================================== -->
            <!-- QUIZ SECTION -->
            <!-- ========================================== -->
            <div class="mt-8 pt-6 border-t border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-white">📝 Quiz Settings</h3>
                    <span class="text-xs text-white/40">Quiz is saved together with the blog</span>
                </div>
                <p class="text-white/40 text-sm mb-4">Add questions to create a quiz. Users earn points for correct answers. (<span class="text-[#D4AF37]">0 - 20000 points per question</span>)</p>
                
                <!-- Quiz Header -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="quiz_title" class="block text-gray-300 text-sm font-medium mb-2">Quiz Title *</label>
                        <input type="text" id="quiz_title" name="quiz_title" value="{{ old('quiz_title') }}"
                            class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                            placeholder="e.g., Test Your Knowledge">
                        <p class="text-xs text-white/30 mt-1">Required to create a quiz</p>
                    </div>
                    <div>
                        <label for="quiz_passing_score" class="block text-gray-300 text-sm font-medium mb-2">Passing Score (%)</label>
                        <input type="number" id="quiz_passing_score" name="quiz_passing_score" value="{{ old('quiz_passing_score', 60) }}" min="0" max="100"
                            class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                    </div>
                </div>

                <!-- Quiz Questions -->
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Questions</label>
                    
                    <div id="questionsContainer" class="space-y-3">
                        @if(old('questions'))
                            @foreach(old('questions') as $index => $question)
                                <div class="bg-[#1a1f26] rounded-lg p-4 border border-white/10 question-item" data-index="{{ $index }}">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="text-white font-medium">Question <span class="question-number">{{ $index + 1 }}</span></h4>
                                        <button type="button" onclick="removeQuestion(this)" class="text-red-400 hover:text-red-300 text-sm">
                                            ✕ Remove
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3">
                                        <input type="text" name="questions[{{ $index }}][question]" value="{{ $question['question'] ?? '' }}" placeholder="Enter your question"
                                            class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                                        <div class="grid grid-cols-2 gap-3">
                                            <input type="text" name="questions[{{ $index }}][option_1]" value="{{ $question['option_1'] ?? '' }}" placeholder="Option A"
                                                class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                                            <input type="text" name="questions[{{ $index }}][option_2]" value="{{ $question['option_2'] ?? '' }}" placeholder="Option B"
                                                class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                                            <input type="text" name="questions[{{ $index }}][option_3]" value="{{ $question['option_3'] ?? '' }}" placeholder="Option C"
                                                class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                                            <input type="text" name="questions[{{ $index }}][option_4]" value="{{ $question['option_4'] ?? '' }}" placeholder="Option D"
                                                class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="text-white/60 text-sm">Correct Answer</label>
                                                <select name="questions[{{ $index }}][correct_answer]"
                                                    class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                                                    <option value="">Select</option>
                                                    <option value="1" {{ (isset($question['correct_answer']) && $question['correct_answer'] == 1) ? 'selected' : '' }}>A</option>
                                                    <option value="2" {{ (isset($question['correct_answer']) && $question['correct_answer'] == 2) ? 'selected' : '' }}>B</option>
                                                    <option value="3" {{ (isset($question['correct_answer']) && $question['correct_answer'] == 3) ? 'selected' : '' }}>C</option>
                                                    <option value="4" {{ (isset($question['correct_answer']) && $question['correct_answer'] == 4) ? 'selected' : '' }}>D</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-white/60 text-sm">Points</label>
                                                <input type="number" name="questions[{{ $index }}][points]" value="{{ $question['points'] ?? 10 }}" min="0" max="20000"
                                                    class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                        <div class="text-center text-white/40 py-4" id="noQuestionsMsg" {{ old('questions') ? 'style="display:none"' : '' }}>
                            <p>No questions added yet. Click "Add Question" below.</p>
                        </div>
                    </div>

                    <button type="button" onclick="addQuestion()" 
                            class="mt-3 px-4 py-2 bg-blue-500/20 border border-blue-500/30 text-blue-400 rounded-lg hover:bg-blue-500/30 transition text-sm">
                        + Add Question
                    </button>
                </div>

                <!-- Quiz Description -->
                <div class="mb-4">
                    <label for="quiz_description" class="block text-gray-300 text-sm font-medium mb-2">Quiz Description (Optional)</label>
                    <textarea id="quiz_description" name="quiz_description" rows="2"
                        class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                        placeholder="Brief description of the quiz...">{{ old('quiz_description') }}</textarea>
                </div>

                <!-- Quiz Status -->
                <div>
                    <label class="flex items-center text-white/70 cursor-pointer">
                        <input type="hidden" name="quiz_is_active" value="0">
                        <input type="checkbox" name="quiz_is_active" value="1" {{ old('quiz_is_active', true) ? 'checked' : '' }}
                            class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37] w-4 h-4">
                        <span class="text-sm font-medium">Activate Quiz</span>
                    </label>
                    <p class="text-xs text-white/30 mt-1">If inactive, the quiz won't be visible to users</p>
                </div>
                
                <div class="mt-4 p-3 bg-blue-500/5 border border-blue-500/20 rounded-lg">
                    <p class="text-xs text-blue-400">
                        💡 <strong>Tip:</strong> Make sure the "Quiz Title" field is filled to save your quiz.
                        Quiz will be automatically created with your blog.
                    </p>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                    Create Blog
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
    // IMAGE UPLOAD FUNCTIONS - FIXED
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
            showToast('CSRF token not found. Please refresh the page.', 'error');
            return;
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
                showToast('Image uploaded successfully!', 'success');
            } else {
                showToast('Failed to upload image: ' + (data.message || 'Please try again.'), 'error');
            }
        })
        .catch(error => {
            console.error('Upload Error:', error);
            showToast('Error uploading image: ' + error.message, 'error');
        });
    }

    function setImageUrl() {
        const url = document.getElementById('image_url_input').value.trim();
        if (!url) {
            showToast('Please enter a valid image URL.', 'error');
            return;
        }

        try {
            new URL(url);
        } catch {
            showToast('Please enter a valid URL (e.g., https://example.com/image.jpg)', 'error');
            return;
        }

        document.getElementById('featured_image_url').value = url;
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
        const colors = { success: '#10b981', error: '#ef4444', info: '#3b82f6' };
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

    // ==========================================
    // QUIZ FUNCTIONS
    // ==========================================
    let questionCount = {{ old('questions') ? count(old('questions')) : 0 }};

    function addQuestion() {
        const container = document.getElementById('questionsContainer');
        const noMsg = document.getElementById('noQuestionsMsg');
        
        if (noMsg) {
            noMsg.style.display = 'none';
        }

        const questionHtml = `
            <div class="bg-[#1a1f26] rounded-lg p-4 border border-white/10 question-item">
                <div class="flex justify-between items-start mb-3">
                    <h4 class="text-white font-medium">Question <span class="question-number">${questionCount + 1}</span></h4>
                    <button type="button" onclick="removeQuestion(this)" class="text-red-400 hover:text-red-300 text-sm">
                        ✕ Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <input type="text" name="questions[${questionCount}][question]" placeholder="Enter your question"
                        class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="questions[${questionCount}][option_1]" placeholder="Option A"
                            class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                        <input type="text" name="questions[${questionCount}][option_2]" placeholder="Option B"
                            class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                        <input type="text" name="questions[${questionCount}][option_3]" placeholder="Option C"
                            class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                        <input type="text" name="questions[${questionCount}][option_4]" placeholder="Option D"
                            class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-white/60 text-sm">Correct Answer</label>
                            <select name="questions[${questionCount}][correct_answer]"
                                class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                                <option value="">Select</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                                <option value="4">D</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-white/60 text-sm">Points</label>
                            <input type="number" name="questions[${questionCount}][points]" value="10" min="0" max="20000"
                                class="w-full px-4 py-2 bg-[#1a1f26] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', questionHtml);
        questionCount++;
    }

    function removeQuestion(button) {
        const questionItem = button.closest('.question-item');
        const container = document.getElementById('questionsContainer');
        
        if (questionItem) {
            questionItem.remove();
            
            const remainingQuestions = container.querySelectorAll('.question-item');
            remainingQuestions.forEach((q, index) => {
                const numberSpan = q.querySelector('.question-number');
                if (numberSpan) {
                    numberSpan.textContent = index + 1;
                }
                const inputs = q.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, '[' + index + ']'));
                    }
                });
            });
            
            if (remainingQuestions.length === 0) {
                const noMsg = document.getElementById('noQuestionsMsg');
                if (noMsg) {
                    noMsg.style.display = 'block';
                }
                questionCount = 0;
            }
        }
    }

    // ==========================================
    // AUTO-SWITCH TO URL TAB IF THERE'S AN OLD IMAGE
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        @if(old('featured_image'))
            document.getElementById('featured_image_url').value = '{{ old('featured_image') }}';
            const preview = document.getElementById('urlPreview');
            const container = document.getElementById('urlPreviewContainer');
            preview.src = '{{ old('featured_image') }}';
            container.classList.remove('hidden');
            document.getElementById('image_url_input').value = '{{ old('featured_image') }}';
            switchTab('url');
        @endif
    });

    // ==========================================
    // ANIMATION STYLE
    // ==========================================
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
</script>

<style>
    /* Fix for input colors */
    input, textarea, select {
        color: #e5e7eb !important;
    }
    input::placeholder, textarea::placeholder {
        color: #6b7280 !important;
    }
    .bg-white\/5 {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }
    .border-white\/10 {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    .question-item {
        transition: all 0.2s ease;
    }
    .question-item:hover {
        border-color: rgba(212, 175, 55, 0.3);
    }
    
    /* CKEditor dark theme fixes */
    .ck-editor__editable {
        background: #1a1f26 !important;
        color: #e5e7eb !important;
        min-height: 300px !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
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
</style>
@endsection