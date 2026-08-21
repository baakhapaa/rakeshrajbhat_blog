<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BootcampRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_name',
        'district',
        'contact_person',
        'contact_email',
        'contact_phone',
        'participants',
        'preferred_date',
        'audience',
        'requirements',
        'status'
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'participants' => 'integer'
    ];
}