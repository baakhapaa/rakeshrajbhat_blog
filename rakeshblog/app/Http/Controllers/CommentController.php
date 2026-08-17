<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'content' => 'required|string|max:5000',
        ]);

        $comment = Comment::create([
            'blog_id' => $request->blog_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        
        // Check if user owns the comment
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this comment.');
        }

        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Check if user owns the comment or is admin
        if ($comment->user_id !== Auth::id() && !Auth::guard('admin')->check()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }

    /**
     * Like a comment.
     */
    public function like($id)
    {
        $comment = Comment::findOrFail($id);
        $userId = Auth::id();

        // Check if user already liked this comment
        if ($comment->likes()->where('user_id', $userId)->exists()) {
            return redirect()->back()->with('error', 'You already liked this comment.');
        }

        $comment->likes()->create(['user_id' => $userId]);

        return redirect()->back()->with('success', 'Comment liked!');
    }

    /**
     * Unlike a comment.
     */
    public function unlike($id)
    {
        $comment = Comment::findOrFail($id);
        $userId = Auth::id();

        $like = $comment->likes()->where('user_id', $userId)->first();
        
        if ($like) {
            $like->delete();
            return redirect()->back()->with('success', 'Comment unliked.');
        }

        return redirect()->back()->with('error', 'You have not liked this comment.');
    }
}