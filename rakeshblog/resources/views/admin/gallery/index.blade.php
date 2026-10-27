@extends('admin.layouts.app')

@section('title', 'Gallery · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white flex items-center gap-3">
                <i class="fas fa-images text-[#D4AF37]"></i>
                Gallery
            </h1>
            <p class="text-gray-400 text-sm mt-1">Collections shown on the homepage. Each collection has one title and its photographs.</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2 mt-4 md:mt-0">
            <i class="fas fa-plus"></i> Add collection
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-[#0b0e12]">
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Order</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Collection</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Photographs</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($collections as $collection)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="py-4 px-4 text-sm text-gray-400">{{ $collection->order }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    @if($collection->images->first())
                                        <img src="{{ $collection->images->first()->url }}" alt="" class="w-14 h-10 rounded object-cover bg-white/5">
                                    @else
                                        <div class="w-14 h-10 rounded bg-white/5"></div>
                                    @endif
                                    <span class="text-white font-medium">{{ $collection->title }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center text-sm text-gray-300">{{ $collection->images_count }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $collection->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                    {{ $collection->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.gallery.edit', $collection) }}" class="p-1.5 text-yellow-400 hover:text-yellow-300 hover:bg-yellow-500/10 rounded transition" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button type="button" onclick="event.preventDefault(); if(confirm('{{ $collection->is_active ? 'Hide' : 'Show' }} this collection on the homepage?')) document.getElementById('toggle-form-{{ $collection->id }}').submit();" class="p-1.5 text-gray-300 hover:text-white hover:bg-white/10 rounded transition" title="{{ $collection->is_active ? 'Hide' : 'Show' }}">
                                        <i class="fas fa-{{ $collection->is_active ? 'eye-slash' : 'eye' }} text-sm"></i>
                                    </button>
                                    <form id="toggle-form-{{ $collection->id }}" action="{{ route('admin.gallery.toggle-status', $collection) }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                    <button type="button" onclick="event.preventDefault(); if(confirm('Delete this collection and its photographs?')) document.getElementById('delete-form-{{ $collection->id }}').submit();" class="p-1.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded transition" title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                    <form id="delete-form-{{ $collection->id }}" action="{{ route('admin.gallery.destroy', $collection) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400">No collections yet. Add one to start the gallery.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
