<?php

namespace App\Support;

use Illuminate\Http\Request;

class TrafficSource
{
    public const LABELS = [
        'direct' => 'Direct (typed URL)',
        'search' => 'Search engines',
        'referral' => 'Other websites',
        'social' => 'Social media',
        'ads' => 'Ads',
        'email' => 'Email & campaigns',
    ];

    private const SEARCH_HOSTS = [
        'google.', 'bing.com', 'search.brave.com', 'duckduckgo.com', 'yahoo.',
        'yandex.', 'baidu.com', 'ecosia.org', 'startpage.com',
    ];

    private const SOCIAL_HOSTS = [
        'facebook.com', 'fb.com', 'fb.me', 'messenger.com', 'instagram.com',
        't.co', 'twitter.com', 'x.com', 'linkedin.com', 'lnkd.in',
        'youtube.com', 'youtu.be', 'tiktok.com', 'reddit.com', 'pinterest.',
        'threads.net', 'whatsapp.com', 'telegram.org', 't.me', 'viber.com',
    ];

    private const PAID_MEDIUMS = ['cpc', 'ppc', 'paid', 'ads', 'paidsocial', 'paid_social', 'display', 'cpm'];

    /**
     * @return array{source: string, referrer_host: ?string}
     */
    public static function classify(Request $request): array
    {
        $referrerHost = self::externalReferrerHost($request);
        $medium = strtolower((string) $request->query('utm_medium', ''));

        if ($request->filled('gclid') || $request->filled('fbclid') || $request->filled('msclkid')
            || in_array($medium, self::PAID_MEDIUMS, true)) {
            return ['source' => 'ads', 'referrer_host' => $referrerHost];
        }

        if ($medium !== '' || $request->filled('utm_source') || $request->filled('utm_campaign')) {
            return ['source' => $medium === 'social' ? 'social' : 'email', 'referrer_host' => $referrerHost];
        }

        if ($referrerHost === null) {
            return ['source' => 'direct', 'referrer_host' => null];
        }

        if (self::matches($referrerHost, self::SEARCH_HOSTS)) {
            return ['source' => 'search', 'referrer_host' => $referrerHost];
        }

        if (self::matches($referrerHost, self::SOCIAL_HOSTS)) {
            return ['source' => 'social', 'referrer_host' => $referrerHost];
        }

        return ['source' => 'referral', 'referrer_host' => $referrerHost];
    }

    public static function label(string $source): string
    {
        return self::LABELS[$source] ?? ucfirst($source);
    }

    /**
     * True when the request carries its own attribution (campaign tags or an outside referrer),
     * which starts a new visit even inside an existing session.
     */
    public static function startsNewVisit(Request $request): bool
    {
        return self::externalReferrerHost($request) !== null
            || $request->filled('utm_source')
            || $request->filled('utm_medium')
            || $request->filled('utm_campaign')
            || $request->filled('gclid')
            || $request->filled('fbclid')
            || $request->filled('msclkid');
    }

    private static function externalReferrerHost(Request $request): ?string
    {
        $referrer = (string) $request->headers->get('referer', '');
        $host = $referrer !== '' ? parse_url($referrer, PHP_URL_HOST) : null;

        if (!is_string($host) || $host === '') {
            return null;
        }

        $host = strtolower($host);
        $host = str_starts_with($host, 'www.') ? substr($host, 4) : $host;

        return self::isOwnHost($host, $request) ? null : $host;
    }

    private static function isOwnHost(string $host, Request $request): bool
    {
        $own = array_filter([
            strtolower($request->getHost()),
            strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST)),
        ]);

        foreach ($own as $ownHost) {
            $ownHost = str_starts_with($ownHost, 'www.') ? substr($ownHost, 4) : $ownHost;

            if ($host === $ownHost || str_ends_with($host, '.' . $ownHost)) {
                return true;
            }
        }

        return false;
    }

    private static function matches(string $host, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (str_ends_with($pattern, '.')) {
                if (str_starts_with($host, $pattern) || str_contains($host, '.' . $pattern)) {
                    return true;
                }
            } elseif ($host === $pattern || str_ends_with($host, '.' . $pattern)) {
                return true;
            }
        }

        return false;
    }
}
