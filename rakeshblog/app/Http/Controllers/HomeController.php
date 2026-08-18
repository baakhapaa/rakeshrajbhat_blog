<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stat;
use App\Models\Blog;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        // Get all active stats ordered by order field
        try {
            $stats = Stat::where('is_active', true)->orderBy('order', 'asc')->get();
        } catch (\Exception $e) {
            $stats = collect();
        }

        // Get latest blog posts from admin
        try {
            $latestBlogs = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->take(3) // Get only 3 latest posts for homepage
                ->get();
        } catch (\Exception $e) {
            $latestBlogs = collect();
        }

        // Get all active projects ordered by order field
        try {
            $projects = Project::where('is_active', true)
                ->orderBy('order', 'asc')
                ->get();
        } catch (\Exception $e) {
            $projects = collect();
        }

        // Get total counts for hero section (optional)
        try {
            $totalBlogs = Blog::where('is_published', true)->count();
            $totalProjects = Project::where('is_active', true)->count();
        } catch (\Exception $e) {
            $totalBlogs = 0;
            $totalProjects = 0;
        }

        return view('home', compact('stats', 'latestBlogs', 'projects', 'totalBlogs', 'totalProjects'));
    }

    /**
     * Get projects as JSON (for AJAX requests)
     */
    public function getProjects()
    {
        try {
            $projects = Project::where('is_active', true)
                ->orderBy('order', 'asc')
                ->get(['id', 'name', 'slug', 'icon', 'short_description', 'description', 'url', 'image', 'color']);
            
            return response()->json([
                'success' => true,
                'data' => $projects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single project by slug
     */
    public function getProject($slug)
    {
        try {
            $project = Project::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $project
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }
    }
}