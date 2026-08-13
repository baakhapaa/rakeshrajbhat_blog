@extends('admin.layouts.app')

@section('title', 'Edit Stat · Admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.stats.index') }}" class="text-white/60 hover:text-white mr-4">
            ← Back
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Edit Stat</h1>
    </div>

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 p-6">
        <form action="{{ route('admin.stats.update', $stat) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="number" class="block text-white/70 text-sm font-medium mb-2">Number *</label>
                <input type="text" id="number" name="number" value="{{ old('number', $stat->number) }}" required
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('number')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="label" class="block text-white/70 text-sm font-medium mb-2">Label *</label>
                <input type="text" id="label" name="label" value="{{ old('label', $stat->label) }}" required
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('label')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sub_label" class="block text-white/70 text-sm font-medium mb-2">Sub Label</label>
                <input type="text" id="sub_label" name="sub_label" value="{{ old('sub_label', $stat->sub_label) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('sub_label')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="icon" class="block text-white/70 text-sm font-medium mb-2">Icon</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon', $stat->icon) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('icon')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="order" class="block text-white/70 text-sm font-medium mb-2">Order</label>
                <input type="number" id="order" name="order" value="{{ old('order', $stat->order) }}"
                    class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:border-[#D4AF37] focus:outline-none transition">
                @error('order')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center text-white/70">
                    <input type="checkbox" name="is_active" value="1" {{ $stat->is_active ? 'checked' : '' }}
                        class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]">
                    Active
                </label>
            </div>

            <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
                Update Stat
            </button>
        </form>
    </div>
</div>
@endsection