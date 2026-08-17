<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'user_id',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get the comment that owns the like.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Get the user that owns the like.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ==========================================
    // HELPERS
    // ==========================================

    /**
     * Check if a user has liked a comment.
     */
    public static function exists($commentId, $userId)
    {
        return self::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Create a like for a comment.
     */
    public static function createLike($commentId, $userId)
    {
        return self::create([
            'comment_id' => $commentId,
            'user_id' => $userId,
        ]);
    }

    /**
     * Remove a like from a comment.
     */
    public static function removeLike($commentId, $userId)
    {
        return self::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->delete();
    }
}