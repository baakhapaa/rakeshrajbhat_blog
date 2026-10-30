<?php

namespace App\Support;

use App\Models\Setting;

class BootcampPage
{
    public const ICONS = [
        'fa-robot' => 'Robot',
        'fa-laptop-code' => 'Laptop',
        'fa-code' => 'Code',
        'fa-rocket' => 'Rocket',
        'fa-chart-line' => 'Chart',
        'fa-brain' => 'Brain',
        'fa-shield-halved' => 'Shield',
        'fa-chalkboard-user' => 'Teaching',
        'fa-users' => 'People',
        'fa-lightbulb' => 'Idea',
        'fa-graduation-cap' => 'Graduation',
        'fa-globe' => 'Globe',
        'fa-star' => 'Star',
    ];

    public static function defaults(): array
    {
        return [
            'hero_kicker' => 'Bootcamp',
            'hero_heading' => 'Bring a bootcamp to your municipality',
            'hero_intro' => "Let's work together to give your municipality's youth the practical AI, coding, and future-ready skills they need to thrive in the modern world.",
            'process_label' => 'Simple process',
            'process_heading' => 'How It Works',
            'steps' => [
                ['title' => 'You Tell Us', 'body' => 'Share your needs, goals, and audience.'],
                ['title' => 'We Design It', 'body' => 'Custom curriculum tailored for your area.'],
                ['title' => 'We Deliver', 'body' => 'Run the bootcamp program on the ground.'],
                ['title' => 'Measure Impact', 'body' => 'Provide impact reports for your records.'],
            ],
            'expertise_label' => 'Our expertise',
            'expertise_heading' => 'What Can We Deliver?',
            'offerings' => [
                ['icon' => 'fa-robot', 'kicker' => 'Workshop', 'title' => 'ICT & AI'],
                ['icon' => 'fa-laptop-code', 'kicker' => 'Skill Sikka', 'title' => 'Digital Learning'],
                ['icon' => 'fa-code', 'kicker' => 'Coding', 'title' => 'Programming'],
                ['icon' => 'fa-rocket', 'kicker' => 'Startup', 'title' => 'Entrepreneur'],
                ['icon' => 'fa-chart-line', 'kicker' => 'Future', 'title' => 'Career & Skills'],
            ],
            'audiences' => [
                'Students',
                'Youth',
                'Teachers',
                'Local Entrepreneurs',
                'Community Members',
            ],
        ];
    }

    public static function content(): array
    {
        $stored = json_decode((string) Setting::getValue('bootcamp_page', ''), true);

        if (! is_array($stored)) {
            return self::defaults();
        }

        return self::normalize($stored);
    }

    /**
     * @return list<string>
     */
    public static function audienceLabels(): array
    {
        return self::content()['audiences'];
    }

    public static function normalize(array $input): array
    {
        $steps = [];

        foreach (array_slice(is_array($input['steps'] ?? null) ? $input['steps'] : [], 0, 8) as $step) {
            if (! is_array($step)) {
                continue;
            }

            $title = self::plain($step['title'] ?? '', 80);
            $body = self::plain($step['body'] ?? '', 200);

            if ($title === '' && $body === '') {
                continue;
            }

            $steps[] = ['title' => $title, 'body' => $body];
        }

        $offerings = [];

        foreach (array_slice(is_array($input['offerings'] ?? null) ? $input['offerings'] : [], 0, 8) as $item) {
            if (! is_array($item)) {
                continue;
            }

            $kicker = self::plain($item['kicker'] ?? '', 40);
            $title = self::plain($item['title'] ?? '', 40);
            $icon = (string) ($item['icon'] ?? '');

            if (! array_key_exists($icon, self::ICONS)) {
                $icon = 'fa-star';
            }

            if ($kicker === '' && $title === '') {
                continue;
            }

            $offerings[] = [
                'icon' => $icon,
                'kicker' => $kicker,
                'title' => $title,
            ];
        }

        $audiences = [];

        foreach (array_slice(is_array($input['audiences'] ?? null) ? $input['audiences'] : [], 0, 12) as $audience) {
            $label = is_array($audience) ? ($audience['label'] ?? '') : $audience;
            $label = self::plain($label, 60);

            if ($label === '' || in_array($label, $audiences, true)) {
                continue;
            }

            $audiences[] = $label;
        }

        $defaults = self::defaults();

        return [
            'hero_kicker' => self::textOrDefault($input, 'hero_kicker', 40, $defaults['hero_kicker']),
            'hero_heading' => self::textOrDefault($input, 'hero_heading', 160, $defaults['hero_heading']),
            'hero_intro' => self::textOrDefault($input, 'hero_intro', 400, $defaults['hero_intro']),
            'process_label' => self::plain($input['process_label'] ?? '', 80),
            'process_heading' => self::plain($input['process_heading'] ?? '', 120),
            'steps' => $steps,
            'expertise_label' => self::plain($input['expertise_label'] ?? '', 80),
            'expertise_heading' => self::plain($input['expertise_heading'] ?? '', 120),
            'offerings' => $offerings,
            'audiences' => $audiences,
        ];
    }

    private static function textOrDefault(array $input, string $key, int $limit, string $fallback): string
    {
        if (! array_key_exists($key, $input)) {
            return $fallback;
        }

        return self::plain($input[$key], $limit);
    }

    private static function plain(mixed $value, int $limit): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $value)) ?? '');

        return mb_substr($text, 0, $limit);
    }
}
