@extends('admin.layouts.app')

@section('title', 'Projects · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white flex items-center gap-3">
                <i class="fas fa-project-diagram text-[#D4AF37]"></i>
                Projects
            </h1>
            <p class="text-gray-400 text-sm mt-1">Manage projects displayed on the frontend</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 bg-[#D4AF37] text-[#0b0e12] rounded-lg hover:bg-[#c4a030] transition flex items-center gap-2 mt-4 md:mt-0">
            <i class="fas fa-plus"></i> Add Project
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
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Project</th>
                        <th class="text-left py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Short Description</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-center py-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="py-4 px-4 text-sm text-gray-400">{{ $project->order }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#D4AF37]/10 flex items-center justify-center text-[#D4AF37]">
                                        {!! $project->icon_html !!}
                                    </div>
                                    <span class="text-white font-medium">{{ $project->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-400 max-w-xs truncate">{{ $project->short_description }}</td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $project->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" 
                                       class="p-1.5 text-yellow-400 hover:text-yellow-300 hover:bg-yellow-500/10 rounded transition" 
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.toggle-status', $project->id) }}" 
                                       class="p-1.5 text-{{ $project->is_active ? 'red' : 'green' }}-400 hover:text-{{ $project->is_active ? 'red' : 'green' }}-300 hover:bg-{{ $project->is_active ? 'red' : 'green' }}-500/10 rounded transition"
                                       title="{{ $project->is_active ? 'Deactivate' : 'Activate' }}"
                                       onclick="event.preventDefault(); if(confirm('{{ $project->is_active ? 'Deactivate' : 'Activate' }} this project?')) document.getElementById('toggle-form-{{ $project->id }}').submit();">
                                        <i class="fas fa-{{ $project->is_active ? 'pause' : 'play' }} text-sm"></i>
                                    </a>
                                    <form id="toggle-form-{{ $project->id }}" action="{{ route('admin.projects.toggle-status', $project->id) }}" method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                    <button onclick="if(confirm('Delete project "{{ $project->name }}"?')) document.getElementById('delete-form-{{ $project->id }}').submit();" 
                                            class="p-1.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded transition"
                                            title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                    <form id="delete-form-{{ $project->id }}" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                <i class="fas fa-project-diagram text-5xl block mb-4 text-white/10"></i>
                                <p class="text-lg font-medium">No projects added yet</p>
                                <p class="text-sm text-gray-500 mt-1">Click "Add Project" to get started</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection