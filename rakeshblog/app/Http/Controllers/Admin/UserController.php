<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status == 'active');
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $users = $query->paginate(15);
        $users->appends($request->all());

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::with(['quizResults', 'comments'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string|in:user,admin,editor',
            'is_active' => 'nullable|boolean',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->role = $validated['role'] ?? 'user';
        $user->is_active = $request->has('is_active');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Log user update
        ActivityLogger::log('user_updated', 'Updated user profile for "' . $user->name . '"', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        // Log user deletion
        ActivityLogger::log('user_deleted', 'Deleted user "' . $userName . '"', [
            'user_id' => $id
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot change your own status.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        // Log status change
        ActivityLogger::log('user_status_changed', 'Changed user "' . $user->name . '" status to ' . ($user->is_active ? 'Active' : 'Inactive'), [
            'user_id' => $user->id,
            'new_status' => $user->is_active ? 'Active' : 'Inactive'
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} has been " . ($user->is_active ? 'activated' : 'deactivated') . ".");
    }

    /**
     * Export users to CSV.
     */
    public function export()
    {
        try {
            $users = User::all();
            
            if ($users->isEmpty()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'No users found to export!');
            }
            
            $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            $callback = function() use ($users) {
                $file = fopen('php://output', 'w');
                
                // Add UTF-8 BOM for Excel compatibility
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // Add CSV headers
                fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Role', 'Status', 'Points', 'Quiz Attempts', 'Accuracy', 'Joined']);

                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->phone ?? '-',
                        $user->role ?? 'user',
                        $user->is_active ? 'Active' : 'Inactive',
                        $user->total_points ?? 0,
                        $user->quiz_attempts ?? 0,
                        $user->accuracy ?? '0%',
                        $user->created_at->format('Y-m-d'),
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            \Log::error('User export failed: ' . $e->getMessage());
            return redirect()->route('admin.users.index')
                ->with('error', 'Failed to export users. Please try again.');
        }
    }
}