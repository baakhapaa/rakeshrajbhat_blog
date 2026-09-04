<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        'user_id',
        'is_published',
        'is_featured',
        'published_at',
        'views',
        'quiz_question',
        'quiz_option_1',
        'quiz_option_2',
        'quiz_option_3',
        'quiz_option_4',
        'quiz_correct_answer',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    protected $appends = [
        'reading_time',
        'has_quiz',
        'formatted_date',
        'short_date',
        'featured_image_url',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get the user who authored the blog.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get comments for the blog (approved comments only).
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get all comments (including unapproved) for admin.
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the quiz associated with the blog (One-to-One - Legacy).
     */
    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    /**
     * Get all quizzes for this blog (One-to-Many - New).
     * This allows multiple quizzes per blog.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the active quiz for this blog.
     */
    public function activeQuiz()
    {
        return $this->hasOne(Quiz::class)->where('is_active', true)->with('questions');
    }

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
    // ACCESSORS
    // ==========================================

    /**
     * Get formatted date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('F d, Y') 
            : ($this->created_at ? $this->created_at->format('F d, Y') : null);
    }

    /**
     * Get short date.
     */
    public function getShortDateAttribute()
    {
        return $this->published_at 
            ? $this->published_at->format('M d, Y') 
            : ($this->created_at ? $this->created_at->format('M d, Y') : null);
    }

    /**
     * Get reading time in minutes.
     */
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        $minutes = max(1, ceil($words / 200));
        return $minutes . ' min read';
    }

    /**
     * Get excerpt with fallback.
     */
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return Str::limit(strip_tags($this->content ?? ''), 150);
    }

    /**
     * Get short title.
     */
    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, 30);
    }

    /**
     * Get tags as string.
     */
    public function getTagsStringAttribute()
    {
        $tags = $this->getTagsAttribute($this->attributes['tags'] ?? null);
        if (is_array($tags) && count($tags) > 0) {
            return implode(', ', $tags);
        }
        return '';
    }

    /**
     * Get featured image URL - IMPROVED VERSION
     * Handles all possible image path formats:
     * - Full URLs (https://...)
     * - Storage paths (/storage/... or storage/...)
     * - Relative paths (blog-images/...)
     */
    public function getFeaturedImageUrlAttribute()
    {
        if (empty($this->featured_image)) {
            return null;
        }

        $path = $this->featured_image;

        // 1. If it's already a full URL (starts with http:// or https://)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // 2. If it starts with /storage/, remove the leading slash
        if (str_starts_with($path, '/storage/')) {
            return $this->mediaUrl(ltrim(substr($path, strlen('/storage/')), '/'));
        }

        // 3. If it starts with storage/ (without slash)
        if (str_starts_with($path, 'storage/')) {
            return $this->mediaUrl(ltrim(substr($path, strlen('storage/')), '/'));
        }

        // 4. Default: assume it's a storage path
        return $this->mediaUrl($path);
    }

    private function mediaUrl(string $path): string
    {
        $disk = config('filesystems.disks.media.driver') ? 'media' : 'public';

        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if blog has a quiz.
     */
    public function getHasQuizAttribute()
    {
        return $this->hasLegacyQuiz() || $this->hasMultipleQuiz();
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->is_published) {
            return 'bg-green-500/20 text-green-400 border border-green-500/30';
        }
        return 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30';
    }

    /**
     * Get status text.
     */
    public function getStatusTextAttribute()
    {
        return $this->is_published ? 'Published' : 'Draft';
    }

    /**
     * Get featured badge class.
     */
    public function getFeaturedBadgeAttribute()
    {
        if ($this->is_featured) {
            return 'bg-[#D4AF37]/20 text-[#D4AF37] border border-[#D4AF37]/30';
        }
        return 'bg-gray-500/20 text-gray-400 border border-gray-500/30';
    }

    /**
     * Get featured text.
     */
    public function getFeaturedTextAttribute()
    {
        return $this->is_featured ? '⭐ Featured' : 'Not Featured';
    }

    // ==========================================
    // QUIZ HELPERS
    // ==========================================

    /**
     * Check if blog has a quiz (single question - legacy).
     */
    public function hasLegacyQuiz()
    {
        return $this->quiz_question && 
               $this->quiz_option_1 && 
               $this->quiz_option_2 && 
               $this->quiz_option_3 && 
               $this->quiz_option_4 && 
               $this->quiz_correct_answer !== null;
    }

    /**
     * Check if blog has a multiple question quiz.
     */
    public function hasMultipleQuiz()
    {
        return $this->quizzes()->where('is_active', true)->exists();
    }

    /**
     * Check if blog has any quiz (legacy or multiple).
     */
    public function hasQuiz()
    {
        return $this->hasLegacyQuiz() || $this->hasMultipleQuiz();
    }

    /**
     * Get quiz data for frontend display.
     */
    public function getQuizData()
    {
        // First check for multiple question quiz
        $activeQuiz = $this->quizzes()->where('is_active', true)->with('questions')->first();
        if ($activeQuiz) {
            return [
                'type' => 'multiple',
                'id' => $activeQuiz->id,
                'title' => $activeQuiz->title,
                'description' => $activeQuiz->description,
                'passing_score' => $activeQuiz->passing_score,
                'questions' => $activeQuiz->questions,
            ];
        }
        
        // Then check for legacy single question quiz
        if ($this->hasLegacyQuiz()) {
            return [
                'type' => 'single',
                'question' => $this->quiz_question,
                'options' => $this->getQuizOptionsAttribute(),
                'correct_answer' => $this->quiz_correct_answer,
                'correct_letter' => $this->getCorrectAnswerLetterAttribute(),
            ];
        }

        return null;
    }

    public function getQuizOptionsAttribute()
    {
        return [
            1 => $this->quiz_option_1,
            2 => $this->quiz_option_2,
            3 => $this->quiz_option_3,
            4 => $this->quiz_option_4,
        ];
    }

    public function getCorrectAnswerLetterAttribute()
    {
        $letters = ['', 'A', 'B', 'C', 'D'];
        return $letters[$this->quiz_correct_answer] ?? 'Not set';
    }

    // ==========================================
    // SCOPES
    // ==========================================

    /**
     * Scope to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope to only include draft blogs.
     */
    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    /**
     * Scope to only include featured blogs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to search blogs.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', '%' . $search . '%')
              ->orWhere('content', 'LIKE', '%' . $search . '%')
              ->orWhere('excerpt', 'LIKE', '%' . $search . '%')
              ->orWhere('category', 'LIKE', '%' . $search . '%')
              ->orWhere('tags', 'LIKE', '%' . $search . '%');
        });
    }

    /**
     * Scope to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to get popular blogs.
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->orderBy('views', 'desc')->limit($limit);
    }

    /**
     * Scope to get recent blogs.
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    /**
     * Scope to get blogs with quiz.
     */
    public function scopeWithQuiz($query)
    {
        return $query->has('quizzes');
    }

    /**
     * Scope to get blogs without quiz.
     */
    public function scopeWithoutQuiz($query)
    {
        return $query->doesntHave('quizzes');
    }

    // ==========================================
    // COMMENT HELPERS
    // ==========================================

    /**
     * Get total approved comments count.
     */
    public function commentsCount()
    {
        return $this->comments()->count();
    }

    /**
     * Get total comments count (including unapproved).
     */
    public function totalCommentsCount()
    {
        return $this->allComments()->count();
    }

    // ==========================================
    // HELPERS
    // ==========================================

    /**
     * Check if blog is published.
     */
    public function isPublished()
    {
        return $this->is_published && $this->published_at && $this->published_at <= now();
    }

    /**
     * Check if blog is featured.
     */
    public function isFeatured()
    {
        return $this->is_featured;
    }

    /**
     * Increment view count.
     */
    public function incrementViews()
    {
        $this->increment('views');
        return $this;
    }

    /**
     * Get previous blog post.
     */
    public function getPrevious()
    {
        return self::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('published_at', '<', $this->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    }

    /**
     * Get next blog post.
     */
    public function getNext()
    {
        return self::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('published_at', '>', $this->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
    }

    /**
     * Get related blogs (same category).
     */
    public function getRelated($limit = 3)
    {
        return self::where('category', $this->category)
            ->where('id', '!=', $this->id)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all categories with blog count.
     */
    public static function getCategoriesWithCount()
    {
        return self::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->select('category')
            ->selectRaw('count(*) as total')
            ->groupBy('category')
            ->get();
    }

    /**
     * Get blog archives by year/month.
     */
    public static function getArchives()
    {
        return self::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->selectRaw('YEAR(published_at) as year')
            ->selectRaw('MONTH(published_at) as month')
            ->selectRaw('MONTHNAME(published_at) as month_name')
            ->selectRaw('count(*) as total')
            ->groupBy('year', 'month', 'month_name')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    /**
     * Get dashboard stats for admin.
     */
    public static function getDashboardStats()
    {
        return [
            'total' => self::count(),
            'published' => self::where('is_published', true)->count(),
            'drafts' => self::where('is_published', false)->count(),
            'featured' => self::where('is_featured', true)->count(),
            'with_quiz' => self::has('quizzes')->count(),
            'most_viewed' => self::orderBy('views', 'desc')->first(),
            'recent_published' => self::where('is_published', true)
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    // ==========================================
    // BOOT METHOD (Auto-generate slug)
    // ==========================================

    protected static function boot()
    {
        parent::boot();

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