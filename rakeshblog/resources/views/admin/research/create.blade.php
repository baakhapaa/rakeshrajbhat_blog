@extends('admin.layouts.app')

@section('title', 'Add Research · Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white flex items-center gap-3">
                <i class="fas fa-plus-circle text-[#D4AF37]"></i>
                Add Research Item
            </h1>
            <p class="text-gray-400 text-sm mt-1">Create a new research item for the homepage</p>
        </div>
        <a href="{{ route('admin.research.index') }}" class="text-gray-400 hover:text-white transition flex items-center gap-2 mt-4 md:mt-0">
            <i class="fas fa-arrow-left"></i> Back to Research
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.research.store') }}" method="POST" enctype="multipart/form-data" class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-heading text-[#D4AF37] mr-1"></i> Title *
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                @error('title')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-tag text-[#D4AF37] mr-1"></i> Category *
                </label>
                <select id="category" name="category" required class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    <option value="" class="text-gray-500">Select Category</option>
                    <option value="Vision" {{ old('category') == 'Vision' ? 'selected' : '' }}>Vision</option>
                    <option value="Research Papers" {{ old('category') == 'Research Papers' ? 'selected' : '' }}>Research Papers</option>
                    <option value="Media" {{ old('category') == 'Media' ? 'selected' : '' }}>Media</option>
                </select>
                @error('category')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Order -->
            <div>
                <label for="order" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-sort text-[#D4AF37] mr-1"></i> Order
                </label>
                <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                    class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                @error('order')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-align-left text-[#D4AF37] mr-1"></i> Description *
                </label>
                <textarea id="description" name="description" rows="3" required
                    class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition resize-none">{{ old('description') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Short description shown on the homepage</p>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Detailed Content -->
            <div class="md:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-file-alt text-[#D4AF37] mr-1"></i> Detailed Content
                </label>
                <textarea id="content" name="content" rows="5"
                    class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition resize-none">{{ old('content') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Optional detailed content for the research item</p>
                @error('content')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-image text-[#D4AF37] mr-1"></i> Image
                </label>
                <div class="relative">
                    <input type="file" id="image_url" name="image_url" accept="image/*"
                        class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#D4AF37] file:text-[#0b0e12] hover:file:bg-[#c4a030] transition cursor-pointer">
                </div>
                <p class="text-xs text-gray-500 mt-1">Max 2MB. JPG, PNG, GIF, SVG</p>
                @error('image_url')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Link URL -->
            <div>
                <label for="link_url" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-link text-[#D4AF37] mr-1"></i> Link URL
                </label>
                <input type="url" id="link_url" name="link_url" value="{{ old('link_url') }}"
                    class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                    placeholder="https://example.com">
                <p class="text-xs text-gray-500 mt-1">External link for more information</p>
                @error('link_url')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Video URL -->
            <div>
                <label for="video_url" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-video text-[#D4AF37] mr-1"></i> Video URL
                </label>
                <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                    class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                    placeholder="https://youtube.com/watch?v=...">
                <p class="text-xs text-gray-500 mt-1">YouTube, Vimeo, or other video URL</p>
                @error('video_url')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Video File Upload -->
            <div>
                <label for="video_file" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-upload text-[#D4AF37] mr-1"></i> Upload Video
                </label>
                <div class="relative">
                    <input type="file" id="video_file" name="video_file" accept="video/*"
                        class="w-full px-4 py-2.5 bg-[#0b0e12] border border-white/10 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#D4AF37] file:text-[#0b0e12] hover:file:bg-[#c4a030] transition cursor-pointer">
                </div>
                <p class="text-xs text-gray-500 mt-1">Max 100MB. MP4, AVI, MOV, WMV, FLV, WebM</p>
                @error('video_file')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Active Status -->
        <div class="mt-6 pt-6 border-t border-white/10">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-white/10 bg-[#0b0e12] text-[#D4AF37] focus:ring-[#D4AF37] focus:ring-offset-0 transition">
                <span class="ml-2 text-sm text-gray-300">
                    <i class="fas fa-check-circle text-[#D4AF37] mr-1"></i> Active
                </span>
                <span class="ml-2 text-xs text-gray-500">(Visible on homepage)</span>
            </label>
        </div>

        <!-- Featured Status -->
        <div class="mt-4">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                    class="w-4 h-4 rounded border-white/10 bg-[#0b0e12] text-[#D4AF37] focus:ring-[#D4AF37] focus:ring-offset-0 transition">
                <span class="ml-2 text-sm text-gray-300">
                    <i class="fas fa-star text-[#D4AF37] mr-1"></i> Featured
                </span>
                <span class="ml-2 text-xs text-gray-500">(Only one featured per category)</span>
            </label>
        </div>

        <!-- Form Actions -->
        <div class="mt-6 flex flex-wrap gap-4">
            <button type="submit" class="px-6 py-2.5 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2 font-medium">
                <i class="fas fa-save"></i> Create Research Item
            </button>
            <a href="{{ route('admin.research.index') }}" class="px-6 py-2.5 border border-white/20 text-white/70 rounded-lg hover:bg-white/5 hover:text-white transition flex items-center gap-2">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

<style>
/* Smooth transitions */
.transition {
    transition: all 0.2s ease;
}

/* Custom file input styling */
input[type="file"] {
    cursor: pointer;
}

input[type="file"]::file-selector-button {
    cursor: pointer;
}

/* Form input focus effects */
input:focus, select:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
}

/* Checkbox styling */
input[type="checkbox"] {
    cursor: pointer;
    accent-color: #D4AF37;
}

/* Number input arrows */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    opacity: 0.5;
}

/* Placeholder styling */
::placeholder {
    color: #6b7280;
}

/* Error message animation */
.text-red-400 {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .max-w-4xl {
        padding: 0 1rem;
    }
}
</style>