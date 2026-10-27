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
            'projects_section' => static::getProjectsSection(),
        ];
    }

    public static function defaultHomeContent(): array
    {
        return [
            'eyebrow' => 'Founder · Builder · Future Maker',
            'headline_line_1' => 'Building Opportunities',
            'headline_line_2' => 'for Youth, Communities,',
            'headline_line_3' => 'and Future Generations.',
            'intro' => 'Founder of Baakhapaa, Skill Sikka, HillyChilly and Future Builders. Transforming education, tourism, technology, and local economies in Nepal.',
            'primary_button_label' => 'Explore My Projects',
            'primary_button_url' => '#projects',
            'text_link_label' => 'Read My Vision',
            'text_link_url' => '#about',
            'name' => 'Rakesh Rajbhat',
            'tagline' => 'For the root. For the youth. For the nation.',
            'background_image' => null,
        ];
    }

    public static function getHomeContent(): array
    {
        $defaults = static::defaultHomeContent();
        $decoded = static::decodeJson(static::getValue('home_content'));

        if (!is_array($decoded)) {
            return $defaults;
        }

        $content = array_merge($defaults, array_intersect_key($decoded, $defaults));

        foreach ($defaults as $key => $default) {
            if ($key === 'background_image') {
                $content[$key] = is_string($content[$key]) && $content[$key] !== '' ? $content[$key] : null;
                continue;
            }

            if (!is_string($content[$key]) || trim($content[$key]) === '') {
                $content[$key] = $default;
            }
        }

        return $content;
    }

    public static function encodeJson(array $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '[]';
    }

    /**
     * Allow section anchors, same-site paths, and http(s) URLs.
     */
    public static function sanitizeLink(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '' || preg_match('/javascript\s*:/i', $url) || preg_match('/^\s*(data|vbscript):/i', $url)) {
            return null;
        }

        if (preg_match('/^#[A-Za-z][\w\-]*$/', $url)) {
            return $url;
        }

        if (preg_match('/^\/(?!\/)[A-Za-z0-9\/_\-\.~%]*(\?[A-Za-z0-9\/_\-\.~%=&+]*)?(#[A-Za-z][\w\-]*)?$/', $url)) {
            return $url;
        }

        if (preg_match('#^https?://#i', $url) && filter_var($url, FILTER_VALIDATE_URL)) {
            $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

            if (in_array($scheme, ['http', 'https'], true)) {
                return $url;
            }
        }

        return null;
    }

    public static function linkHref(string $url): string
    {
        if (str_starts_with($url, '#')) {
            return route('home') . $url;
        }

        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        return url($url);
    }

    private static function decodeJson(mixed $value): mixed
    {
        if (!is_string($value) || $value === '') {
            return null;
        }

        return json_decode($value, true);
    }

    public static function getProjectsSection(): array
    {
        $label = trim((string) static::getValue('projects_section_label', "What I'm Building"));
        $title = trim((string) static::getValue('projects_section_title', 'Projects & Initiatives'));

        return [
            'label' => $label !== '' ? $label : "What I'm Building",
            'title' => $title !== '' ? $title : 'Projects & Initiatives',
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
