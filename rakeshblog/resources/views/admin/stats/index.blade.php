@extends('admin.layouts.app')

@section('title', 'Stats · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-serif font-bold text-white">Stats</h1>
        <a href="{{ route('admin.stats.create') }}" class="bg-[#D4AF37] text-[#0b0e12] px-4 py-2 rounded-lg font-semibold hover:bg-[#c4a030] transition-all">
            + Add Stat
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5 text-left text-white/60 text-sm">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Number</th>
                    <th class="px-6 py-3">Label</th>
                    <th class="px-6 py-3">Sub Label</th>
                    <th class="px-6 py-3">Order</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stats as $stat)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="px-6 py-4 text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-white font-bold">{{ $stat->number }}</td>
                        <td class="px-6 py-4 text-white">{{ $stat->label }}</td>
                        <td class="px-6 py-4 text-white/60 text-sm">{{ $stat->sub_label ?? '-' }}</td>
                        <td class="px-6 py-4 text-white/60 text-sm">{{ $stat->order }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $stat->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ $stat->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.stats.edit', $stat) }}" class="text-[#D4AF37] hover:underline text-sm mr-3">Edit</a>
                            <form action="{{ route('admin.stats.destroy', $stat) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-white/40">
                            No stats found. Create your first stat!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection