<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'correct_count',
        'total_questions',
        'percentage',
        'passed',
        'points_earned',
        'answers',
        'details',
        'wrong_questions',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'score' => 'integer',
        'correct_count' => 'integer',
        'total_questions' => 'integer',
        'percentage' => 'integer',
        'points_earned' => 'integer',
        'answers' => 'array',
        'details' => 'array',
        'wrong_questions' => 'array',
    ];

    protected $appends = [
        'passed_text',
        'status_text',
        'formatted_date',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get the user who took the quiz
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz that was taken
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    /**
     * Get passed status as text
     */
    public function getPassedTextAttribute()
    {
        return $this->passed ? '✅ Passed' : '❌ Failed';
    }

    /**
     * Get status with badge class
     */
    public function getStatusTextAttribute()
    {
        if ($this->passed) {
            return [
                'text' => 'Passed',
                'badge' => 'bg-green-500/20 text-green-400 border border-green-500/30',
                'icon' => '✅',
            ];
        }
        return [
            'text' => 'Failed',
            'badge' => 'bg-red-500/20 text-red-400 border border-red-500/30',
            'icon' => '❌',
        ];
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('M d, Y h:i A') : '-';
    }

    /**
     * Get score as percentage with % sign
     */
    public function getScorePercentageAttribute()
    {
        return $this->percentage . '%';
    }

    /**
     * Get points earned with badge
     */
    public function getPointsDisplayAttribute()
    {
        return $this->points_earned . ' pts';
    }

    /**
     * Get answers summary (how many correct out of total)
     */
    public function getSummaryAttribute()
    {
        return "{$this->correct_count}/{$this->total_questions} correct";
    }

    /**
     * Get performance level
     */
    public function getPerformanceAttribute()
    {
        if ($this->percentage >= 90) return 'Excellent';
        if ($this->percentage >= 80) return 'Good';
        if ($this->percentage >= 70) return 'Fair';
        if ($this->percentage >= 60) return 'Average';
        return 'Needs Improvement';
    }

    /**
     * Get wrong questions count
     */
    public function getWrongCountAttribute()
    {
        return $this->total_questions - $this->correct_count;
    }

    // ==========================================
    // HELPERS
    // ==========================================

    /**
     * Check if user passed
     */
    public function isPassed()
    {
        return $this->passed;
    }

    /**
     * Get wrong answers details
     */
    public function getWrongAnswers()
    {
        if ($this->details) {
            return collect($this->details)->where('correct', false)->values();
        }
        return collect();
    }

    /**
     * Get correct answers details
     */
    public function getCorrectAnswers()
    {
        if ($this->details) {
            return collect($this->details)->where('correct', true)->values();
        }
        return collect();
    }

    /**
     * Get review data for learning
     */
    public function getReviewData()
    {
        return [
            'passed' => $this->passed,
            'percentage' => $this->percentage,
            'wrong_questions' => $this->getWrongAnswers(),
            'score' => $this->score,
            'points_earned' => $this->points_earned,
        ];
    }
}