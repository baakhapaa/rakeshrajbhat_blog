@extends('admin.layouts.app')

@section('title', 'Create Quiz · Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-white/60 hover:text-white mr-4">
            ← Back to Blog
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Create Quiz for: {{ $blog->title }}</h1>
    </div>

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="blog_id" value="{{ $blog->id }}">

            <!-- Question -->
            <div class="mb-4">
                <label for="question" class="block text-white/70 text-sm font-medium mb-2">Quiz Question *</label>
                <input type="text" id="question" name="question" value="{{ old('question') }}" required
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition"
                    placeholder="e.g., What is the main topic of this blog?">
                @error('question')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options -->
            <div class="mb-4">
                <label class="block text-white/70 text-sm font-medium mb-2">Options *</label>
                <div class="space-y-3">
                    @for($i = 0; $i < 4; $i++)
                        <div class="flex items-center gap-3">
                            <span class="text-white/50 font-bold w-6">{{ chr(65 + $i) }}.</span>
                            <input type="text" name="options[]" value="{{ old('options.' . $i) }}" required
                                class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition"
                                placeholder="Option {{ chr(65 + $i) }}">
                        </div>
                    @endfor
                </div>
                @error('options')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('options.*')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correct Answer -->
            <div class="mb-6">
                <label for="correct_answer" class="block text-white/70 text-sm font-medium mb-2">Correct Answer *</label>
                <select id="correct_answer" name="correct_answer" required
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                    <option value="">Select correct answer</option>
                    <option value="0" {{ old('correct_answer') == 0 ? 'selected' : '' }}>A</option>
                    <option value="1" {{ old('correct_answer') == 1 ? 'selected' : '' }}>B</option>
                    <option value="2" {{ old('correct_answer') == 2 ? 'selected' : '' }}>C</option>
                    <option value="3" {{ old('correct_answer') == 3 ? 'selected' : '' }}>D</option>
                </select>
                @error('correct_answer')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                    Create Quiz
                </button>
                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="border border-white/20 text-white/70 px-6 py-2 rounded-lg font-semibold hover:bg-white/5 transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection