<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\MediaStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeContentController extends Controller
{
    public function editHome()
    {
        $home = Setting::getHomeContent();

        return view('admin.home.edit', compact('home'));
    }

    public function updateHome(Request $request)
    {
        $validated = $request->validate([
            'eyebrow' => 'required|string|max:120',
            'headline_line_1' => 'required|string|max:120',
            'headline_line_2' => 'required|string|max:120',
            'headline_line_3' => 'required|string|max:120',
            'intro' => 'required|string|max:1000',
            'primary_button_label' => 'required|string|max:80',
            'primary_button_url' => 'required|string|max:500',
            'text_link_label' => 'required|string|max:80',
            'text_link_url' => 'required|string|max:500',
            'name' => 'required|string|max:120',
            'tagline' => 'required|string|max:200',
            'background_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'remove_background' => 'nullable|boolean',
        ]);

        $primaryUrl = Setting::sanitizeLink($validated['primary_button_url']);
        $textUrl = Setting::sanitizeLink($validated['text_link_url']);
        $errors = [];

        if ($primaryUrl === null) {
            $errors['primary_button_url'] = 'Use a section anchor like #projects, a site path like /blog, or an http(s) URL.';
        }

        if ($textUrl === null) {
            $errors['text_link_url'] = 'Use a section anchor like #about, a site path like /blog, or an http(s) URL.';
        }

        if ($errors) {
            return back()->withErrors($errors)->withInput();
        }

        $current = Setting::getHomeContent();
        $image = $current['background_image'];

        if ($request->boolean('remove_background')) {
            $this->deleteStoredAsset($image);
            $image = null;
        }

        if ($request->hasFile('background_image')) {
            $this->deleteStoredAsset($image);
            $path = $request->file('background_image')->store('site-settings', 'media');
            $image = Storage::disk('media')->url($path);
        }

        Setting::setValue('home_content', Setting::encodeJson([
            'eyebrow' => $validated['eyebrow'],
            'headline_line_1' => $validated['headline_line_1'],
            'headline_line_2' => $validated['headline_line_2'],
            'headline_line_3' => $validated['headline_line_3'],
            'intro' => $validated['intro'],
            'primary_button_label' => $validated['primary_button_label'],
            'primary_button_url' => $primaryUrl,
            'text_link_label' => $validated['text_link_label'],
            'text_link_url' => $textUrl,
            'name' => $validated['name'],
            'tagline' => $validated['tagline'],
            'background_image' => $image,
        ]));

        return redirect()->route('admin.home-content.edit')->with('success', 'Home content updated successfully!');
    }

    private function deleteStoredAsset(?string $url): void
    {
        if (!$url) {
            return;
        }

        MediaStorage::delete($url);
    }
}
