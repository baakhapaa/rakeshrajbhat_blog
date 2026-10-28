<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request, string $channel)
    {
        abort_unless(in_array($channel, [SiteMessage::CHANNEL_CONTACT, SiteMessage::CHANNEL_WORK], true), 404);

        $status = $request->query('status', 'all');
        if (! in_array($status, ['all', 'read', 'unread'], true)) {
            $status = 'all';
        }

        $messages = SiteMessage::query()
            ->where('channel', $channel)
            ->when($status === 'read', fn ($query) => $query->whereNotNull('read_at'))
            ->when($status === 'unread', fn ($query) => $query->whereNull('read_at'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'channel' => $channel,
            'status' => $status,
        ]);
    }

    public function show(SiteMessage $message)
    {
        if ($message->read_at === null) {
            $message->forceFill(['read_at' => now()])->save();
        }

        return view('admin.messages.show', [
            'message' => $message,
        ]);
    }

    public function destroy(Request $request, SiteMessage $message)
    {
        $route = $message->channel === SiteMessage::CHANNEL_WORK
            ? 'admin.messages.work'
            : 'admin.messages.contact';

        $message->delete();

        $status = $request->input('status');

        return redirect()
            ->route($route, in_array($status, ['read', 'unread'], true) ? ['status' => $status] : [])
            ->with('success', 'Message deleted.');
    }
}
