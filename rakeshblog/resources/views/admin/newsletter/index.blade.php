@extends('admin.layouts.app')

@section('title', 'Newsletter · Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-3xl font-serif font-bold text-white">Newsletter</h1>
        <div class="flex items-center gap-4">
            <span class="text-white/60 text-sm">Total: {{ $subscribers->total() }}</span>
            <a href="{{ route('admin.newsletter.export', $status === 'all' ? [] : ['status' => $status]) }}"
                class="px-4 py-2 rounded-lg bg-[#D4AF37] text-[#0b0e12] text-sm font-medium hover:bg-[#c4a030] transition">
                Export emails
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach(['all' => 'All', 'confirmed' => 'Confirmed', 'pending' => 'Pending', 'unsubscribed' => 'Unsubscribed'] as $value => $label)
            <a href="{{ route('admin.newsletter.index', $value === 'all' ? [] : ['status' => $value]) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $status === $value ? 'bg-[#D4AF37] text-[#0b0e12]' : 'bg-white/5 text-white/70 hover:text-white' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-[#1a1f26] rounded-xl border border-white/5 overflow-hidden">
        @if($subscribers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/5 text-left text-white/60 text-sm">
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Consented</th>
                            <th class="px-6 py-3">Confirmed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscribers as $subscriber)
                            @php
                                $subscriberStatus = $subscriber->status();
                            @endphp
                            <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-white">{{ $subscriber->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($subscriberStatus === 'confirmed')
                                        <span class="text-green-400">Confirmed</span>
                                    @elseif($subscriberStatus === 'pending')
                                        <span class="text-[#D4AF37]">Pending</span>
                                    @else
                                        <span class="text-white/40">Unsubscribed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-white/60 text-sm">
                                    {{ $subscriber->consented_at?->format('M d, Y') ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-white/60 text-sm">
                                    {{ $subscriber->confirmed_at?->format('M d, Y') ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/5">
                {{ $subscribers->links() }}
            </div>
        @else
            <div class="p-6 text-center text-white/40 py-12">
                <p>
                    @if($status === 'confirmed')
                        No confirmed subscribers.
                    @elseif($status === 'pending')
                        No pending subscribers.
                    @elseif($status === 'unsubscribed')
                        No unsubscribed emails.
                    @else
                        No newsletter subscribers yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
