<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'title',
        'description',
        'passing_score',
        'total_points',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Helper methods
    public function getTotalQuestionsAttribute()
    {
        return $this->questions()->count();
    }

    public function getMaxPossiblePointsAttribute()
    {
        return $this->questions()->sum('points');
    }

    public function hasQuiz()
    {
        return $this->questions()->count() > 0;
    }
}