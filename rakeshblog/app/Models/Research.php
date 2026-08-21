<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Research extends Model
{
    use HasFactory;

    protected $table = 'research';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'content',
        'image_url',
        'video_url',
        'video_file',
        'link_url',
        'is_active',
        'is_featured',
        'order',
        'category_icon'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer'
    ];

    // Auto-generate slug and handle featured logic
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($research) {
            if (empty($research->slug)) {
                $research->slug = Str::slug($research->title);
            }
        });

        // Ensure only one featured per category
        static::saving(function ($research) {
            if ($research->is_featured) {
                // Un-feature any other item in the same category
                self::where('category', $research->category)
                    ->where('id', '!=', $research->id)
                    ->update(['is_featured' => false]);
            }
        });
    }

    // Get video embed URL for YouTube/Vimeo
    public function getVideoEmbedUrlAttribute()
    {
        if ($this->video_url) {
            // YouTube
            if (strpos($this->video_url, 'youtube.com') !== false || strpos($this->video_url, 'youtu.be') !== false) {
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
                return isset($matches[1]) ? 'https://www.youtube.com/embed/' . $matches[1] : null;
            }
            // Vimeo
            if (strpos($this->video_url, 'vimeo.com') !== false) {
                preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
                return isset($matches[1]) ? 'https://player.vimeo.com/video/' . $matches[1] : null;
            }
        }
        return null;
    }

    // Get video thumbnail
    public function getVideoThumbnailAttribute()
    {
        if ($this->video_url) {
            if (strpos($this->video_url, 'youtube.com') !== false || strpos($this->video_url, 'youtu.be') !== false) {
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
                if (isset($matches[1])) {
                    return 'https://img.youtube.com/vi/' . $matches[1] . '/mqdefault.jpg';
                }
            }
        }
        return $this->image_url ?? null;
    }

    // Get default icon based on category
    public function getCategoryIconAttribute()
    {
        $icons = [
            'Vision' => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>',
            'Research Papers' => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>',
            'Media' => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>'
        ];

        return $this->attributes['category_icon'] ?? ($icons[$this->category] ?? $icons['Vision']);
    }
}