<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Simple view or redirect
        return redirect()->route('admin.dashboard')->with('info', 'Activity logs feature coming soon!');
    }
}