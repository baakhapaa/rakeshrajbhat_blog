<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ResearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Research::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sorting
        $sort = $request->get('sort', 'order');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Paginate results (10 per page)
        $researchItems = $query->paginate(10)->withQueryString();

        return view('admin.research.index', compact('researchItems'));
    }

    public function create()
    {
        return view('admin.research.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Vision,Research Papers,Media',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url|max:255',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
            'link_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'category_icon' => 'nullable|string'
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('research/images', 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('research/videos', 'public');
            $validated['video_file'] = '/storage/' . $videoPath;
        }

        $validated['slug'] = Str::slug($request->title);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        Research::create($validated);

        return redirect()->route('admin.research.index')
            ->with('success', 'Research item created successfully.');
    }

    public function show(Research $research)
    {
        return view('admin.research.show', compact('research'));
    }

    public function edit(Research $research)
    {
        return view('admin.research.edit', compact('research'));
    }

    public function update(Request $request, Research $research)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Vision,Research Papers,Media',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url|max:255',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
            'link_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'category_icon' => 'nullable|string'
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete old image
            if ($research->image_url) {
                $oldPath = str_replace('/storage/', '', $research->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $imagePath = $request->file('image_url')->store('research/images', 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video
            if ($research->video_file) {
                $oldPath = str_replace('/storage/', '', $research->video_file);
                Storage::disk('public')->delete($oldPath);
            }
            $videoPath = $request->file('video_file')->store('research/videos', 'public');
            $validated['video_file'] = '/storage/' . $videoPath;
        }

        $validated['slug'] = Str::slug($request->title);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $research->update($validated);

        return redirect()->route('admin.research.index')
            ->with('success', 'Research item updated successfully.');
    }

    public function destroy(Research $research)
    {
        // Delete associated files
        if ($research->image_url) {
            $path = str_replace('/storage/', '', $research->image_url);
            Storage::disk('public')->delete($path);
        }
        if ($research->video_file) {
            $path = str_replace('/storage/', '', $research->video_file);
            Storage::disk('public')->delete($path);
        }

        $research->delete();

        return redirect()->route('admin.research.index')
            ->with('success', 'Research item deleted successfully.');
    }

    public function toggleStatus($id)
    {
        try {
            $research = Research::findOrFail($id);
            $research->is_active = !$research->is_active;
            $research->save();

            return response()->json([
                'success' => true,
                'is_active' => $research->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function toggleFeatured($id)
    {
        try {
            $research = Research::findOrFail($id);
            
            // If setting to featured, un-feature all others in same category
            if (!$research->is_featured) {
                Research::where('category', $research->category)
                    ->where('id', '!=', $research->id)
                    ->update(['is_featured' => false]);
            }
            
            $research->is_featured = !$research->is_featured;
            $research->save();

            return response()->json([
                'success' => true,
                'is_featured' => $research->is_featured,
                'message' => 'Featured status toggled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*' => 'integer|exists:research,id'
        ]);

        foreach ($validated['items'] as $index => $id) {
            Research::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function getVideoData(Research $research)
    {
        return response()->json([
            'video_file' => $research->video_file,
            'video_embed_url' => $research->video_embed_url,
            'video_thumbnail' => $research->video_thumbnail,
        ]);
    }

    // Featured page for frontend
    public function featured()
    {
        $featuredResearch = Research::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        return view('research.featured', compact('featuredResearch'));
    }
}