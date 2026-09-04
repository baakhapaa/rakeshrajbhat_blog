<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $settings = Setting::getSiteSettings();

        return view('admin.settings.index', compact('admin', 'settings'));
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
                $oldPath = str_replace('/storage/', '', $admin->profile_pic);
                if (Storage::disk('media')->exists($oldPath)) {
                    Storage::disk('media')->delete($oldPath);
                }
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

    private function deleteStoredAsset(?string $url): void
    {
        if (!$url) {
            return;
        }

        $path = ltrim(parse_url($url, PHP_URL_PATH) ?: '', '/');
        $path = preg_replace('/^storage\//', '', $path);

        if ($path && Storage::disk('media')->exists($path)) {
            Storage::disk('media')->delete($path);
        }
    }
}