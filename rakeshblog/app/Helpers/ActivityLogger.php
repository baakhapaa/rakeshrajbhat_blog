<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log($activity, $description = null, $data = null)
    {
        $request = request();
        $user = Auth::user();
        $admin = Auth::guard('admin')->user();

        // Determine user info
        $userName = null;
        $userEmail = null;
        $userId = null;

        if ($user) {
            $userName = $user->name;
            $userEmail = $user->email;
            $userId = $user->id;
        } elseif ($admin) {
            $userName = $admin->name;
            $userEmail = $admin->email;
            $userId = $admin->id;
        } else {
            $userName = 'System / Admin';
        }

        // Get browser info
        $userAgent = $request->userAgent();
        $browser = self::getBrowser($userAgent);
        $platform = self::getPlatform($userAgent);

        return ActivityLog::create([
            'user_id' => $userId,
            'user_name' => $userName,
            'user_email' => $userEmail,
            'activity' => $activity,
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'browser' => $browser,
            'platform' => $platform,
            'route' => $request->route() ? $request->route()->getName() : null,
            'method' => $request->method(),
            'data' => $data,
        ]);
    }

    private static function getBrowser($userAgent)
    {
        if (!$userAgent) return 'Unknown';
        if (str_contains($userAgent, 'Chrome') && !str_contains($userAgent, 'Edg')) return 'Chrome';
        if (str_contains($userAgent, 'Firefox')) return 'Firefox';
        if (str_contains($userAgent, 'Safari') && !str_contains($userAgent, 'Chrome')) return 'Safari';
        if (str_contains($userAgent, 'Edg')) return 'Edge';
        if (str_contains($userAgent, 'Opera')) return 'Opera';
        return 'Unknown';
    }

    private static function getPlatform($userAgent)
    {
        if (!$userAgent) return 'Unknown';
        if (str_contains($userAgent, 'Windows')) return 'Windows';
        if (str_contains($userAgent, 'Mac')) return 'Mac';
        if (str_contains($userAgent, 'Linux')) return 'Linux';
        if (str_contains($userAgent, 'Android')) return 'Android';
        if (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) return 'iOS';
        return 'Unknown';
    }
}