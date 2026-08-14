<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;

class SettingsController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings.index', compact('admin'));
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
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $image = $request->file('profile_pic');
            $filename = 'admin_' . $admin->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('admin-profiles', $filename, 'public');
            $profilePic = Storage::url($path);
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
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:1024',
        ]);

        // Handle Site Logo Upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            if (config('app.logo')) {
                $oldPath = str_replace('/storage/', '', config('app.logo'));
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $logo = $request->file('site_logo');
            $logoFilename = 'site_logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('site-settings', $logoFilename, 'public');
            $logoUrl = Storage::url($logoPath);
        } else {
            $logoUrl = config('app.logo', null);
        }

        // Handle Site Favicon Upload
        if ($request->hasFile('site_favicon')) {
            // Delete old favicon if exists
            if (config('app.favicon')) {
                $oldPath = str_replace('/storage/', '', config('app.favicon'));
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $favicon = $request->file('site_favicon');
            $faviconFilename = 'site_favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $faviconPath = $favicon->storeAs('site-settings', $faviconFilename, 'public');
            $faviconUrl = Storage::url($faviconPath);
        } else {
            $faviconUrl = config('app.favicon', null);
        }

        // Store in .env or database (for now, we'll use session)
        // In a real app, you'd store these in a settings table
        session([
            'site_name' => $request->site_name ?? config('app.name'),
            'site_description' => $request->site_description ?? config('app.description'),
            'site_logo' => $logoUrl,
            'site_favicon' => $faviconUrl,
        ]);

        // For demo purposes, we'll store in a JSON file or you can create a settings table
        $settings = [
            'site_name' => $request->site_name ?? config('app.name'),
            'site_description' => $request->site_description ?? 'Official website of Rakesh Rajbhat',
            'site_logo' => $logoUrl,
            'site_favicon' => $faviconUrl,
        ];

        // Store settings in config (temporary - use database for production)
        config(['app.name' => $settings['site_name']]);
        
        // You can also store in a file
        file_put_contents(storage_path('app/settings.json'), json_encode($settings));

        return redirect()->route('admin.settings')->with('success', 'General settings updated successfully!');
    }

    // Helper function to get settings
    public static function getSettings()
    {
        $default = [
            'site_name' => 'Rakesh Rajbhat',
            'site_description' => 'Official website of Rakesh Rajbhat - Founder, Builder, Future Maker',
            'site_logo' => null,
            'site_favicon' => null,
        ];

        if (file_exists(storage_path('app/settings.json'))) {
            $settings = json_decode(file_get_contents(storage_path('app/settings.json')), true);
            return array_merge($default, $settings);
        }

        return $default;
    }
}