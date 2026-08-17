<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        return view('admin.team-members.index');
    }

    public function create()
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request)
    {
        // Store logic here
        return redirect()->route('admin.team-members.index')->with('success', 'Team member created successfully!');
    }

    public function show($id)
    {
        return view('admin.team-members.show');
    }

    public function edit($id)
    {
        return view('admin.team-members.edit');
    }

    public function update(Request $request, $id)
    {
        // Update logic here
        return redirect()->route('admin.team-members.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy($id)
    {
        // Delete logic here
        return redirect()->route('admin.team-members.index')->with('success', 'Team member deleted successfully!');
    }
}