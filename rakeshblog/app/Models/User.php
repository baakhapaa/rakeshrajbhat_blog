<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
        'ip_address',
        'last_login_ip',
        'last_login_at',
        'total_points',
        'quiz_attempts',
        'correct_answers',
        'total_questions_answered',
        'profile_photo_path',
        'bio',
        'location',
        'website',
        'social_links',
        'email_verified_at',
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
            'is_active' => 'boolean',
            'social_links' => 'array',
        ];
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get the user's quiz results
     */
    public function quizResults()
    {
        return $this->hasMany(UserQuizResult::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the user's latest quiz result
     */
    public function latestQuizResult()
    {
        return $this->hasOne(UserQuizResult::class)->latest();
    }

    /**
     * Get the user's passed quizzes
     */
    public function passedQuizzes()
    {
        return $this->hasMany(UserQuizResult::class)->where('passed', true);
    }

    /**
     * Get the user's comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user's activity logs
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    /**
     * Get user initials (2 letters max)
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', trim($this->name));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 2);
    }

    /**
     * Get role badge class
     */
    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => 'bg-purple-500/20 text-purple-400 border border-purple-500/30',
            'editor' => 'bg-blue-500/20 text-blue-400 border border-blue-500/30',
            'user' => 'bg-gray-500/20 text-gray-400 border border-gray-500/30',
        ];
        return $badges[$this->role ?? 'user'] ?? $badges['user'];
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->is_active) {
            return 'bg-green-500/20 text-green-400 border border-green-500/30';
        }
        return 'bg-red-500/20 text-red-400 border border-red-500/30';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /**
     * Get role text (capitalized)
     */
    public function getRoleTextAttribute()
    {
        return ucfirst($this->role ?? 'User');
    }

    /**
     * Get formatted phone number
     */
    public function getPhoneFormattedAttribute()
    {
        return $this->phone ?? '-';
    }

    /**
     * Get formatted join date
     */
    public function getJoinedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('M d, Y') : '-';
    }

    /**
     * Get formatted last login date
     */
    public function getLastLoginFormattedAttribute()
    {
        return $this->last_login_at ? $this->last_login_at->format('M d, Y h:i A') : 'Never';
    }

    /**
     * Get full profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            if (str_starts_with($this->profile_photo_path, 'http://') || str_starts_with($this->profile_photo_path, 'https://')) {
                return $this->profile_photo_path;
            }

            return Storage::disk('media')->url($this->profile_photo_path);
        }
        return null;
    }

    /**
     * Get avatar (initials or photo)
     */
    public function getAvatarAttribute()
    {
        if ($this->profile_photo_path) {
            return $this->profile_photo_url;
        }
        return $this->initials;
    }

    /**
     * Get avatar HTML
     */
    public function getAvatarHtmlAttribute()
    {
        if ($this->profile_photo_path) {
            return '<img src="' . $this->profile_photo_url . '" alt="' . $this->name . '" class="w-8 h-8 rounded-full object-cover">';
        }
        return '<div class="w-8 h-8 rounded-full bg-[#D4AF37] text-[#0b0e12] flex items-center justify-center font-bold text-sm">' . $this->initials . '</div>';
    }

    /**
     * Get total points formatted
     */
    public function getPointsFormattedAttribute()
    {
        return number_format($this->total_points ?? 0);
    }

    /**
     * Get accuracy formatted with %
     */
    public function getAccuracyFormattedAttribute()
    {
        return $this->accuracy . '%';
    }

    /**
     * Get quiz completion rate
     */
    public function getCompletionRateAttribute()
    {
        $total = $this->quizResults()->count();
        if ($total === 0) return '0%';
        $passed = $this->passedQuizzes()->count();
        return round(($passed / $total) * 100) . '%';
    }

    /**
     * Get average score
     */
    public function getAverageScoreAttribute()
    {
        $avg = $this->quizResults()->avg('percentage');
        return $avg ? round($avg) . '%' : 'N/A';
    }

    /**
     * Get total quizzes taken
     */
    public function getTotalQuizzesTakenAttribute()
    {
        return $this->quizResults()->count();
    }

    // ==========================================
    // POINTS & RANKING METHODS
    // ==========================================

    /**
     * Add points to user
     */
    public function addPoints($points)
    {
        $this->total_points += $points;
        $this->save();
        return $this;
    }

    /**
     * Get user rank based on total points
     */
    public function getRankAttribute()
    {
        $rank = self::where('total_points', '>', $this->total_points)->count() + 1;
        return $rank;
    }

    /**
     * Get user level based on points
     */
    public function getLevelAttribute()
    {
        $points = $this->total_points ?? 0;
        if ($points < 100) return 'Beginner';
        if ($points < 500) return 'Explorer';
        if ($points < 1000) return 'Scholar';
        if ($points < 5000) return 'Master';
        return 'Legend';
    }

    /**
     * Get level icon
     */
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

    /**
     * Get level badge class
     */
    public function getLevelBadgeAttribute()
    {
        $level = $this->level;
        $badges = [
            'Beginner' => 'bg-green-500/20 text-green-400 border border-green-500/30',
            'Explorer' => 'bg-blue-500/20 text-blue-400 border border-blue-500/30',
            'Scholar' => 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30',
            'Master' => 'bg-purple-500/20 text-purple-400 border border-purple-500/30',
            'Legend' => 'bg-amber-500/20 text-amber-400 border border-amber-500/30',
        ];
        return $badges[$level] ?? $badges['Beginner'];
    }

    /**
     * Get points needed for next level
     */
    public function getNextLevelPointsAttribute()
    {
        $points = $this->total_points ?? 0;
        if ($points < 100) return 100 - $points;
        if ($points < 500) return 500 - $points;
        if ($points < 1000) return 1000 - $points;
        if ($points < 5000) return 5000 - $points;
        return 0;
    }

    /**
     * Get progress percentage to next level
     */
    public function getProgressAttribute()
    {
        $points = $this->total_points ?? 0;
        if ($points < 100) return ($points / 100) * 100;
        if ($points < 500) return (($points - 100) / 400) * 100;
        if ($points < 1000) return (($points - 500) / 500) * 100;
        if ($points < 5000) return (($points - 1000) / 4000) * 100;
        return 100;
    }

    /**
     * Get accuracy percentage
     */
    public function getAccuracyAttribute()
    {
        if ($this->total_questions_answered > 0) {
            return round(($this->correct_answers / $this->total_questions_answered) * 100);
        }
        return 0;
    }

    // ==========================================
    // BADGES
    // ==========================================

    /**
     * Get user badges
     */
    public function getBadgesAttribute()
    {
        $badges = [];
        
        // First Quiz Badge
        if ($this->quiz_attempts >= 1) {
            $badges[] = [
                'name' => 'First Quiz',
                'icon' => '🎯',
                'description' => 'Completed your first quiz',
                'earned_at' => $this->quizResults()->first()->created_at ?? now(),
            ];
        }
        
        // Quiz Master Badge
        if ($this->quiz_attempts >= 10) {
            $badges[] = [
                'name' => 'Quiz Master',
                'icon' => '👑',
                'description' => 'Completed 10 quizzes',
                'earned_at' => $this->created_at,
            ];
        }
        
        // Perfect Score Badge
        if ($this->correct_answers > 0 && $this->accuracy >= 100) {
            $badges[] = [
                'name' => 'Perfect Score',
                'icon' => '💯',
                'description' => 'Got 100% accuracy',
                'earned_at' => $this->created_at,
            ];
        }
        
        // Points Badges
        if ($this->total_points >= 100) {
            $badges[] = [
                'name' => '100 Points',
                'icon' => '🌟',
                'description' => 'Earned 100 points',
                'earned_at' => $this->created_at,
            ];
        }
        
        if ($this->total_points >= 500) {
            $badges[] = [
                'name' => '500 Points',
                'icon' => '⭐',
                'description' => 'Earned 500 points',
                'earned_at' => $this->created_at,
            ];
        }
        
        if ($this->total_points >= 1000) {
            $badges[] = [
                'name' => '1000 Points',
                'icon' => '🏅',
                'description' => 'Earned 1000 points',
                'earned_at' => $this->created_at,
            ];
        }

        if ($this->total_points >= 5000) {
            $badges[] = [
                'name' => 'Legendary',
                'icon' => '🏆',
                'description' => 'Earned 5000 points',
                'earned_at' => $this->created_at,
            ];
        }

        return $badges;
    }

    /**
     * Get badge count
     */
    public function getBadgeCountAttribute()
    {
        return count($this->badges);
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    /**
     * Check if user has admin role
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has editor role
     */
    public function isEditor()
    {
        return $this->role === 'editor';
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Check if email is verified
     */
    public function isEmailVerified()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $this->save();
        return $this;
    }

    /**
     * Update last login info
     */
    public function updateLastLogin($ip = null)
    {
        $this->last_login_at = now();
        if ($ip) {
            $this->last_login_ip = $ip;
        }
        $this->save();
        return $this;
    }

    /**
     * Get user statistics
     */
    public function getStats()
    {
        return [
            'total_points' => $this->total_points ?? 0,
            'quiz_attempts' => $this->quiz_attempts ?? 0,
            'correct_answers' => $this->correct_answers ?? 0,
            'total_questions_answered' => $this->total_questions_answered ?? 0,
            'accuracy' => $this->accuracy . '%',
            'level' => $this->level,
            'level_icon' => $this->level_icon,
            'rank' => $this->rank,
            'badges' => $this->badges,
            'badge_count' => $this->badge_count,
            'average_score' => $this->average_score,
            'completion_rate' => $this->completion_rate,
        ];
    }

    /**
     * Get dashboard stats for admin
     */
    public static function getDashboardStats()
    {
        return [
            'total_users' => self::count(),
            'active_users' => self::where('is_active', true)->count(),
            'inactive_users' => self::where('is_active', false)->count(),
            'admins' => self::where('role', 'admin')->count(),
            'editors' => self::where('role', 'editor')->count(),
            'new_today' => self::whereDate('created_at', today())->count(),
            'new_this_week' => self::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'top_performers' => self::orderBy('total_points', 'desc')->limit(10)->get(),
        ];
    }

    // ==========================================
    // SCOPES
    // ==========================================

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for users with specific role
     */
    public function scopeWithRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope for admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for editors
     */
    public function scopeEditors($query)
    {
        return $query->where('role', 'editor');
    }

    /**
     * Scope for top performers (by points)
     */
    public function scopeTopPerformers($query, $limit = 10)
    {
        return $query->orderBy('total_points', 'desc')->limit($limit);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope for users with at least one quiz attempt
     */
    public function scopeWithQuizAttempts($query)
    {
        return $query->where('quiz_attempts', '>', 0);
    }

    /**
     * Scope for users by date range
     */
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }
}