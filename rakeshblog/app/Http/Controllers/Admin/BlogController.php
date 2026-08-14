<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $content = html_entity_decode($validated['content']);
        $excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($content), 150);

        $tags = [];
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $featuredImage = $request->featured_image ?? null;

        // Generate a unique slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        
        // Check if slug exists and append number if needed
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $isPublished = $request->has('is_published') && $request->is_published == 1;
        $publishedAt = $isPublished ? now() : null;

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug, // Use the unique slug
            'content' => $content,
            'excerpt' => $excerpt,
            'category' => $validated['category'] ?? 'General',
            'tags' => $tags,
            'featured_image' => $featuredImage,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
            'author' => auth()->guard('admin')->user()->name ?? 'Admin',
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $content = html_entity_decode($validated['content']);
        $excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($content), 150);

        $tags = [];
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $featuredImage = $request->featured_image ?? null;

        // Generate a unique slug (except for the current blog)
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        
        // Check if slug exists and is not the current blog
        while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $isPublished = $request->has('is_published') && $request->is_published == 1;
        $publishedAt = $isPublished ? now() : null;

        // Delete old image if new one is uploaded
        if ($featuredImage && $blog->featured_image && $featuredImage !== $blog->featured_image) {
            $oldPath = str_replace('/storage/', '', $blog->featured_image);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $blog->update([
            'title' => $validated['title'],
            'slug' => $slug, // Use the unique slug
            'content' => $content,
            'excerpt' => $excerpt,
            'category' => $validated['category'] ?? 'General',
            'tags' => $tags,
            'featured_image' => $featuredImage,
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        
        if ($blog->featured_image) {
            $path = str_replace('/storage/', '', $blog->featured_image);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully!');
    }
}