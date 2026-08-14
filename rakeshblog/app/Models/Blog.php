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
    // MUTATORS
    // ==========================================

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = html_entity_decode($value);
    }

    public function getContentAttribute($value)
    {
        return $value ?? '';
    }

    public function setTagsAttribute($value)
    {
        if (is_string($value)) {
            $tags = array_map('trim', explode(',', $value));
            $tags = array_filter($tags);
            $this->attributes['tags'] = json_encode(array_values($tags));
        } else {
            $this->attributes['tags'] = json_encode($value ?? []);
        }
    }

    public function getTagsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        $tags = json_decode($value, true);
        return is_array($tags) ? $tags : [];
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', '%' . $search . '%')
                     ->orWhere('content', 'LIKE', '%' . $search . '%')
                     ->orWhere('excerpt', 'LIKE', '%' . $search . '%');
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    public function getFormattedDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('F d, Y') 
            : $this->created_at->format('F d, Y');
    }

    public function getShortDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('M d, Y') 
            : $this->created_at->format('M d, Y');
    }

    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        $minutes = max(1, ceil($words / 200));
        return $minutes . ' min read';
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return Str::limit(strip_tags($this->content ?? ''), 150);
    }

    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, 30);
    }

    public function getTagsStringAttribute()
    {
        $tags = $this->getTagsAttribute($this->attributes['tags'] ?? null);
        if (is_array($tags) && count($tags) > 0) {
            return implode(', ', $tags);
        }
        return '';
    }

    // ==========================================
    // HELPERS
    // ==========================================

    public function isPublished()
    {
        return $this->is_published && $this->published_at && $this->published_at <= now();
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getPrevious()
    {
        return self::where('id', '<', $this->id)
            ->where('is_published', true)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getNext()
    {
        return self::where('id', '>', $this->id)
            ->where('is_published', true)
            ->orderBy('id', 'asc')
            ->first();
    }

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
                $slug = Str::slug($blog->title);
                $originalSlug = $slug;
                $counter = 1;
                
                while (self::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                $blog->slug = $slug;
            }
        });

        // Update slug if title changes
        static::updating(function ($blog) {
            if ($blog->isDirty('title')) {
                $slug = Str::slug($blog->title);
                $originalSlug = $slug;
                $counter = 1;
                
                while (self::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                $blog->slug = $slug;
            }
        });
    }
}