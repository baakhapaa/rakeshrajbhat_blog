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

class SettingsController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $settings = Setting::getSiteSettings();
        $navIcons = Setting::navIconOptions();
        $navItems = $settings['nav_items'];

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

        return view('admin.settings.index', compact('admin', 'settings', 'navIcons', 'navItems'));
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

    private function deleteStoredAsset(?string $url): void
    {
        if (!$url) {
            return;
        }

        MediaStorage::delete($url);
    }
}
