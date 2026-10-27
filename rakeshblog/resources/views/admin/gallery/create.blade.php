@extends('admin.layouts.app')

@section('title', 'Add gallery collection · Admin')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.gallery.index') }}" class="text-white/60 hover:text-white mr-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h1 class="text-3xl font-serif font-bold text-white">Add collection</h1>
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
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-gray-300 text-sm font-medium mb-2">Collection title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required maxlength="120"
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 placeholder:text-gray-500 focus:border-[#D4AF37] focus:outline-none transition"
                           placeholder="Community visits">
                    <p class="text-xs text-gray-400 mt-1">This title is shared by every photograph in the collection.</p>
                </div>

                @include('admin.gallery.partials.picker')

                <div>
                    <label for="order" class="block text-gray-300 text-sm font-medium mb-2">Display order</label>
                    <input type="number" id="order" name="order" min="0" value="{{ old('order', $nextOrder) }}"
                           class="w-full px-4 py-2 bg-[#0b0e12] border border-white/10 rounded-lg text-gray-200 focus:border-[#D4AF37] focus:outline-none transition">
                </div>

                <div>
                    <label class="flex items-center text-white/70">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="mr-2 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]">
                        <span class="text-sm font-medium">Show on the homepage</span>
                    </label>
                </div>

                <div class="flex gap-4 pt-4 border-t border-white/10">
                    <button type="submit" class="bg-[#D4AF37] text-[#0b0e12] px-6 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all flex items-center gap-2">
                        <i class="fas fa-save"></i> Create collection
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="border border-white/20 text-white/70 px-6 py-2 rounded-lg font-semibold hover:bg-white/5 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
