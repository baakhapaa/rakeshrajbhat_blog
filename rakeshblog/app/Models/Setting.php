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
            'nav_items' => static::getNavItems(),
        ];
    }

    public static function navIconOptions(): array
    {
        return [
            'fa-solid fa-house' => 'Home',
            'fa-solid fa-bullseye' => 'Mission',
            'fa-solid fa-rocket' => 'Initiatives',
            'fa-solid fa-chart-line' => 'Impact',
            'fa-solid fa-lightbulb' => 'Ideas',
            'fa-solid fa-newspaper' => 'Blog',
            'fa-solid fa-book-open' => 'Stories',
            'fa-solid fa-handshake' => 'Work',
            'fa-solid fa-envelope' => 'Contact',
            'fa-solid fa-user' => 'About',
            'fa-solid fa-globe' => 'Website',
            'fa-solid fa-graduation-cap' => 'Education',
            'fa-solid fa-users' => 'People',
            'fa-solid fa-mountain' => 'Nation',
            'fa-solid fa-link' => 'Link',
        ];
    }

    public static function defaultNavItems(): array
    {
        return [
            ['label' => 'Home', 'url' => '#home', 'icon' => 'fa-solid fa-house'],
            ['label' => 'Mission', 'url' => '#about', 'icon' => 'fa-solid fa-bullseye'],
            ['label' => 'Initiatives', 'url' => '#projects', 'icon' => 'fa-solid fa-rocket'],
            ['label' => 'Impact', 'url' => '#impact', 'icon' => 'fa-solid fa-chart-line'],
            ['label' => 'Ideas & Research', 'url' => '#research', 'icon' => 'fa-solid fa-lightbulb'],
            ['label' => 'Blog', 'url' => '#featured-blogs', 'icon' => 'fa-solid fa-newspaper'],
            ['label' => 'Work With Me', 'url' => '#work-with-me', 'icon' => 'fa-solid fa-handshake'],
        ];
    }

    public static function navOpensWorkWithMe(string $url): bool
    {
        return $url === '#work-with-me';
    }

    public static function getNavItems(): array
    {
        $raw = static::getValue('nav_items');
        $decoded = is_string($raw) ? json_decode($raw, true) : null;

        if (! is_array($decoded) || $decoded === []) {
            return static::defaultNavItems();
        }

        $icons = static::navIconOptions();
        $items = [];

        foreach ($decoded as $item) {
            if (! is_array($item)) {
                continue;
            }

            $label = trim(strip_tags((string) ($item['label'] ?? '')));
            $url = trim((string) ($item['url'] ?? ''));
            $icon = (string) ($item['icon'] ?? '');

            if ($label === '' || $url === '' || ! static::navUrlIsSafe($url)) {
                continue;
            }

            if (! array_key_exists($icon, $icons)) {
                $icon = 'fa-solid fa-link';
            }

            $items[] = [
                'label' => $label,
                'url' => $url,
                'icon' => $icon,
            ];
        }

        return $items !== [] ? $items : static::defaultNavItems();
    }

    public static function navHref(string $url): string
    {
        if (str_starts_with($url, '#')) {
            return route('home').$url;
        }

        return $url;
    }

    public static function navUrlIsSafe(string $url): bool
    {
        if (str_starts_with($url, '#') && ! str_contains($url, ' ')) {
            return true;
        }

        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        return (bool) preg_match('#^https?://#i', $url);
    }
}
