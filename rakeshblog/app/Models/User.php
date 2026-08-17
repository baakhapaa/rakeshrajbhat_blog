<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'ip_address',
        'last_login_ip',
        'last_login_at',
        'total_points',
        'quiz_attempts',
        'correct_answers',
        'total_questions_answered',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'total_points' => 'integer',
            'quiz_attempts' => 'integer',
            'correct_answers' => 'integer',
            'total_questions_answered' => 'integer',
        ];
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function quizResults()
    {
        return $this->hasMany(UserQuizResult::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ==========================================
    // POINTS METHODS
    // ==========================================

    public function addPoints($points)
    {
        $this->total_points += $points;
        $this->save();
        return $this;
    }

    public function getRankAttribute()
    {
        $rank = self::where('total_points', '>', $this->total_points)->count() + 1;
        return $rank;
    }

    public function getLevelAttribute()
    {
        $points = $this->total_points ?? 0;
        if ($points < 100) return 'Beginner';
        if ($points < 500) return 'Explorer';
        if ($points < 1000) return 'Scholar';
        if ($points < 5000) return 'Master';
        return 'Legend';
    }

    public function getLevelIconAttribute()
    {
        $level = $this->level;
        $icons = [
            'Beginner' => '🌱',
            'Explorer' => '🧭',
            'Scholar' => '📚',
            'Master' => '⭐',
            'Legend' => '🏆',
        ];
        return $icons[$level] ?? '🌱';
    }

    public function getNextLevelPointsAttribute()
    {
        $points = $this->total_points ?? 0;
        if ($points < 100) return 100 - $points;
        if ($points < 500) return 500 - $points;
        if ($points < 1000) return 1000 - $points;
        if ($points < 5000) return 5000 - $points;
        return 0;
    }

    public function getProgressAttribute()
    {
        $points = $this->total_points ?? 0;
        if ($points < 100) return ($points / 100) * 100;
        if ($points < 500) return (($points - 100) / 400) * 100;
        if ($points < 1000) return (($points - 500) / 500) * 100;
        if ($points < 5000) return (($points - 1000) / 4000) * 100;
        return 100;
    }

    public function getAccuracyAttribute()
    {
        if ($this->total_questions_answered > 0) {
            return round(($this->correct_answers / $this->total_questions_answered) * 100);
        }
        return 0;
    }

    public function getBadgesAttribute()
    {
        $badges = [];
        
        if ($this->quiz_attempts >= 1) {
            $badges[] = [
                'name' => 'First Quiz',
                'icon' => '🎯',
                'description' => 'Completed your first quiz',
            ];
        }
        
        if ($this->quiz_attempts >= 10) {
            $badges[] = [
                'name' => 'Quiz Master',
                'icon' => '👑',
                'description' => 'Completed 10 quizzes',
            ];
        }
        
        if ($this->correct_answers > 0 && $this->accuracy >= 100) {
            $badges[] = [
                'name' => 'Perfect Score',
                'icon' => '💯',
                'description' => 'Got 100% accuracy',
            ];
        }
        
        if ($this->total_points >= 100) {
            $badges[] = [
                'name' => '100 Points',
                'icon' => '🌟',
                'description' => 'Earned 100 points',
            ];
        }
        
        if ($this->total_points >= 500) {
            $badges[] = [
                'name' => '500 Points',
                'icon' => '⭐',
                'description' => 'Earned 500 points',
            ];
        }
        
        if ($this->total_points >= 1000) {
            $badges[] = [
                'name' => '1000 Points',
                'icon' => '🏅',
                'description' => 'Earned 1000 points',
            ];
        }
        
        return $badges;
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 2);
    }
}