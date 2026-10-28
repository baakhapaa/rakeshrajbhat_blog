@extends('admin.layouts.app')

@php
    $isWork = $channel === \App\Models\SiteMessage::CHANNEL_WORK;
    $title = $isWork ? 'Work Message' : 'Contact Message';
@endphp

@section('title', $title.' · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-3xl font-serif font-bold text-white">{{ $title }}</h1>
        <span class="text-white/60 text-sm">Total: {{ $messages->total() }}</span>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach(['all' => 'All', 'unread' => 'Unread', 'read' => 'Read'] as $value => $label)
            <a href="{{ route($isWork ? 'admin.messages.work' : 'admin.messages.contact', $value === 'all' ? [] : ['status' => $value]) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $status === $value ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/70 hover:text-white' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        @if($messages->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/5 text-left text-white/60 text-sm">
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">{{ $isWork ? 'Type' : 'Subject' }}</th>
                            @if($isWork)
                                <th class="px-6 py-3">Phone</th>
                            @else
                                <th class="px-6 py-3">Message</th>
                            @endif
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $item)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-white {{ $item->read_at === null ? 'font-semibold' : '' }}">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $gmailReply = 'https://mail.google.com/mail/?view=cm&fs=1'
                                            .'&to='.rawurlencode($item->email)
                                            .'&su='.rawurlencode('Re: '.$item->subject)
                                            .'&authuser='.rawurlencode(config('mail.from.address'));
                                    @endphp
                                    <a href="{{ $gmailReply }}" target="_blank" rel="noopener noreferrer"
                                        class="group/mail inline-block text-[#D4AF37]">
                                        <span class="underline decoration-[#D4AF37]/40 underline-offset-2 group-hover/mail:decoration-[#D4AF37]">{{ $item->email }}</span>
                                        <span class="mt-1 hidden max-w-[16rem] text-xs font-normal leading-snug text-white/50 group-hover/mail:block">Reply in Gmail as {{ config('mail.from.address') }}</span>
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-white/80 text-sm">{{ $item->subject }}</td>
                                @if($isWork)
                                    <td class="px-6 py-4 text-white/70 text-sm">{{ $item->phone ?: '—' }}</td>
                                @else
                                    <td class="px-6 py-4 text-white/70 text-sm">{{ Str::limit($item->details['message'] ?? '', 80) }}</td>
                                @endif
                                <td class="px-6 py-4 text-white/60 text-sm">
                                    {{ $item->created_at->format('M d, Y') }}
                                    <span class="block text-xs text-white/30">{{ $item->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.messages.show', $item) }}" class="text-[#D4AF37] hover:underline text-sm badge badge-outline badge-primary"><i class="fa-solid fa-eye"></i> Open</a>
                                    <form action="{{ route('admin.messages.destroy', $item) }}" method="POST" class="inline ml-3">
                                        @csrf
                                        @method('DELETE')
                                        @if($status !== 'all')
                                            <input type="hidden" name="status" value="{{ $status }}">
                                        @endif
                                        <button type="submit" name="delete" class="text-red-400 hover:text-red-300 text-sm" onclick="return confirm('Delete this message?')"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/5">
                {{ $messages->links() }}
            </div>
        @else
            <div class="p-6 text-center text-white/40 py-12">
                <p>
                    @if($status === 'unread')
                        No unread messages.
                    @elseif($status === 'read')
                        No read messages.
                    @else
                        No {{ strtolower($title) }}s yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
