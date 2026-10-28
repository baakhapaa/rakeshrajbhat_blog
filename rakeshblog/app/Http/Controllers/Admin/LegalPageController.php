<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\RichText;
use Illuminate\Http\Request;

class LegalPageController extends Controller
{
    public function edit()
    {
        return view('admin.legal.edit', [
            'privacy' => Setting::getLegalPage('privacy'),
            'terms' => Setting::getLegalPage('terms'),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'privacy_title' => 'required|string|max:160',
            'privacy_meta_description' => 'nullable|string|max:300',
            'privacy_updated_on' => 'nullable|date',
            'privacy_body' => 'nullable|string|max:200000',
            'terms_title' => 'required|string|max:160',
            'terms_meta_description' => 'nullable|string|max:300',
            'terms_updated_on' => 'nullable|date',
            'terms_body' => 'nullable|string|max:200000',
        ]);

        $this->store('privacy', $validated);
        $this->store('terms', $validated);

        return redirect()->route('admin.legal.edit')->with('success', 'Privacy policy and terms were updated.');
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function store(string $page, array $validated): void
    {
        $current = Setting::getLegalPage($page);
        $updatedOn = $validated[$page.'_updated_on'] ?? null;

        Setting::setValue('legal_'.$page, Setting::encodeJson([
            'title' => trim(strip_tags((string) $validated[$page.'_title'])),
            'meta_description' => trim(strip_tags((string) ($validated[$page.'_meta_description'] ?? ''))),
            'updated_on' => $updatedOn ?: $current['updated_on'],
            'body' => RichText::clean($validated[$page.'_body'] ?? ''),
        ]));
    }
}
