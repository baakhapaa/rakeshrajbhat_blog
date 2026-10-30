<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BootcampRequest;
use App\Models\Setting;
use App\Support\BootcampPage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BootcampController extends Controller
{
    public function edit()
    {
        return view('admin.bootcamp.edit', [
            'page' => BootcampPage::content(),
            'icons' => BootcampPage::ICONS,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_kicker' => ['nullable', 'string', 'max:40'],
            'hero_heading' => ['nullable', 'string', 'max:160'],
            'hero_intro' => ['nullable', 'string', 'max:400'],
            'process_label' => ['nullable', 'string', 'max:80'],
            'process_heading' => ['nullable', 'string', 'max:120'],
            'steps' => ['nullable', 'array', 'max:8'],
            'steps.*.title' => ['nullable', 'string', 'max:80'],
            'steps.*.body' => ['nullable', 'string', 'max:200'],
            'expertise_label' => ['nullable', 'string', 'max:80'],
            'expertise_heading' => ['nullable', 'string', 'max:120'],
            'offerings' => ['nullable', 'array', 'max:8'],
            'offerings.*.icon' => ['nullable', 'string', Rule::in(array_keys(BootcampPage::ICONS))],
            'offerings.*.kicker' => ['nullable', 'string', 'max:40'],
            'offerings.*.title' => ['nullable', 'string', 'max:40'],
            'audiences' => ['nullable', 'array', 'max:12'],
            'audiences.*.label' => ['nullable', 'string', 'max:60'],
        ]);

        Setting::setValue('bootcamp_page', Setting::encodeJson(BootcampPage::normalize($validated)));

        return back()->with('success', 'Bootcamp page saved. The public page now uses this content.');
    }

    public function requests(Request $request)
    {
        $status = $request->query('status', 'all');

        if (! in_array($status, ['all', 'read', 'unread'], true)) {
            $status = 'all';
        }

        $requests = BootcampRequest::query()
            ->when($status === 'read', fn ($query) => $query->whereNotNull('read_at'))
            ->when($status === 'unread', fn ($query) => $query->whereNull('read_at'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.bootcamp.requests', [
            'requests' => $requests,
            'status' => $status,
        ]);
    }

    public function show(BootcampRequest $bootcampRequest)
    {
        if ($bootcampRequest->read_at === null) {
            $bootcampRequest->forceFill(['read_at' => now()])->save();
        }

        return view('admin.bootcamp.show', [
            'requestItem' => $bootcampRequest,
        ]);
    }

    public function destroy(Request $request, BootcampRequest $bootcampRequest)
    {
        $bootcampRequest->delete();

        $status = $request->input('status');

        return redirect()
            ->route('admin.bootcamp.requests', in_array($status, ['read', 'unread'], true) ? ['status' => $status] : [])
            ->with('success', 'Bootcamp request deleted.');
    }
}
