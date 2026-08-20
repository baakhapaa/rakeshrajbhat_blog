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

        // Get FEATURED blogs for homepage (from admin panel)
        try {
            $featuredBlogs = Blog::where('is_published', true)
                ->where('is_featured', true)  // Only get featured blogs
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(3) // Show up to 3 featured blogs
                ->get();
        } catch (\Exception $e) {
            $featuredBlogs = collect();
        }

        // Get latest blogs (as fallback if no featured blogs exist)
        try {
            $latestBlogs = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            $latestBlogs = collect();
        }

        // If there are featured blogs, use them; otherwise use latest blogs
        $homeBlogs = $featuredBlogs->isNotEmpty() ? $featuredBlogs : $latestBlogs;

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
            $totalFeaturedBlogs = Blog::where('is_published', true)
                ->where('is_featured', true)
                ->count();
        } catch (\Exception $e) {
            $totalBlogs = 0;
            $totalProjects = 0;
            $totalFeaturedBlogs = 0;
        }

        return view('home', compact(
            'stats', 
            'homeBlogs', 
            'projects', 
            'totalBlogs', 
            'totalProjects',
            'totalFeaturedBlogs',
            'featuredBlogs'  // Pass separately for the featured section
        ));
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

    /**
     * Get featured blogs for AJAX/widget
     */
    public function getFeaturedBlogs()
    {
        try {
            $blogs = Blog::where('is_published', true)
                ->where('is_featured', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $blogs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get latest blogs for AJAX/widget
     */
    public function getLatestBlogs()
    {
        try {
            $blogs = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $blogs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}