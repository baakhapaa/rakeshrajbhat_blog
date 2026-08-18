<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'correct_answer',
        'points',
        'order',
    ];

    protected $casts = [
        'points' => 'integer',
        'order' => 'integer',
        'correct_answer' => 'integer',
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getOptionsAttribute()
    {
        return [
            1 => $this->option_1,
            2 => $this->option_2,
            3 => $this->option_3,
            4 => $this->option_4,
        ];
    }

    public function getCorrectLetterAttribute()
    {
        $letters = ['', 'A', 'B', 'C', 'D'];
        return $letters[$this->correct_answer] ?? 'Not set';
    }

    // Helper methods
    public function getOptionLetter($index)
    {
        $letters = ['', 'A', 'B', 'C', 'D'];
        return $letters[$index] ?? 'Unknown';
    }

    public function getOptionByIndex($index)
    {
        $options = $this->getOptionsAttribute();
        return $options[$index] ?? null;
    }

    public function isCorrectAnswer($userAnswerIndex)
    {
        return (int)$userAnswerIndex === (int)$this->correct_answer;
    }
}