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

    /**
     * Hero fields that may be cleared in admin without falling back to defaults.
     *
     * @return list<string>
     */
    public static function optionalHomeHeroTextKeys(): array
    {
        return [
            'eyebrow',
            'headline_line_1',
            'headline_line_2',
            'headline_line_3',
        ];
    }

    public static function nullableHomeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
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

            if (in_array($key, static::optionalHomeHeroTextKeys(), true)) {
                if (array_key_exists($key, $decoded)) {
                    $content[$key] = static::nullableHomeString(is_string($content[$key]) ? $content[$key] : null);
                }
                continue;
            }

            if (!is_string($content[$key]) || trim($content[$key]) === '') {
                $content[$key] = $default;
            }
        }

        return $content;
    }

    public static function defaultAboutContent(): array
    {
        return [
            'label' => '01 / About me',
            'heading_line_1' => 'My journey',
            'heading_line_2' => 'so far.',
            'paragraph_1' => 'I studied civil engineering, worked in Texas and returned to Nepal to build projects in education, technology and tourism.',
            'paragraph_2' => 'Through Baakhapaa, Skill Sikka, HillyChilly and Future Builders, I have been exploring ways to connect learning with practical opportunities. As I prepare for public service in Palungtar, I want to bring that experience into conversations about employment, education and the services people depend on every day.',
            'facts' => [
                ['title' => 'Civil engineering', 'caption' => 'Education'],
                ['title' => 'Nepal & Texas', 'caption' => 'Experience'],
            ],
        ];
    }

    public static function getAboutContent(): array
    {
        $defaults = static::defaultAboutContent();
        $decoded = static::decodeJson(static::getValue('about_content'));

        if (! is_array($decoded)) {
            return $defaults;
        }

        $content = $defaults;

        foreach (['label', 'heading_line_1', 'heading_line_2', 'paragraph_1', 'paragraph_2'] as $key) {
            if (isset($decoded[$key]) && is_string($decoded[$key]) && trim($decoded[$key]) !== '') {
                $content[$key] = $decoded[$key];
            }
        }

        $facts = static::aboutFactsFrom($decoded);

        if ($facts !== []) {
            $content['facts'] = $facts;
        }

        return $content;
    }

    public static function aboutFactsFrom(array $decoded): array
    {
        $facts = [];
        $rows = $decoded['facts'] ?? null;

        if (! is_array($rows)) {
            $rows = [];

            foreach ([1, 2] as $index) {
                $title = $decoded['fact_'.$index.'_title'] ?? null;
                $caption = $decoded['fact_'.$index.'_caption'] ?? null;

                if ($title === null && $caption === null) {
                    continue;
                }

                $rows[] = ['title' => $title, 'caption' => $caption];
            }
        }

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $title = trim(strip_tags((string) ($row['title'] ?? '')));
            $caption = trim(strip_tags((string) ($row['caption'] ?? '')));

            if ($title === '' && $caption === '') {
                continue;
            }

            $facts[] = [
                'title' => $title,
                'caption' => $caption,
            ];
        }

        return array_slice($facts, 0, 12);
    }

    public static function defaultNewsContent(): array
    {
        return [
            'label' => '05 / News & Updates',
            'heading' => 'From the journey.',
            'intro' => 'News from community visits, project activities, public discussions and events.',
            'items' => [
                [
                    'kicker' => 'Palungtar · Community',
                    'title' => 'News from Palungtar',
                    'body' => 'Share updates from visits, conversations and local activities here.',
                    'note' => 'Sample placeholders — replace with real updates, dates and links.',
                ],
                [
                    'kicker' => 'Learning · Education',
                    'title' => 'Learning in action',
                    'body' => 'Add updates from bootcamps and other learning programmes here.',
                    'note' => '',
                ],
                [
                    'kicker' => 'Projects · Updates',
                    'title' => 'Work in progress',
                    'body' => 'Share project milestones, events and news from the team here.',
                    'note' => '',
                ],
            ],
        ];
    }

    public static function getNewsContent(): array
    {
        $defaults = static::defaultNewsContent();
        $decoded = static::decodeJson(static::getValue('news_content'));

        if (! is_array($decoded)) {
            return $defaults;
        }

        $content = $defaults;

        foreach (['label', 'heading', 'intro'] as $key) {
            if (isset($decoded[$key]) && is_string($decoded[$key]) && trim($decoded[$key]) !== '') {
                $content[$key] = $decoded[$key];
            }
        }

        $items = static::newsItemsFrom($decoded);

        if ($items !== []) {
            $content['items'] = $items;
        }

        return $content;
    }

    public static function newsItemsFrom(array $decoded): array
    {
        $rows = $decoded['items'] ?? null;

        if (! is_array($rows)) {
            return [];
        }

        $items = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $kicker = trim(strip_tags((string) ($row['kicker'] ?? '')));
            $title = trim(strip_tags((string) ($row['title'] ?? '')));
            $body = trim(strip_tags((string) ($row['body'] ?? '')));
            $note = trim(strip_tags((string) ($row['note'] ?? '')));

            if ($kicker === '' && $title === '' && $body === '') {
                continue;
            }

            $items[] = [
                'kicker' => $kicker,
                'title' => $title,
                'body' => $body,
                'note' => $note,
            ];
        }

        return array_slice($items, 0, 6);
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

    public static function getStatsSection(): array
    {
        $title = trim((string) static::getValue('stats_section_title', "What I've done so far"));
        $description = trim((string) static::getValue('stats_section_description', 'Turning Ideas Into Impact'));

        return [
            'title' => $title !== '' ? $title : "What I've done so far",
            'description' => $description !== '' ? $description : 'Turning Ideas Into Impact',
        ];
    }

    public static function getResearchSection(): array
    {
        $title = trim((string) static::getValue('research_section_title', 'Stories, Ideas & Research That Matters'));
        $paragraph = trim((string) static::getValue('research_section_paragraph', "Exploring ideas, frameworks, and stories that shape Nepal's future — one insight at a time."));

        return [
            'title' => $title !== '' ? $title : 'Stories, Ideas & Research That Matters',
            'paragraph' => $paragraph !== '' ? $paragraph : "Exploring ideas, frameworks, and stories that shape Nepal's future — one insight at a time.",
        ];
    }

    public static function defaultResearchFeaturedPage(): array
    {
        return [
            'title_line' => 'All Research &',
            'title_accent' => 'Resources',
            'paragraph' => "Explore ideas, frameworks, and stories from the ground — shaping Nepal's future together.",
            'filters' => [
                ['key' => 'all', 'label' => 'All', 'type' => 'all', 'icon' => 'fa-th-list'],
                ['key' => 'Vision', 'label' => 'Vision', 'type' => 'category', 'icon' => 'fa-eye'],
                ['key' => 'Research Papers', 'label' => 'Research', 'type' => 'category', 'icon' => 'fa-book'],
                ['key' => 'Media', 'label' => 'Media', 'type' => 'category', 'icon' => 'fa-video'],
                ['key' => 'blog', 'label' => 'Blog', 'type' => 'blog', 'icon' => 'fa-newspaper'],
            ],
        ];
    }

    public static function researchFilterIcons(): array
    {
        return [
            'all' => 'fa-th-list',
            'Vision' => 'fa-eye',
            'Research Papers' => 'fa-book',
            'Media' => 'fa-video',
            'blog' => 'fa-newspaper',
        ];
    }

    public static function getResearchFeaturedPage(): array
    {
        $defaults = static::defaultResearchFeaturedPage();
        $decoded = static::decodeJson(static::getValue('research_featured_page'));
        $page = $defaults;

        if (is_array($decoded)) {
            foreach (['title_line', 'paragraph'] as $key) {
                $value = trim(strip_tags((string) ($decoded[$key] ?? '')));
                if ($value !== '') {
                    $page[$key] = $value;
                }
            }

            if (array_key_exists('title_accent', $decoded)) {
                $page['title_accent'] = trim(strip_tags((string) $decoded['title_accent']));
            }
        }

        if (is_array($decoded) && array_key_exists('filters', $decoded)) {
            $page['filters'] = static::researchFiltersFrom($decoded['filters'], false);
        }

        return $page;
    }

    public static function researchFiltersFrom(mixed $rows, bool $fillDefaults = true): array
    {
        $icons = static::researchFilterIcons();
        $defaults = static::defaultResearchFeaturedPage()['filters'];
        $defaultLabels = [];
        foreach ($defaults as $filter) {
            $defaultLabels[$filter['key']] = $filter['label'];
        }

        if (! is_array($rows)) {
            return $fillDefaults ? $defaults : [];
        }

        $filters = [];
        $seen = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $label = trim(strip_tags((string) ($row['label'] ?? '')));
            $key = trim(strip_tags((string) ($row['key'] ?? '')));
            $type = (string) ($row['type'] ?? '');

            if ($type === '' ) {
                $type = $key === 'all' ? 'all' : ($key === 'blog' ? 'blog' : 'category');
            }

            if (! in_array($type, ['all', 'blog', 'category'], true)) {
                continue;
            }

            if ($type === 'all') {
                $key = 'all';
            } elseif ($type === 'blog') {
                $key = 'blog';
            } elseif ($key === '' || in_array($key, ['all', 'blog'], true)) {
                $key = $label;
            }

            if ($label === '') {
                $label = $defaultLabels[$key] ?? '';
            }

            if ($label === '' || $key === '' || isset($seen[$key])) {
                continue;
            }

            $filters[] = [
                'key' => $key,
                'label' => $label,
                'type' => $type,
                'icon' => $icons[$key] ?? 'fa-tag',
            ];
            $seen[$key] = true;
        }

        return $filters === [] && $fillDefaults ? $defaults : array_slice($filters, 0, 12);
    }

    public static function defaultBlogPage(): array
    {
        return [
            'eyebrow' => 'Latest Articles',
            'title' => 'Blog & Insights',
            'paragraph' => 'Thoughts, stories and ideas from my journey in building opportunities for Nepal.',
            'category_order' => [],
            'categories_managed' => false,
        ];
    }

    public static function getBlogPage(): array
    {
        $defaults = static::defaultBlogPage();
        $decoded = static::decodeJson(static::getValue('blog_page'));
        $page = $defaults;

        if (is_array($decoded)) {
            foreach (['eyebrow', 'title', 'paragraph'] as $key) {
                $value = trim(strip_tags((string) ($decoded[$key] ?? '')));
                if ($value !== '') {
                    $page[$key] = $value;
                }
            }

            $page['categories_managed'] = array_key_exists('category_order', $decoded);
            $page['category_order'] = static::cleanNameList($decoded['category_order'] ?? []);
        }

        return $page;
    }

    public static function orderedNames(array $preferred, iterable $available): array
    {
        $available = static::cleanNameList($available);
        $lookup = array_fill_keys($available, true);
        $ordered = [];

        foreach (static::cleanNameList($preferred) as $name) {
            if (isset($lookup[$name])) {
                $ordered[] = $name;
                unset($lookup[$name]);
            }
        }

        foreach ($available as $name) {
            if (isset($lookup[$name])) {
                $ordered[] = $name;
            }
        }

        return $ordered;
    }

    public static function cleanNameList(mixed $names): array
    {
        if (! is_array($names) && ! $names instanceof \Traversable) {
            return [];
        }

        $clean = [];
        foreach ($names as $name) {
            $name = trim(strip_tags((string) $name));
            if ($name !== '' && ! in_array($name, $clean, true)) {
                $clean[] = $name;
            }
        }

        return $clean;
    }

    public static function getGallerySection(): array
    {
        $label = trim((string) static::getValue('gallery_section_label', 'Gallery'));
        $title = trim((string) static::getValue('gallery_section_title', 'Moments along the way.'));
        $paragraph = trim((string) static::getValue('gallery_section_paragraph', 'Photographs from community visits, learning programmes, project activities and conversations.'));
        $empty = trim((string) static::getValue('gallery_section_empty', 'Photographs will appear here as collections are added.'));

        return [
            'label' => $label !== '' ? $label : 'Gallery',
            'title' => $title !== '' ? $title : 'Moments along the way.',
            'paragraph' => $paragraph !== '' ? $paragraph : 'Photographs from community visits, learning programmes, project activities and conversations.',
            'empty' => $empty !== '' ? $empty : 'Photographs will appear here as collections are added.',
        ];
    }

    public static function defaultFooter(): array
    {
        return [
            'name' => 'Rakesh Rajbhat',
            'tagline' => 'For the root. For the youth. For the nation.',
            'intro' => 'Founder of Baakhapaa, Skill Sikka, HillyChilly and Future Builders. Transforming education, tourism, technology, and local economies in Nepal.',
            'copyright' => '© {year} RAKESH RAJBHAT. ALL RIGHTS RESERVED.',
            'socials_heading' => 'Socials',
            'pages_heading' => 'Pages',
            'newsletter_heading' => 'Newsletter',
            'newsletter_note' => 'Get an email when a new article, research piece, or project is published.',
            'socials' => [
                ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/raacb/'],
                ['label' => 'Facebook', 'url' => 'https://www.facebook.com/raacb/'],
                ['label' => 'Instagram', 'url' => 'https://www.instagram.com/raa_case7/'],
            ],
            'pages' => [
                ['label' => 'Contact', 'url' => '/contact'],
                ['label' => 'Privacy', 'url' => '/privacy'],
                ['label' => 'Terms', 'url' => '/terms'],
            ],
        ];
    }

    public static function getFooter(): array
    {
        $defaults = static::defaultFooter();
        $decoded = static::decodeJson(static::getValue('footer_content'));
        $footer = $defaults;

        if (is_array($decoded)) {
            foreach (['name', 'tagline', 'intro', 'copyright', 'socials_heading', 'pages_heading', 'newsletter_heading', 'newsletter_note'] as $key) {
                if (isset($decoded[$key]) && is_string($decoded[$key]) && trim($decoded[$key]) !== '') {
                    $footer[$key] = trim(strip_tags($decoded[$key]));
                }
            }

            foreach (['socials', 'pages'] as $list) {
                if (array_key_exists($list, $decoded)) {
                    $footer[$list] = static::footerLinksFrom($decoded[$list]);
                }
            }
        }

        $logo = trim((string) static::getValue('footer_logo', ''));
        $footer['logo'] = $logo !== '' ? $logo : null;
        $footer['copyright_text'] = str_replace('{year}', date('Y'), $footer['copyright']);

        return $footer;
    }

    public static function footerLinksFrom(mixed $rows): array
    {
        if (! is_array($rows)) {
            return [];
        }

        $items = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $label = trim(strip_tags((string) ($row['label'] ?? '')));
            $url = trim((string) ($row['url'] ?? ''));

            if ($label === '' || $url === '' || ! static::navUrlIsSafe($url)) {
                continue;
            }

            $items[] = ['label' => $label, 'url' => $url];
        }

        return array_slice($items, 0, 12);
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
