<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\AboutVideo;
use App\Support\MediaStorage;
use App\Support\RichText;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HomeContentController extends Controller
{
    public function editHome()
    {
        $home = Setting::getHomeContent();
        $about = Setting::getAboutContent();
        $mission = Setting::getMissionContent();

        return view('admin.home.edit', compact('home', 'about', 'mission'));
    }

    public function updateHome(Request $request)
    {
        $validated = $request->validate([
            'eyebrow' => 'nullable|string|max:120',
            'headline_line_1' => 'nullable|string|max:120',
            'headline_line_2' => 'nullable|string|max:120',
            'headline_line_3' => 'nullable|string|max:120',
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
            'eyebrow' => Setting::nullableHomeString($validated['eyebrow'] ?? null),
            'headline_line_1' => Setting::nullableHomeString($validated['headline_line_1'] ?? null),
            'headline_line_2' => Setting::nullableHomeString($validated['headline_line_2'] ?? null),
            'headline_line_3' => Setting::nullableHomeString($validated['headline_line_3'] ?? null),
            'intro' => $validated['intro'],
            'primary_button_label' => $validated['primary_button_label'],
            'primary_button_url' => $primaryUrl,
            'text_link_label' => $validated['text_link_label'],
            'text_link_url' => $textUrl,
            'name' => $validated['name'],
            'tagline' => $validated['tagline'],
            'background_image' => $image,
        ]));

        return redirect()->route('admin.home-content.edit', ['tab' => 'hero'])->with('success', 'Hero content updated successfully!');
    }

    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'about_label' => 'required|string|max:80',
            'about_heading_line_1' => 'required|string|max:80',
            'about_heading_line_2' => 'nullable|string|max:80',
            'about_paragraph_1' => 'required|string|max:1000',
            'about_paragraph_2' => 'required|string|max:1500',
            'about_paragraph_3' => 'nullable|string|max:1500',
            'about_button_label' => 'nullable|string|max:40',
            'about_button_url' => 'nullable|string|max:255',
            'about_fact_title' => 'required|array|min:1|max:12',
            'about_fact_title.*' => 'required|string|max:80',
            'about_fact_caption' => 'required|array|min:1|max:12',
            'about_fact_caption.*' => 'required|string|max:80',
        ], [
            'about_fact_title.required' => 'Add at least one detail.',
            'about_fact_title.max' => 'You can add up to 12 details.',
            'about_fact_title.*.required' => 'Each detail needs a title.',
            'about_fact_caption.*.required' => 'Each detail needs a caption.',
        ]);

        if (count($validated['about_fact_title']) !== count($validated['about_fact_caption'])) {
            return back()->withErrors([
                'about_fact_title' => 'Each detail needs a title and a caption.',
            ])->withInput();
        }

        $facts = [];

        foreach ($validated['about_fact_title'] as $index => $title) {
            $facts[] = [
                'title' => trim($title),
                'caption' => trim((string) ($validated['about_fact_caption'][$index] ?? '')),
            ];
        }

        $buttonUrl = trim((string) ($validated['about_button_url'] ?? ''));

        if ($buttonUrl === '') {
            $buttonUrl = '#projects';
        } else {
            $buttonUrl = Setting::sanitizeLink($buttonUrl);

            if ($buttonUrl === null) {
                return back()->withErrors([
                    'about_button_url' => 'Use a section anchor like #projects, a site path like /blog, or an http(s) URL.',
                ])->withInput();
            }
        }

        $current = Setting::getAboutContent();
        $mediaUrl = $current['media_url'];
        $mediaType = $current['media_type'];
        $posterUrl = $current['media_poster'];

        if ($request->boolean('remove_about_media') && ! $request->hasFile('about_media')) {
            $this->deleteStoredAsset($mediaUrl);
            $this->deleteStoredAsset($posterUrl);
            $mediaUrl = null;
            $mediaType = null;
            $posterUrl = null;
        }

        if ($request->hasFile('about_media')) {
            $file = $request->file('about_media');
            $kind = $this->aboutMediaKind($file);

            if (! $file->isValid() || $kind === null) {
                return back()->withErrors([
                    'about_media' => 'Upload an image (JPG, PNG, WEBP, GIF, or SVG) or a video (MP4, WEBM, or MOV).',
                ])->withInput();
            }

            $maxKilobytes = $kind === 'video' ? 102400 : 5120;
            if ($file->getSize() > $maxKilobytes * 1024) {
                return back()->withErrors([
                    'about_media' => $kind === 'video'
                        ? 'Video must be 100MB or smaller.'
                        : 'Image must be 5MB or smaller.',
                ])->withInput();
            }

            $this->deleteStoredAsset($mediaUrl);
            $this->deleteStoredAsset($posterUrl);
            $posterUrl = null;

            if ($kind === 'video') {
                $optimized = AboutVideo::storeOptimized($file->getRealPath());

                if ($optimized) {
                    $mediaUrl = $optimized['url'];
                    $posterUrl = $optimized['poster'];
                } else {
                    $path = $file->store('about', 'media');
                    $mediaUrl = Storage::disk('media')->url($path);
                }
            } else {
                $path = $file->store('about', 'media');
                $mediaUrl = Storage::disk('media')->url($path);
            }

            $mediaType = $kind;
        }

        Setting::setValue('about_content', Setting::encodeJson([
            'label' => $validated['about_label'],
            'heading_line_1' => $validated['about_heading_line_1'],
            'heading_line_2' => trim((string) ($validated['about_heading_line_2'] ?? '')),
            'paragraph_1' => $validated['about_paragraph_1'],
            'paragraph_2' => $validated['about_paragraph_2'],
            'paragraph_3' => trim((string) ($validated['about_paragraph_3'] ?? '')),
            'button_label' => trim((string) ($validated['about_button_label'] ?? '')),
            'button_url' => $buttonUrl,
            'facts' => $facts,
            'media_url' => $mediaUrl,
            'media_type' => $mediaType,
            'media_poster' => $posterUrl,
        ]));

        return redirect()->route('admin.home-content.edit', ['tab' => 'about'])->with('success', 'About me updated successfully!');
    }

    public function updateMission(Request $request)
    {
        $validated = $request->validate([
            'mission_label' => 'required|string|max:80',
            'mission_button_label' => 'required|string|max:40',
            'mission_title' => 'required|array|min:2|max:12',
            'mission_title.*' => 'required|string|max:80',
            'mission_body' => 'required|array|min:2|max:12',
            'mission_body.*' => 'required|string|max:90',
            'mission_description' => 'required|array|min:2|max:12',
            'mission_description.*' => 'nullable|string|max:200000',
        ], [
            'mission_title.required' => 'Add at least two mission items.',
            'mission_title.min' => 'Add at least two mission items.',
            'mission_title.max' => 'You can add up to 12 mission items.',
            'mission_title.*.required' => 'Each mission needs a title.',
            'mission_body.*.required' => 'Each mission needs a short description.',
        ]);

        if (
            count($validated['mission_title']) !== count($validated['mission_body'])
            || count($validated['mission_title']) !== count($validated['mission_description'])
        ) {
            return back()->withErrors([
                'mission_title' => 'Each mission needs a title, short description, and long description.',
            ])->withInput();
        }

        $items = [];

        foreach ($validated['mission_title'] as $index => $title) {
            $description = RichText::clean($validated['mission_description'][$index] ?? '');

            if (trim(strip_tags($description)) === '' && ! str_contains($description, '<img')) {
                return back()->withErrors([
                    'mission_description.'.$index => 'Each mission needs a long description for the Learn More modal.',
                ])->withInput();
            }

            $items[] = [
                'number' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                'title' => trim($title),
                'body' => trim((string) ($validated['mission_body'][$index] ?? '')),
                'description' => $description,
            ];
        }

        Setting::setValue('mission_content', Setting::encodeJson([
            'label' => trim($validated['mission_label']),
            'button_label' => trim($validated['mission_button_label']),
            'items' => $items,
        ]));

        return redirect()->route('admin.home-content.edit', ['tab' => 'mission'])->with('success', 'Missions updated successfully!');
    }

    private function aboutMediaKind(UploadedFile $file): ?string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true)) {
            return 'image';
        }

        if (in_array($extension, ['mp4', 'webm', 'mov'], true)) {
            return 'video';
        }

        return null;
    }

    private function deleteStoredAsset(?string $url): void
    {
        if (!$url) {
            return;
        }

        MediaStorage::delete($url);
    }
}
