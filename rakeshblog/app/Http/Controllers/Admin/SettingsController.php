<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Setting;
use App\Support\MediaStorage;
use App\Support\SiteFavicon;

class SettingsController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $settings = Setting::getSiteSettings();
        $navIcons = Setting::navIconOptions();
        $navItems = $settings['nav_items'];
        $footer = Setting::getFooter();

        if (is_array(old('nav_label'))) {
            $navItems = [];
            foreach (old('nav_label') as $index => $label) {
                $navItems[] = [
                    'label' => $label,
                    'url' => old('nav_url.'.$index),
                    'icon' => old('nav_icon.'.$index),
                ];
            }
        }

        if (is_array(old('social_label'))) {
            $footer['socials'] = [];
            foreach (old('social_label') as $index => $label) {
                $footer['socials'][] = ['label' => $label, 'url' => old('social_url.'.$index)];
            }
        }

        if (is_array(old('page_label'))) {
            $footer['pages'] = [];
            foreach (old('page_label') as $index => $label) {
                $footer['pages'][] = ['label' => $label, 'url' => old('page_url.'.$index)];
            }
        }

        return view('admin.settings.index', compact('admin', 'settings', 'navIcons', 'navItems', 'footer'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            // Delete old profile picture
            if ($admin->profile_pic) {
                MediaStorage::delete($admin->profile_pic);
            }

            $image = $request->file('profile_pic');
            $filename = 'admin_' . $admin->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('admin-profiles', $filename, 'media');
            $profilePic = Storage::disk('media')->url($path);
        } else {
            $profilePic = $admin->profile_pic;
        }

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'profile_pic' => $profilePic,
        ]);

        return redirect()->route('admin.settings')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('admin.settings')->with('success', 'Password updated successfully!');
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'site_favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg,webp|max:1024',
        ]);

        if ($request->hasFile('site_logo')) {
            $this->deleteStoredAsset(Setting::getValue('site_logo'));
            $logoPath = $request->file('site_logo')->store('site-settings', 'media');
            Setting::setValue('site_logo', Storage::disk('media')->url($logoPath));
        }

        if ($request->hasFile('site_favicon')) {
            $this->deleteStoredAsset(Setting::getValue('site_favicon'));
            $faviconPath = $request->file('site_favicon')->store('site-settings', 'media');
            Setting::setValue('site_favicon', Storage::disk('media')->url($faviconPath));
            $localFile = null;
            try {
                $candidate = Storage::disk('media')->path($faviconPath);
                if (is_file($candidate)) {
                    $localFile = $candidate;
                }
            } catch (\Throwable $exception) {
                $localFile = null;
            }
            SiteFavicon::publish($localFile);
        }

        Setting::setValue('site_name', $validated['site_name'] ?: 'Rakesh Rajbhat');
        Setting::setValue('site_description', $validated['site_description'] ?: 'Official website of Rakesh Rajbhat - Founder, Builder, Future Maker');

        return redirect()->route('admin.settings')->with('success', 'General settings updated successfully!');
    }

    public function updateNavigation(Request $request)
    {
        $validated = $request->validate([
            'nav_label' => 'required|array|min:1|max:8',
            'nav_label.*' => 'nullable|string|max:40',
            'nav_url' => 'required|array|max:8',
            'nav_url.*' => 'nullable|string|max:255',
            'nav_icon' => 'nullable|array|max:8',
            'nav_icon.*' => 'nullable|string|max:60',
        ]);

        $items = [];

        foreach ($validated['nav_label'] as $index => $label) {
            $label = trim(strip_tags((string) $label));
            $url = trim((string) ($validated['nav_url'][$index] ?? ''));

            if ($label === '' && $url === '') {
                continue;
            }

            if ($label === '' || $url === '' || ! Setting::navUrlIsSafe($url)) {
                return redirect()
                    ->route('admin.settings', ['tab' => 'navbar'])
                    ->withErrors(['nav_label' => 'Each menu item needs a label and a safe link (#section, /page, or https://).'])
                    ->withInput();
            }

            $items[] = [
                'label' => $label,
                'url' => $url,
            ];
        }

        if ($items === []) {
            return redirect()
                ->route('admin.settings', ['tab' => 'navbar'])
                ->withErrors(['nav_label' => 'Add at least one menu item.'])
                ->withInput();
        }

        Setting::setValue('nav_items', json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return redirect()->route('admin.settings', ['tab' => 'navbar'])->with('success', 'Navigation updated successfully!');
    }

    public function updateFooter(Request $request)
    {
        $validated = $request->validate([
            'footer_name' => 'required|string|max:80',
            'footer_tagline' => 'required|string|max:160',
            'footer_intro' => 'required|string|max:400',
            'footer_copyright' => 'required|string|max:160',
            'footer_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'remove_footer_logo' => 'nullable|boolean',
            'socials_heading' => 'required|string|max:40',
            'pages_heading' => 'required|string|max:40',
            'newsletter_heading' => 'required|string|max:40',
            'newsletter_note' => 'required|string|max:240',
            'social_label' => 'nullable|array|max:12',
            'social_label.*' => 'nullable|string|max:40',
            'social_url' => 'nullable|array|max:12',
            'social_url.*' => 'nullable|string|max:255',
            'page_label' => 'nullable|array|max:12',
            'page_label.*' => 'nullable|string|max:40',
            'page_url' => 'nullable|array|max:12',
            'page_url.*' => 'nullable|string|max:255',
        ]);

        $socials = $this->footerLinks($validated['social_label'] ?? [], $validated['social_url'] ?? []);
        $pages = $this->footerLinks($validated['page_label'] ?? [], $validated['page_url'] ?? []);

        if ($socials === false || $pages === false) {
            return redirect()
                ->route('admin.settings', ['tab' => 'footer'])
                ->withErrors(['footer_name' => 'Each social and page link needs a label and a safe link (/page or https://).'])
                ->withInput();
        }

        if ($request->boolean('remove_footer_logo')) {
            $this->deleteStoredAsset(Setting::getValue('footer_logo'));
            Setting::setValue('footer_logo', '');
        }

        if ($request->hasFile('footer_logo')) {
            $this->deleteStoredAsset(Setting::getValue('footer_logo'));
            $logoPath = $request->file('footer_logo')->store('site-settings', 'media');
            Setting::setValue('footer_logo', Storage::disk('media')->url($logoPath));
        }

        Setting::setValue('footer_content', Setting::encodeJson([
            'name' => trim(strip_tags($validated['footer_name'])),
            'tagline' => trim(strip_tags($validated['footer_tagline'])),
            'intro' => trim(strip_tags($validated['footer_intro'])),
            'copyright' => trim(strip_tags($validated['footer_copyright'])),
            'socials_heading' => trim(strip_tags($validated['socials_heading'])),
            'pages_heading' => trim(strip_tags($validated['pages_heading'])),
            'newsletter_heading' => trim(strip_tags($validated['newsletter_heading'])),
            'newsletter_note' => trim(strip_tags($validated['newsletter_note'])),
            'socials' => $socials,
            'pages' => $pages,
        ]));

        return redirect()->route('admin.settings', ['tab' => 'footer'])->with('success', 'Footer updated.');
    }

    private function footerLinks(array $labels, array $urls): array|false
    {
        $items = [];

        foreach ($labels as $index => $label) {
            $label = trim(strip_tags((string) $label));
            $url = trim((string) ($urls[$index] ?? ''));

            if ($label === '' && $url === '') {
                continue;
            }

            if ($label === '' || $url === '' || ! Setting::navUrlIsSafe($url)) {
                return false;
            }

            $items[] = ['label' => $label, 'url' => $url];
        }

        return array_slice($items, 0, 12);
    }

    private function deleteStoredAsset(?string $url): void
    {
        if (!$url) {
            return;
        }

        MediaStorage::delete($url);
    }
}
