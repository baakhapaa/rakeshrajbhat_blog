<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        if (!Schema::hasTable('settings')) {
            return $default;
        }

        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );
    }

    public static function getSiteSettings(): array
    {
        return [
            'site_name' => static::getValue('site_name', 'Rakesh Rajbhat'),
            'site_description' => static::getValue('site_description', 'Official website of Rakesh Rajbhat - Founder, Builder, Future Maker'),
            'site_logo' => static::getValue('site_logo'),
            'site_favicon' => static::getValue('site_favicon'),
        ];
    }
}
