<?php

namespace App\Services;

use App\Models\PageView;
use App\Models\SiteVisit;
use App\Support\TrafficSource;
use App\Support\UserAgentParser;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class VisitTracker
{
    private const SESSION_VISIT = 'analytics.visit_id';
    private const SESSION_SEEN = 'analytics.last_seen';
    private const CONTENT_ATTRIBUTE = 'analytics.content';
    private const VISIT_TIMEOUT_SECONDS = 1800;

    private static ?Reader $cityReader = null;
    private static bool $cityReaderLoaded = false;

    public static function isTrackable(Request $request): bool
    {
        if (!$request->isMethod('GET') || $request->is('admin', 'admin/*', 'api/*', 'up', 'blog/feed')) {
            return false;
        }

        if (strtolower((string) $request->header('Sec-Purpose', $request->header('Purpose', ''))) === 'prefetch') {
            return false;
        }

        if (UserAgentParser::isBot($request->userAgent())) {
            return false;
        }

        return !Auth::guard('admin')->check();
    }

    /**
     * Marks the current request as a view of a blog, news item or research item.
     */
    public static function markContent(Request $request, string $type, int $id): void
    {
        $request->attributes->set(self::CONTENT_ATTRIBUTE, [$type, $id]);
    }

    public static function content(Request $request): ?array
    {
        return $request->attributes->get(self::CONTENT_ATTRIBUTE);
    }

    /**
     * Returns the id of the visit for this session, starting a new one when needed.
     */
    public static function visitId(Request $request): ?int
    {
        if (!$request->hasSession()) {
            return null;
        }

        $session = $request->session();
        $visitId = $session->get(self::SESSION_VISIT);
        $lastSeen = (int) $session->get(self::SESSION_SEEN, 0);
        $expired = time() - $lastSeen > self::VISIT_TIMEOUT_SECONDS;

        if (!$visitId || $expired || TrafficSource::startsNewVisit($request)) {
            $visitId = self::startVisit($request)->id;
            $session->put(self::SESSION_VISIT, $visitId);
        }

        $session->put(self::SESSION_SEEN, time());

        return (int) $visitId;
    }

    public static function recordPageView(?int $visitId, Request $request, ?array $content): void
    {
        PageView::create([
            'site_visit_id' => $visitId,
            'path' => mb_substr('/' . ltrim($request->path(), '/'), 0, 500),
            'content_type' => $content[0] ?? null,
            'content_id' => $content[1] ?? null,
        ]);
    }

    private static function startVisit(Request $request): SiteVisit
    {
        $ip = self::clientIp($request);
        $userAgent = (string) $request->userAgent();
        $source = TrafficSource::classify($request);
        $device = UserAgentParser::parse($userAgent);
        [$country, $city] = self::location($request, $ip);

        return SiteVisit::create([
            'visitor_hash' => hash('sha256', now()->toDateString() . '|' . config('app.key') . '|' . $ip . '|' . $userAgent),
            'session_id' => $request->session()->getId(),
            'landing_path' => mb_substr('/' . ltrim($request->path(), '/'), 0, 500),
            'referrer_host' => $source['referrer_host'],
            'source' => $source['source'],
            'utm_source' => self::limit($request->query('utm_source')),
            'utm_medium' => self::limit($request->query('utm_medium')),
            'utm_campaign' => self::limit($request->query('utm_campaign')),
            'country' => $country,
            'city' => $city,
            'device' => $device['device'],
            'browser' => $device['browser'],
            'os' => $device['os'],
        ]);
    }

    private static function clientIp(Request $request): string
    {
        $cloudflareIp = (string) $request->header('CF-Connecting-IP', '');

        return filter_var($cloudflareIp, FILTER_VALIDATE_IP) ? $cloudflareIp : (string) $request->ip();
    }

    /**
     * @return array{0: ?string, 1: ?string}
     */
    private static function location(Request $request, string $ip): array
    {
        $country = strtoupper((string) $request->header('CF-IPCountry', ''));
        $country = preg_match('/^[A-Z]{2}$/', $country) && !in_array($country, ['XX', 'T1'], true) ? $country : null;
        $city = null;

        $reader = self::cityReader();

        if ($reader && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            try {
                $record = $reader->city($ip);
                $city = $record->city->name ?: null;
                $country ??= $record->country->isoCode ?: null;
            } catch (Throwable) {
                // Address not in the database.
            }
        }

        return [$country, $city];
    }

    private static function cityReader(): ?Reader
    {
        if (!self::$cityReaderLoaded) {
            self::$cityReaderLoaded = true;
            $path = (string) config('services.geoip.city_db');

            if ($path !== '' && is_file($path)) {
                try {
                    self::$cityReader = new Reader($path);
                } catch (Throwable $e) {
                    Log::warning('GeoIP city database could not be opened: ' . $e->getMessage());
                }
            }
        }

        return self::$cityReader;
    }

    private static function limit(mixed $value): ?string
    {
        return is_string($value) && $value !== '' ? mb_substr($value, 0, 255) : null;
    }
}
