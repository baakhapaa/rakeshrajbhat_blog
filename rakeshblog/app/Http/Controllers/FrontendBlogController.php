<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontendBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('blog', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->with([
                'comments' => function($query) {
                    $query->with('user')->orderBy('created_at', 'desc');
                },
                'quizzes' => function($query) {
                    $query->with('questions')->where('is_active', true);
                }
            ])
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        // Get related blogs
        $relatedBlogs = Blog::where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->where('is_published', true)
            ->limit(3)
            ->get();

        return view('blog-show', compact('blog', 'relatedBlogs'));
    }
}