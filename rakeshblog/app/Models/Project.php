<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'url',
        'image',
        'color',
        'bg_color',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $slug = Str::slug($project->name);
                $originalSlug = $slug;
                $counter = 1;
                
                while (self::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                $project->slug = $slug;
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('name')) {
                $slug = Str::slug($project->name);
                $originalSlug = $slug;
                $counter = 1;
                
                while (self::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                $project->slug = $slug;
            }
        });
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }

            $disk = config('filesystems.disks.media.driver') ? 'media' : 'public';

            return Storage::disk($disk)->url($this->image);
        }
        return null;
    }

    /**
     * Get the short description attribute.
     */
    public function getShortDescriptionAttribute($value)
    {
        return $value ?? 'Click to learn more about this project.';
    }

    /**
     * Get the full description attribute.
     */
    public function getFullDescriptionAttribute()
    {
        return $this->description ?? $this->short_description;
    }

    /**
     * Get the color attribute with fallback.
     */
    public function getColorAttribute($value)
    {
        return $value ?? '#D4AF37';
    }

    /**
     * Get the bg_color attribute with fallback.
     */
    public function getBgColorAttribute($value)
    {
        return $value ?? '#fff6e0';
    }

    /**
     * Check if project is active.
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Scope a query to only include active projects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order projects by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}