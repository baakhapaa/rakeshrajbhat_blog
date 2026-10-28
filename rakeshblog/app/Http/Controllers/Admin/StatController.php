<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use App\Models\Setting;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::ordered()->get();
        $statsSection = Setting::getStatsSection();

        return view('admin.stats.index', compact('stats', 'statsSection'));
    }

    public function updateSection(Request $request)
    {
        $validated = $request->validate([
            'stats_section_title' => 'required|string|max:80',
            'stats_section_description' => 'required|string|max:160',
        ]);

        Setting::setValue('stats_section_title', trim(strip_tags($validated['stats_section_title'])));
        Setting::setValue('stats_section_description', trim(strip_tags($validated['stats_section_description'])));

        return redirect()->route('admin.stats.index')->with('success', 'Stats heading updated.');
    }

    public function create()
    {
        return view('admin.stats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'sub_label' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        Stat::create([
            'number' => $validated['number'],
            'label' => $validated['label'],
            'sub_label' => $validated['sub_label'] ?? '',
            'icon' => $validated['icon'] ?? '',
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.stats.index')->with('success', 'Stat created successfully!');
    }

    public function show(Stat $stat)
    {
        return view('admin.stats.show', compact('stat'));
    }

    public function edit(Stat $stat)
    {
        return view('admin.stats.edit', compact('stat'));
    }

    public function update(Request $request, Stat $stat)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'sub_label' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $stat->update([
            'number' => $validated['number'],
            'label' => $validated['label'],
            'sub_label' => $validated['sub_label'] ?? '',
            'icon' => $validated['icon'] ?? '',
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.stats.index')->with('success', 'Stat updated successfully!');
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();
        return redirect()->route('admin.stats.index')->with('success', 'Stat deleted successfully!');
    }
}