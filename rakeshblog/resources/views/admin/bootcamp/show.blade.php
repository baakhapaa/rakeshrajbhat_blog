@extends('admin.layouts.app')

@section('title', $requestItem->org_name.' · Bootcamp')

@section('content')
@php
    $gmailReply = 'https://mail.google.com/mail/?view=cm&fs=1'
        .'&to='.rawurlencode($requestItem->contact_email)
        .'&su='.rawurlencode('Re: Bootcamp request from '.$requestItem->org_name)
        .'&authuser='.rawurlencode(config('mail.from.address'));
    $rows = [
        'Municipality / district' => $requestItem->district,
        'Contact person' => $requestItem->contact_person,
        'Phone' => $requestItem->contact_phone,
        'Expected participants' => (string) $requestItem->participants,
        'Preferred date' => optional($requestItem->preferred_date)->format('M j, Y'),
        'Who is this for?' => $requestItem->audience,
        'Requirement' => $requestItem->requirements,
    ];
@endphp
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('admin.bootcamp.requests') }}" class="text-white/50 hover:text-white text-sm">← Back to Bootcamp Requests</a>
        <form action="{{ route('admin.bootcamp.requests.destroy', $requestItem) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 text-sm px-4 py-2 rounded-lg border border-red-400/30 hover:bg-red-500/10" onclick="return confirm('Delete this request?')">Delete</button>
        </form>
    </div>

    <p class="text-[#D4AF37] text-sm font-medium mt-6 mb-2">Book a Bootcamp</p>
    <h1 class="text-3xl font-serif font-bold text-white">{{ $requestItem->org_name }}</h1>
    <p class="text-white/50 text-sm mt-2">{{ $requestItem->created_at->format('M j, Y g:i A') }}</p>

    <div class="mt-6 bg-[#1a1f26] rounded-xl border border-white/5 p-6 space-y-4">
        <div>
            <p class="text-white/40 text-xs uppercase tracking-wide mb-1">Email</p>
            <a href="{{ $gmailReply }}" target="_blank" rel="noopener noreferrer" class="text-[#D4AF37] underline decoration-[#D4AF37]/40 underline-offset-2 hover:decoration-[#D4AF37]">{{ $requestItem->contact_email }}</a>
        </div>
        @foreach($rows as $label => $value)
            @if(filled($value))
                <div>
                    <p class="text-white/40 text-xs uppercase tracking-wide mb-1">{{ $label }}</p>
                    <p class="text-white whitespace-pre-wrap">{{ $value }}</p>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
