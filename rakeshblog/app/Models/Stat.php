<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'number',
        'label',
        'sub_label',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active stats
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered stats
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}