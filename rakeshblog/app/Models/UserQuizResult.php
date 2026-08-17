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
    ];

    protected $casts = [
        'passed' => 'boolean',
        'score' => 'integer',
        'correct_count' => 'integer',
        'total_questions' => 'integer',
        'percentage' => 'integer',
        'points_earned' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}