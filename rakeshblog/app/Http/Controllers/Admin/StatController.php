<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::ordered()->get();
        return view('admin.stats.index', compact('stats'));
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