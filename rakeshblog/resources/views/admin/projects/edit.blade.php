@extends('admin.layouts.app')

@section('title', 'Edit Project · Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.projects.index') }}" class="text-white/60 hover:text-white mr-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Edit Project</h1>
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
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Project Name -->
                <div>
                    <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Project Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition">
                </div>

                <!-- Project Image -->
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Project Image</label>
                    
                    @if($project->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" 
                                 class="w-32 h-32 object-cover rounded-lg border border-white/10">
                            <p class="text-xs text-gray-400 mt-1">Current image</p>
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-white/10 border-dashed rounded-lg cursor-pointer bg-[#0b0e12] hover:bg-[#0b0e12]/80 transition group">
                            <div id="uploadPlaceholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-500 group-hover:text-[#D4AF37] transition mb-2"></i>
                                <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP (Max 5MB)</p>
                            </div>
                            <img id="imagePreview" class="hidden w-full h-48 object-cover rounded-lg" alt="Project Image Preview">
                            <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                        </label>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Upload a square image (recommended: 200x200px). Leave empty to keep current.</p>
                    @error('image')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Short Description -->
                <div>
                    <label for="short_description" class="block text-gray-300 text-sm font-medium mb-2">Short Description *</label>
                    <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $project->short_description) }}" required
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                           placeholder="Brief tagline about the project">
                </div>

                <!-- Full Description -->
                <div>
                    <label for="description" class="block text-gray-300 text-sm font-medium mb-2">Full Description (Popup Content)</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                        placeholder="Detailed description that will appear in the popup...">{{ old('description', $project->description) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">This will appear when users hover over the project card</p>
                </div>

                <!-- Website URL -->
                <div>
                    <label for="url" class="block text-gray-300 text-sm font-medium mb-2">Website URL</label>
                    <input type="url" id="url" name="url" value="{{ old('url', $project->url) }}"
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                           placeholder="https://example.com">
                </div>

                <!-- Color and Order -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="color" class="block text-gray-300 text-sm font-medium mb-2">Color</label>
                        <input type="color" id="color" name="color" value="{{ old('color', $project->color) }}"
                               class="w-full h-12 bg-[#0b0e12] border border-white/10 rounded-lg cursor-pointer">
                    </div>
                    <div>
                        <label for="order" class="block text-gray-300 text-sm font-medium mb-2">Display Order</label>
                        <input type="number" id="order" name="order" value="{{ old('order', $project->order) }}"
                               class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                    </div>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center text-white/70">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }}
                               class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]">
                        <span class="text-sm font-medium">Active</span>
                    </label>
                    <p class="text-xs text-white/30 mt-1">Inactive projects won't appear on the frontend</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all flex items-center gap-2">
                        <i class="fas fa-save"></i> Update Project
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="border border-white/20 text-white/70 px-6 py-2 rounded-lg font-semibold hover:bg-white/5 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // If there's an existing image, show it in preview
    document.addEventListener('DOMContentLoaded', function() {
        @if($project->image)
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            preview.src = "{{ asset('storage/' . $project->image) }}";
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        @endif
    });
</script>

<style>
    .border-dashed {
        border-style: dashed;
    }
    
    label:hover .fa-cloud-upload-alt {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
    }
    
    #imagePreview {
        transition: all 0.3s ease;
    }
</style>
@endsection