<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Support\MediaStorage;
use App\Support\NewsletterNotifier;

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
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['id', 'title', 'category', 'created_at', 'is_featured'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }
        $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');

        // Paginate results (10 per page)
        $researchItems = $query->paginate(10)->withQueryString();
        $researchSection = Setting::getResearchSection();

        return view('admin.research.index', compact('researchItems', 'researchSection'));
    }

    public function updateSection(Request $request)
    {
        $validated = $request->validate([
            'research_section_title' => 'required|string|max:160',
            'research_section_paragraph' => 'required|string|max:400',
        ]);

        Setting::setValue('research_section_title', trim(strip_tags($validated['research_section_title'])));
        Setting::setValue('research_section_paragraph', trim(strip_tags($validated['research_section_paragraph'])));

        return redirect()->route('admin.research.index')->with('success', 'Research section heading updated.');
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
            'show_on_home' => 'boolean',
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
        $validated['show_on_home'] = $request->has('show_on_home');

        if ($redirect = $this->rejectExtraHomeSlot($request, $validated['category'])) {
            return $redirect;
        }

        $research = Research::create($validated);

        if ($research->is_active) {
            NewsletterNotifier::notify($research->title, $research->description, route('home') . '#research');
        }

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
            'show_on_home' => 'boolean',
            'order' => 'integer|min:0',
            'category_icon' => 'nullable|string'
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete old image
            if ($research->image_url) {
                MediaStorage::delete($research->image_url);
            }
            $imagePath = $request->file('image_url')->store('research/images', 'media');
            $validated['image_url'] = Storage::disk('media')->url($imagePath);
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video
            if ($research->video_file) {
                MediaStorage::delete($research->video_file);
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
        $validated['show_on_home'] = $request->has('show_on_home');

        if ($redirect = $this->rejectExtraHomeSlot($request, $validated['category'], $research->id)) {
            return $redirect;
        }

        $wasActive = (bool) $research->is_active;
        $research->update($validated);

        if ($research->is_active && ! $wasActive) {
            NewsletterNotifier::notify($research->title, $research->description, route('home') . '#research');
        }

        return redirect()->route('admin.research.index')
            ->with('success', 'Research item updated successfully.');
    }

    public function destroy(Research $research)
    {
        // Delete associated files
        if ($research->image_url) {
            MediaStorage::delete($research->image_url);
        }
        if ($research->video_file) {
            MediaStorage::delete($research->video_file);
        }

        $research->delete();

        return redirect()->route('admin.research.index')
            ->with('success', 'Research item deleted successfully.');
    }

    private function storagePath(string $value): string
    {
        return MediaStorage::path($value) ?? '';
    }

    public function toggleStatus($id)
    {
        try {
            $research = Research::findOrFail($id);
            $research->is_active = !$research->is_active;
            $research->save();

            if ($research->is_active) {
                NewsletterNotifier::notify($research->title, $research->description, route('home') . '#research');
            }

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

            if (! $research->is_featured) {
                Research::where('category', $research->category)
                    ->where('id', '!=', $research->id)
                    ->update(['is_featured' => false]);
            }

            $research->is_featured = ! $research->is_featured;
            $research->save();

            return response()->json([
                'success' => true,
                'is_featured' => $research->is_featured,
                'message' => $research->is_featured ? 'Marked as featured.' : 'Removed from featured.',
            ]);
        } catch (\Exception $e) {
            Log::error('Toggle Featured Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function toggleHome($id)
    {
        try {
            $research = Research::findOrFail($id);

            if (! $research->show_on_home && Research::homeSlotsUsed($research->category, $research->id) >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'This category already has 3 items on the homepage. Remove one before adding another.',
                ], 422);
            }

            $research->show_on_home = ! $research->show_on_home;
            $research->save();

            return response()->json([
                'success' => true,
                'show_on_home' => $research->show_on_home,
                'message' => $research->show_on_home ? 'Added to homepage.' : 'Removed from homepage.',
            ]);
        } catch (\Exception $e) {
            Log::error('Toggle Home Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function rejectExtraHomeSlot(Request $request, string $category, ?int $exceptId = null)
    {
        if (! $request->has('show_on_home')) {
            return null;
        }

        if (Research::homeSlotsUsed($category, $exceptId) >= 3) {
            return back()->withInput()->with('error', 'This category already has 3 items on the homepage. Remove one before adding another.');
        }

        return null;
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
