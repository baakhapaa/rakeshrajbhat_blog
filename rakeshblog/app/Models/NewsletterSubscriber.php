<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'confirmation_token',
        'confirmed_at',
        'consented_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'consented_at' => 'datetime',
    ];

    public function status(): string
    {
        if ($this->confirmed_at) {
            return 'confirmed';
        }

        if ($this->confirmation_token) {
            return 'pending';
        }

        return 'unsubscribed';
    }

    public function scopeWithStatus($query, string $status)
    {
        return match ($status) {
            'confirmed' => $query->whereNotNull('confirmed_at'),
            'pending' => $query->whereNull('confirmed_at')->whereNotNull('confirmation_token'),
            'unsubscribed' => $query->whereNull('confirmed_at')->whereNull('confirmation_token'),
            default => $query,
        };
    }
}
