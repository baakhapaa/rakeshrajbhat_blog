@extends('admin.layouts.app')

@section('title', 'Bootcamp Requests · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-serif font-bold text-white">Bootcamp Requests</h1>
            <p class="text-gray-400 text-sm mt-1">Messages sent from the Book a Bootcamp form.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-white/60 text-sm">Total: {{ $requests->total() }}</span>
            <a href="{{ route('admin.bootcamp.edit') }}" class="px-4 py-2 text-sm text-white/80 border border-white/10 rounded-lg hover:text-white">Edit page</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-5 py-4 rounded-2xl mb-6">{{ session('success') }}</div>
    @endif

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach(['all' => 'All', 'unread' => 'Unread', 'read' => 'Read'] as $value => $label)
            <a href="{{ route('admin.bootcamp.requests', $value === 'all' ? [] : ['status' => $value]) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $status === $value ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/70 hover:text-white' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/5 text-left text-white/60 text-sm">
                            <th class="px-6 py-3">Organization</th>
                            <th class="px-6 py-3">Contact</th>
                            <th class="px-6 py-3">Audience</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $item)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-white {{ $item->read_at === null ? 'font-semibold' : '' }}">
                                    {{ $item->org_name }}
                                    <span class="block text-xs text-white/40 font-normal">{{ $item->district }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-white/80">
                                    {{ $item->contact_person }}
                                    <span class="block text-xs text-[#D4AF37]">{{ $item->contact_email }}</span>
                                </td>
                                <td class="px-6 py-4 text-white/70 text-sm">{{ $item->audience ?: '—' }}</td>
                                <td class="px-6 py-4 text-white/60 text-sm">
                                    {{ $item->created_at->format('M d, Y') }}
                                    <span class="block text-xs text-white/30">{{ $item->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.bootcamp.requests.show', $item) }}" class="text-[#D4AF37] hover:underline text-sm"><i class="fa-solid fa-eye"></i> Open</a>
                                    <form action="{{ route('admin.bootcamp.requests.destroy', $item) }}" method="POST" class="inline ml-3">
                                        @csrf
                                        @method('DELETE')
                                        @if($status !== 'all')
                                            <input type="hidden" name="status" value="{{ $status }}">
                                        @endif
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm" onclick="return confirm('Delete this request?')"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/5">
                {{ $requests->links() }}
            </div>
        @else
            <div class="p-6 text-center text-white/40 py-12">
                @if($status === 'unread')
                    No unread bootcamp requests.
                @elseif($status === 'read')
                    No read bootcamp requests.
                @else
                    No bootcamp requests yet.
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
