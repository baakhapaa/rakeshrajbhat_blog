<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontendBlogController extends Controller
{
    /**
     * Display a listing of published blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhere('tags', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Get all categories for filter dropdown
        $categories = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        // Get blogs with comment count
        $blogs = $query->withCount('comments')
            ->orderBy('published_at', 'desc')
            ->paginate(9)
            ->appends($request->all());

        // Get featured blogs for sidebar
        $featuredBlogs = Blog::where('is_published', true)
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get popular blogs (most viewed)
        $popularBlogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('blog', compact('blogs', 'categories', 'featuredBlogs', 'popularBlogs'));
    }

    /**
     * Display a specific blog post.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with([
                'user',
                'comments' => function($query) {
                    $query->where('is_approved', true)
                        ->with('user')
                        ->orderBy('created_at', 'desc');
                },
                'quizzes' => function($query) {
                    $query->where('is_active', true)
                        ->with('questions');
                }
            ])
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        // Get related blogs (same category)
        $relatedBlogs = Blog::where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get previous and next blog posts
        $prevBlog = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('published_at', '<', $blog->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextBlog = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('published_at', '>', $blog->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        // Get tags
        $tags = $blog->tags ?? [];

        // Check if blog has quiz
        $hasQuiz = $blog->quizzes()->where('is_active', true)->exists();
        $activeQuiz = $hasQuiz ? $blog->quizzes()->where('is_active', true)->first() : null;

        return view('blog-show', compact(
            'blog',
            'relatedBlogs',
            'prevBlog',
            'nextBlog',
            'tags',
            'hasQuiz',
            'activeQuiz'
        ));
    }

    /**
     * Get blogs by category.
     */
    public function byCategory($category)
    {
        $blogs = Blog::where('category', $category)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->withCount('comments')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $featuredBlogs = Blog::where('is_published', true)
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $popularBlogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('blog', compact(
            'blogs',
            'categories',
            'featuredBlogs',
            'popularBlogs',
            'category'
        ));
    }

    /**
     * Search blogs.
     */
    public function search(Request $request)
    {
        $search = $request->input('query');

        if (empty($search)) {
            return redirect()->route('blog');
        }

        $blogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhere('tags', 'LIKE', "%{$search}%");
            })
            ->withCount('comments')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $featuredBlogs = Blog::where('is_published', true)
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $popularBlogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('blog', compact(
            'blogs',
            'categories',
            'featuredBlogs',
            'popularBlogs',
            'search'
        ));
    }

    /**
     * Get blog archives by month/year.
     */
    public function archive($year, $month)
    {
        $blogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->withCount('comments')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $featuredBlogs = Blog::where('is_published', true)
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $popularBlogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('blog', compact(
            'blogs',
            'categories',
            'featuredBlogs',
            'popularBlogs',
            'year',
            'month'
        ));
    }

    /**
     * Get blog feed (RSS/JSON).
     */
    public function feed()
    {
        $blogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'title' => 'Rakesh Rajbhat Blog',
            'description' => 'Latest blog posts from Rakesh Rajbhat',
            'url' => route('blog'),
            'feed_url' => route('blog.feed'),
            'items' => $blogs->map(function($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'excerpt' => $blog->excerpt,
                    'category' => $blog->category,
                    'published_at' => $blog->published_at ? $blog->published_at->toISOString() : null,
                    'url' => route('blog.show', $blog->slug),
                ];
            })
        ]);
    }

    /**
     * Get popular blogs (for AJAX/widget).
     */
    public function popular()
    {
        try {
            $blogs = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'slug', 'views', 'published_at']);

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
     * Get featured blogs (for AJAX/widget).
     */
    public function featured()
    {
        try {
            $blogs = Blog::where('is_published', true)
                ->where('is_featured', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get(['id', 'title', 'slug', 'featured_image', 'excerpt', 'published_at']);

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
     * Get latest blogs (for AJAX/widget).
     */
    public function latest()
    {
        try {
            $blogs = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'slug', 'featured_image', 'excerpt', 'published_at']);

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
     * Get blog categories with counts.
     */
    public function categories()
    {
        try {
            $categories = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->select('category')
                ->selectRaw('count(*) as total')
                ->groupBy('category')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get blog archives list.
     */
    public function archives()
    {
        try {
            $archives = Blog::where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->selectRaw('YEAR(published_at) as year')
                ->selectRaw('MONTH(published_at) as month')
                ->selectRaw('MONTHNAME(published_at) as month_name')
                ->selectRaw('count(*) as total')
                ->groupBy('year', 'month', 'month_name')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $archives
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}