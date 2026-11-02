<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteVisit extends Model
{
    protected $fillable = [
        'visitor_hash',
        'session_id',
        'landing_path',
        'referrer_host',
        'source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'country',
        'city',
        'device',
        'browser',
        'os',
    ];

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }
}
