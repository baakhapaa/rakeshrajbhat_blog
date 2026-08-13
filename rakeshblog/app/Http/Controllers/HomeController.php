<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stat;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        // Get all active stats ordered by order field
        try {
            $stats = Stat::where('is_active', true)->orderBy('order', 'asc')->get();
        } catch (\Exception $e) {
            $stats = collect(); // Empty collection if table doesn't exist
        }
        
        // Get latest blog posts
        try {
            $latestBlogs = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        } catch (\Exception $e) {
            $latestBlogs = collect();
        }
        
        return view('home', compact('stats', 'latestBlogs'));
    }
}