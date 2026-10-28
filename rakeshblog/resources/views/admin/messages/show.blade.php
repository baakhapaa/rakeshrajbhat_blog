@extends('admin.layouts.app')

@section('title', $message->name.' · Messages')

@section('content')
@php
    $listRoute = $message->channel === \App\Models\SiteMessage::CHANNEL_WORK ? 'admin.messages.work' : 'admin.messages.contact';
    $listLabel = $message->channel === \App\Models\SiteMessage::CHANNEL_WORK ? 'Work Message' : 'Contact Message';
@endphp
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route($listRoute) }}" class="text-white/50 hover:text-white text-sm">← Back to {{ $listLabel }}</a>
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 text-sm px-4 py-2 rounded-lg border border-red-400/30 hover:bg-red-500/10" onclick="return confirm('Delete this message?')">Delete</button>
        </form>
    </div>

    <p class="text-[#D4AF37] text-sm font-medium mt-6 mb-2">
        {{ $message->channel === \App\Models\SiteMessage::CHANNEL_WORK ? 'Work With Me' : 'Contact Me' }}
    </p>
    <h1 class="text-3xl font-serif font-bold text-white">{{ $message->name }}</h1>
    <p class="text-white/50 text-sm mt-2">{{ $message->subject }} · {{ $message->created_at->format('M j, Y g:i A') }}</p>

    <div class="mt-6 bg-[#1a1f26] rounded-xl border border-white/5 p-6 space-y-4">
        <div>
            <p class="text-white/40 text-xs uppercase tracking-wide mb-1">Email</p>
            @php
                $gmailReply = 'https://mail.google.com/mail/?view=cm&fs=1'
                    .'&to='.rawurlencode($message->email)
                    .'&su='.rawurlencode('Re: '.$message->subject)
                    .'&authuser='.rawurlencode(config('mail.from.address'));
            @endphp
            <a href="{{ $gmailReply }}" target="_blank" rel="noopener noreferrer" title="Reply in Gmail as {{ config('mail.from.address') }}" class="text-[#D4AF37] underline decoration-[#D4AF37]/40 underline-offset-2 hover:decoration-[#D4AF37]">{{ $message->email }}</a>
        </div>
        @if($message->phone)
            <div>
                <p class="text-white/40 text-xs uppercase tracking-wide mb-1">Phone</p>
                <p class="text-white">{{ $message->phone }}</p>
            </div>
        @endif
        @foreach($message->detailRows() as $row)
            @continue($row['label'] === 'Phone' && $message->phone)
            <div>
                <p class="text-white/40 text-xs uppercase tracking-wide mb-1">{{ $row['label'] }}</p>
                <p class="text-white whitespace-pre-wrap">{{ $row['value'] }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
