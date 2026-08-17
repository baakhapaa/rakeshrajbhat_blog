<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'user_id',
        'content',
    ];

    protected $appends = ['time_ago', 'likes_count'];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get the blog that owns the comment.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all likes for this comment.
     */
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    /**
     * Get formatted date attribute.
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('F d, Y');
    }

    /**
     * Get time ago attribute.
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get likes count attribute.
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    /**
     * Check if comment is liked by a specific user.
     */
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Check if comment can be edited by a specific user.
     */
    public function canEdit($userId)
    {
        return $this->user_id === $userId;
    }

    /**
     * Check if comment can be deleted by a specific user.
     */
    public function canDelete($userId, $isAdmin = false)
    {
        return $this->user_id === $userId || $isAdmin;
    }

    // ==========================================
    // SCOPES
    // ==========================================

    /**
     * Scope a query to only include recent comments.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to only include comments with likes.
     */
    public function scopeWithLikesCount($query)
    {
        return $query->withCount('likes');
    }

    // ==========================================
    // EVENTS
    // ==========================================

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // When a comment is deleted, delete its likes
        static::deleting(function ($comment) {
            $comment->likes()->delete();
        });
    }
}