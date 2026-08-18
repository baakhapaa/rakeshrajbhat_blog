<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('order')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:500',
            'image' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:20',
            'bg_color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        // Generate unique slug
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $project = Project::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'url' => $validated['url'] ?? null,
            'image' => $imagePath,
            'color' => $validated['color'] ?? '#D4AF37',
            'bg_color' => $validated['bg_color'] ?? '#fff6e0',
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLogger::log('project_created', 'Created project "' . $project->name . '"');

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:500',
            'image' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:20',
            'bg_color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $imagePath = $request->file('image')->store('projects', 'public');
            $project->image = $imagePath;
        }

        // Generate unique slug (except for current project)
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $project->name = $validated['name'];
        $project->slug = $slug;
        $project->short_description = $validated['short_description'] ?? null;
        $project->description = $validated['description'] ?? null;
        $project->url = $validated['url'] ?? null;
        $project->color = $validated['color'] ?? '#D4AF37';
        $project->bg_color = $validated['bg_color'] ?? '#fff6e0';
        $project->is_active = $request->has('is_active');
        $project->order = $validated['order'] ?? 0;
        $project->save();

        ActivityLogger::log('project_updated', 'Updated project "' . $project->name . '"');

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $name = $project->name;

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        ActivityLogger::log('project_deleted', 'Deleted project "' . $name . '"');

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    public function reorder(Request $request)
    {
        $orders = $request->input('orders', []);
        foreach ($orders as $id => $order) {
            Project::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $project = Project::findOrFail($id);
        $project->is_active = !$project->is_active;
        $project->save();

        ActivityLogger::log('project_status_toggled', 'Changed project "' . $project->name . '" status to ' . ($project->is_active ? 'Active' : 'Inactive'));

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project status updated!');
    }
}