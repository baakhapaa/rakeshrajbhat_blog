<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['user', 'blog'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully!');
    }
}