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
}
