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
        'published_at' => 'datetime',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

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
        return $this->quiz()->exists() && $this->quiz->questions()->count() > 0;
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
        if ($this->hasMultipleQuiz()) {
            $quiz = $this->quiz;
            return [
                'type' => 'multiple',
                'title' => $quiz->title,
                'description' => $quiz->description,
                'passing_score' => $quiz->passing_score,
                'questions' => $quiz->questions,
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
    // COMMENT HELPERS
    // ==========================================

    public function commentsCount()
    {
        return $this->comments()->count();
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