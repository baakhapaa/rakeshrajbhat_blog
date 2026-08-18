<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'LIKE', "%{$search}%")
                  ->orWhere('user_email', 'LIKE', "%{$search}%")
                  ->orWhere('activity', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('ip_address', 'LIKE', "%{$search}%");
            });
        }

        // Filter by activity type
        if ($request->has('activity_type') && $request->activity_type) {
            $query->where('activity', $request->activity_type);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $logs = $query->paginate(20);
        $logs->appends($request->all());

        // Get unique activity types for filter
        $activityTypes = ActivityLog::distinct()->pluck('activity');

        return view('admin.activity-logs.index', compact('logs', 'activityTypes'));
    }

    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        return redirect()->route('admin.activity.logs')
            ->with('success', 'Activity log deleted successfully!');
    }

    public function clearAll()
    {
        ActivityLog::truncate();

        return redirect()->route('admin.activity.logs')
            ->with('success', 'All activity logs cleared successfully!');
    }
}