<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            $imagePath = $request->file('image_url')->store('research/images', 'media');
            $validated['image_url'] = Storage::disk('media')->url($imagePath);
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('research/videos', 'media');
            $validated['video_file'] = Storage::disk('media')->url($videoPath);
        }

        // Generate unique slug
        $slug = Str::slug($request->title);
        $existing = Research::where('slug', $slug)->first();
        if ($existing) {
            $slug = $slug . '-' . time();
        }
        
        $validated['slug'] = $slug;
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
                Storage::disk('media')->delete($this->storagePath($research->image_url));
            }
            $imagePath = $request->file('image_url')->store('research/images', 'media');
            $validated['image_url'] = Storage::disk('media')->url($imagePath);
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video
            if ($research->video_file) {
                Storage::disk('media')->delete($this->storagePath($research->video_file));
            }
            $videoPath = $request->file('video_file')->store('research/videos', 'media');
            $validated['video_file'] = Storage::disk('media')->url($videoPath);
        }

        // Generate unique slug
        $slug = Str::slug($request->title);
        $existing = Research::where('slug', $slug)->where('id', '!=', $research->id)->first();
        if ($existing) {
            $slug = $slug . '-' . time();
        }
        
        $validated['slug'] = $slug;
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
            Storage::disk('media')->delete($this->storagePath($research->image_url));
        }
        if ($research->video_file) {
            Storage::disk('media')->delete($this->storagePath($research->video_file));
        }

        $research->delete();

        return redirect()->route('admin.research.index')
            ->with('success', 'Research item deleted successfully.');
    }

    private function storagePath(string $value): string
    {
        $path = parse_url($value, PHP_URL_PATH) ?: $value;

        return ltrim(preg_replace('/^\/?storage\//', '', $path), '/');
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
            Log::error('Toggle Status Error: ' . $e->getMessage());
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
            Log::error('Toggle Featured Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*' => 'integer|exists:research,id'
            ]);

            foreach ($validated['items'] as $index => $id) {
                Research::where('id', $id)->update(['order' => $index]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Reorder Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get video data for the modal player
     * This handles both uploaded videos and external URLs (YouTube, Vimeo)
     */
    public function getVideoData($id)
    {
        try {
            $research = Research::findOrFail($id);
            
            // Check if there's any video data
            if (!$research->video_url && !$research->video_file) {
                return response()->json([
                    'success' => false,
                    'message' => 'No video available for this item'
                ], 404);
            }

            // Get video embed URL
            $embedUrl = null;
            if ($research->video_url) {
                // YouTube
                if (strpos($research->video_url, 'youtube.com') !== false || strpos($research->video_url, 'youtu.be') !== false) {
                    // Handle shorts URLs
                    if (strpos($research->video_url, '/shorts/') !== false) {
                        preg_match('/shorts\/([^"&?\/\s]{11})/', $research->video_url, $matches);
                        $videoId = $matches[1] ?? null;
                    } else {
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $research->video_url, $matches);
                        $videoId = $matches[1] ?? null;
                    }
                    if ($videoId) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                    }
                }
                // Vimeo
                elseif (strpos($research->video_url, 'vimeo.com') !== false) {
                    preg_match('/vimeo\.com\/(\d+)/', $research->video_url, $matches);
                    if (isset($matches[1])) {
                        $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                    }
                }
                // Direct video URL (if it's a direct link to a video file)
                else {
                    $embedUrl = $research->video_url;
                }
            }

            return response()->json([
                'success' => true,
                'video_file' => $research->video_file,
                'video_embed_url' => $embedUrl,
                'video_thumbnail' => $research->video_thumbnail,
                'title' => $research->title
            ]);
        } catch (\Exception $e) {
            Log::error('Get Video Data Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Featured page for frontend - shows all featured research items
     */
    public function featured()
    {
        try {
        // Get ALL active research items, not just featured
        $featuredResearch = Research::where('is_active', true)
            ->orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        return view('research.featured', compact('featuredResearch'));
        } 
        catch (\Exception $e) 
        {
        Log::error('Research Page Error: ' . $e->getMessage());
        return view('research.featured', ['featuredResearch' => collect()]);
        }
    }

    /**
     * Get research detail for modal
     */
    public function getResearchDetail($id)
    {
        try {
            $research = Research::findOrFail($id);
            
            // Get video embed URL
            $embedUrl = null;
            if ($research->video_url) {
                if (strpos($research->video_url, 'youtube.com') !== false || strpos($research->video_url, 'youtu.be') !== false) {
                    if (strpos($research->video_url, '/shorts/') !== false) {
                        preg_match('/shorts\/([^"&?\/\s]{11})/', $research->video_url, $matches);
                        $videoId = $matches[1] ?? null;
                    } else {
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $research->video_url, $matches);
                        $videoId = $matches[1] ?? null;
                    }
                    if ($videoId) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                    }
                } elseif (strpos($research->video_url, 'vimeo.com') !== false) {
                    preg_match('/vimeo\.com\/(\d+)/', $research->video_url, $matches);
                    if (isset($matches[1])) {
                        $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $research->id,
                    'title' => $research->title,
                    'category' => $research->category,
                    'description' => $research->description,
                    'content' => $research->content,
                    'image_url' => $research->image_url,
                    'video_url' => $research->video_url,
                    'video_embed_url' => $embedUrl,
                    'video_file' => $research->video_file,
                    'link_url' => $research->link_url,
                    'is_featured' => $research->is_featured,
                    'created_at' => $research->created_at,
                    'updated_at' => $research->updated_at,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Get Research Detail Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}