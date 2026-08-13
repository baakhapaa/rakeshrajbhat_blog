<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'author',
        'is_published',
        'published_at',
        'views',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // ==========================================
    // SCOPES
    // ==========================================

    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    // Scope for draft posts
    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    // Scope for featured posts
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope for searching
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', '%' . $search . '%')
                     ->orWhere('content', 'LIKE', '%' . $search . '%')
                     ->orWhere('excerpt', 'LIKE', '%' . $search . '%');
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    // Get formatted date
    public function getFormattedDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('F d, Y') 
            : $this->created_at->format('F d, Y');
    }

    // Get formatted date for short display
    public function getShortDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('M d, Y') 
            : $this->created_at->format('M d, Y');
    }

    // Get reading time
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes . ' min read';
    }

    // Get excerpt if not set
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return Str::limit(strip_tags($this->content), 150);
    }

    // Get short title
    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, 30);
    }

    // Get tags as string
    public function getTagsStringAttribute()
    {
        if (is_array($this->tags)) {
            return implode(', ', $this->tags);
        }
        return $this->tags;
    }

    // ==========================================
    // HELPERS
    // ==========================================

    // Check if blog is published
    public function isPublished()
    {
        return $this->is_published && $this->published_at && $this->published_at <= now();
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Get previous blog
    public function getPrevious()
    {
        return self::where('id', '<', $this->id)
            ->where('is_published', true)
            ->orderBy('id', 'desc')
            ->first();
    }

    // Get next blog
    public function getNext()
    {
        return self::where('id', '>', $this->id)
            ->where('is_published', true)
            ->orderBy('id', 'asc')
            ->first();
    }

    // Get related blogs by category
    public function getRelated($limit = 3)
    {
        return self::where('category', $this->category)
            ->where('id', '!=', $this->id)
            ->where('is_published', true)
            ->limit($limit)
            ->get();
    }

    // ==========================================
    // BOOT METHOD
    // ==========================================

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug if not provided
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }
}