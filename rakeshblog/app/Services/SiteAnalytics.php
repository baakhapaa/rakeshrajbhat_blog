<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\NewsItem;
use App\Models\PageView;
use App\Models\Research;
use App\Models\SiteVisit;
use App\Support\TrafficSource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SiteAnalytics
{
    public const RANGES = [7, 30, 90];

    private const TIMEZONE = 'Asia/Kathmandu';
    private const LOCAL_DAY_SQL = 'DATE(DATE_ADD(%s, INTERVAL 345 MINUTE))';

    public function __construct(private int $days = 30)
    {
    }

    public function days(): int
    {
        return $this->days;
    }

    public function since(): Carbon
    {
        return self::localDayStart($this->days - 1);
    }

    /**
     * Start of the Nepal-time day $daysAgo days back, as UTC for querying.
     */
    private static function localDayStart(int $daysAgo): Carbon
    {
        return now(self::TIMEZONE)->subDays($daysAgo)->startOfDay()->utc();
    }

    /**
     * Daily page views, visits and visitors, plus visits per traffic source, for line charts.
     */
    public function dailyTraffic(): array
    {
        $views = PageView::query()
            ->where('created_at', '>=', $this->since())
            ->selectRaw(sprintf(self::LOCAL_DAY_SQL, 'created_at') . ' as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $visits = SiteVisit::query()
            ->where('created_at', '>=', $this->since())
            ->selectRaw(sprintf(self::LOCAL_DAY_SQL, 'created_at') . ' as day, COUNT(*) as visits, COUNT(DISTINCT visitor_hash) as visitors')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $sourceRows = SiteVisit::query()
            ->where('created_at', '>=', $this->since())
            ->selectRaw(sprintf(self::LOCAL_DAY_SQL, 'created_at') . ' as day, source, COUNT(*) as total')
            ->groupBy('day', 'source')
            ->get();

        $series = ['labels' => [], 'views' => [], 'visits' => [], 'visitors' => [], 'sources' => []];
        $dates = [];

        for ($i = $this->days - 1; $i >= 0; $i--) {
            $date = now(self::TIMEZONE)->subDays($i);
            $key = $date->toDateString();
            $dates[] = $key;
            $series['labels'][] = $date->format('M j');
            $series['views'][] = (int) ($views[$key] ?? 0);
            $series['visits'][] = (int) ($visits[$key]->visits ?? 0);
            $series['visitors'][] = (int) ($visits[$key]->visitors ?? 0);
        }

        $bySource = $sourceRows->groupBy('source');

        foreach (array_keys(TrafficSource::LABELS) as $source) {
            if (!$bySource->has($source)) {
                continue;
            }

            $byDay = $bySource[$source]->pluck('total', 'day');
            $series['sources'][TrafficSource::label($source)] = array_map(fn ($day) => (int) ($byDay[$day] ?? 0), $dates);
        }

        return $series;
    }

    /**
     * Visits, visitors and page views per country, ordered by visits.
     */
    public function countryStats(): Collection
    {
        $views = PageView::query()
            ->join('site_visits', 'site_visits.id', '=', 'page_views.site_visit_id')
            ->where('page_views.created_at', '>=', $this->since())
            ->whereNotNull('site_visits.country')
            ->selectRaw('site_visits.country, COUNT(*) as total')
            ->groupBy('site_visits.country')
            ->pluck('total', 'country');

        $rows = SiteVisit::query()
            ->where('created_at', '>=', $this->since())
            ->whereNotNull('country')
            ->selectRaw('country, COUNT(*) as visits, COUNT(DISTINCT visitor_hash) as visitors')
            ->groupBy('country')
            ->orderByDesc('visits')
            ->get();

        $total = max(1, (int) $rows->sum('visits'));

        return $rows->map(fn ($row) => [
            'code' => $row->country,
            'name' => self::countryName($row->country),
            'visits' => (int) $row->visits,
            'visitors' => (int) $row->visitors,
            'views' => (int) ($views[$row->country] ?? 0),
            'share' => round($row->visits / $total * 100, 1),
        ]);
    }

    /**
     * Page views and unique visitors for today, 7 days, 30 days and all time.
     */
    public function totals(): array
    {
        $periods = [
            'today' => ['Today', self::localDayStart(0)],
            'week' => ['Last 7 days', self::localDayStart(6)],
            'month' => ['Last 30 days', self::localDayStart(29)],
            'all' => ['All time', null],
        ];

        return collect($periods)->map(function (array $period) {
            [$label, $from] = $period;

            $views = PageView::query()->when($from, fn ($q) => $q->where('created_at', '>=', $from))->count();
            $visits = SiteVisit::query()->when($from, fn ($q) => $q->where('created_at', '>=', $from));

            return [
                'label' => $label,
                'views' => $views,
                'visits' => (clone $visits)->count(),
                'visitors' => (clone $visits)->distinct()->count('visitor_hash'),
            ];
        })->all();
    }

    public function sources(): array
    {
        $counts = $this->visitCounts('source');

        return collect(TrafficSource::LABELS)
            ->map(fn (string $label, string $key) => ['label' => $label, 'count' => (int) ($counts[$key] ?? 0)])
            ->values()
            ->all();
    }

    public function topReferrers(int $limit = 10): Collection
    {
        return SiteVisit::query()
            ->where('created_at', '>=', $this->since())
            ->whereNotNull('referrer_host')
            ->selectRaw('referrer_host, source, COUNT(*) as total')
            ->groupBy('referrer_host', 'source')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->map(fn ($row) => [
                'host' => $row->referrer_host,
                'source' => TrafficSource::label($row->source),
                'count' => (int) $row->total,
            ]);
    }

    public function cities(int $limit = 10): array
    {
        return $this->visitCounts('city', $limit);
    }

    public function devices(): array
    {
        return collect($this->visitCounts('device'))
            ->mapWithKeys(fn ($count, $device) => [ucfirst($device) => $count])
            ->all();
    }

    public function browsers(int $limit = 8): array
    {
        return $this->visitCounts('browser', $limit);
    }

    public function operatingSystems(int $limit = 8): array
    {
        return $this->visitCounts('os', $limit);
    }

    /**
     * Views per blog, news item and research item, with the top country and top source of its readers.
     */
    public function contentPerformance(int $limit = 25): Collection
    {
        $base = PageView::query()
            ->join('site_visits', 'site_visits.id', '=', 'page_views.site_visit_id')
            ->where('page_views.created_at', '>=', $this->since())
            ->whereNotNull('page_views.content_type');

        $rows = (clone $base)
            ->selectRaw('page_views.content_type, page_views.content_id, COUNT(*) as views, COUNT(DISTINCT site_visits.visitor_hash) as visitors')
            ->groupBy('page_views.content_type', 'page_views.content_id')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();

        if ($rows->isEmpty()) {
            return collect();
        }

        $topCountry = $this->topPerContent($base, 'site_visits.country');
        $topSource = $this->topPerContent($base, 'site_visits.source');
        $titles = $this->contentTitles($rows);

        return $rows->map(function ($row) use ($topCountry, $topSource, $titles) {
            $key = $row->content_type . ':' . $row->content_id;

            return [
                'type' => ucfirst($row->content_type),
                'title' => $titles[$key] ?? 'Deleted item #' . $row->content_id,
                'views' => (int) $row->views,
                'visitors' => (int) $row->visitors,
                'country' => isset($topCountry[$key]) ? self::countryName($topCountry[$key]) : '—',
                'source' => isset($topSource[$key]) ? TrafficSource::label($topSource[$key]) : '—',
            ];
        });
    }

    /**
     * All-time views per item of one content type.
     *
     * @return array<int, int>  content id => views
     */
    public static function viewCounts(string $type, iterable $ids): array
    {
        $ids = collect($ids)->filter()->values()->all();

        if ($ids === []) {
            return [];
        }

        return PageView::query()
            ->where('content_type', $type)
            ->whereIn('content_id', $ids)
            ->selectRaw('content_id, COUNT(*) as total')
            ->groupBy('content_id')
            ->pluck('total', 'content_id')
            ->map(fn ($total) => (int) $total)
            ->all();
    }

    /**
     * Most viewed items of one content type in the selected range.
     */
    public function topContent(string $type, int $limit = 5): Collection
    {
        $rows = PageView::query()
            ->leftJoin('site_visits', 'site_visits.id', '=', 'page_views.site_visit_id')
            ->where('page_views.created_at', '>=', $this->since())
            ->where('page_views.content_type', $type)
            ->selectRaw('page_views.content_id, COUNT(*) as views, COUNT(DISTINCT site_visits.visitor_hash) as visitors')
            ->groupBy('page_views.content_id')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();

        $models = ['blog' => Blog::class, 'news' => NewsItem::class, 'research' => Research::class];
        $items = $models[$type]::query()->whereIn('id', $rows->pluck('content_id'))->get()->keyBy('id');

        return $rows->map(function ($row) use ($items, $type) {
            $item = $items->get($row->content_id);

            return [
                'title' => $item->title ?? 'Deleted item #' . $row->content_id,
                'views' => (int) $row->views,
                'visitors' => (int) $row->visitors,
                'url' => match (true) {
                    $item === null => null,
                    $type === 'blog' => route('blog.show', $item->slug),
                    $type === 'research' => route('admin.research.show', $item->id),
                    default => route('admin.news.index'),
                },
            ];
        });
    }

    /**
     * Page paths that GA4 can break down by age and gender.
     */
    public function demographicPages(): array
    {
        $pages = ['' => 'Whole website', '/' => 'Home page', '/news' => 'News page'];

        Blog::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(50)
            ->get(['title', 'slug'])
            ->each(function (Blog $blog) use (&$pages) {
                $pages['/blog/' . $blog->slug] = 'Blog: ' . $blog->title;
            });

        return $pages;
    }

    public static function countryName(?string $code): string
    {
        if (!$code) {
            return 'Unknown';
        }

        if (function_exists('locale_get_display_region')) {
            $name = locale_get_display_region('-' . $code, 'en');

            if ($name && $name !== $code) {
                return $name;
            }
        }

        return self::COUNTRY_NAMES[$code] ?? $code;
    }

    private const COUNTRY_NAMES = [
        'NP' => 'Nepal', 'IN' => 'India', 'US' => 'United States', 'GB' => 'United Kingdom',
        'AU' => 'Australia', 'CA' => 'Canada', 'AE' => 'United Arab Emirates', 'QA' => 'Qatar',
        'SA' => 'Saudi Arabia', 'KW' => 'Kuwait', 'BH' => 'Bahrain', 'OM' => 'Oman', 'MY' => 'Malaysia',
        'JP' => 'Japan', 'KR' => 'South Korea', 'CN' => 'China', 'HK' => 'Hong Kong', 'SG' => 'Singapore',
        'BD' => 'Bangladesh', 'PK' => 'Pakistan', 'LK' => 'Sri Lanka', 'BT' => 'Bhutan', 'TH' => 'Thailand',
        'DE' => 'Germany', 'FR' => 'France', 'IT' => 'Italy', 'ES' => 'Spain', 'NL' => 'Netherlands',
        'PT' => 'Portugal', 'IE' => 'Ireland', 'BE' => 'Belgium', 'CH' => 'Switzerland', 'SE' => 'Sweden',
        'NO' => 'Norway', 'DK' => 'Denmark', 'FI' => 'Finland', 'PL' => 'Poland', 'RU' => 'Russia',
        'IL' => 'Israel', 'NZ' => 'New Zealand', 'PH' => 'Philippines', 'ID' => 'Indonesia', 'VN' => 'Vietnam',
        'BR' => 'Brazil', 'MX' => 'Mexico', 'ZA' => 'South Africa', 'NG' => 'Nigeria', 'CY' => 'Cyprus',
        'MT' => 'Malta', 'RO' => 'Romania', 'HR' => 'Croatia', 'MV' => 'Maldives', 'MM' => 'Myanmar',
    ];

    /**
     * @return array<string, int>
     */
    private function visitCounts(string $column, ?int $limit = null): array
    {
        return SiteVisit::query()
            ->where('created_at', '>=', $this->since())
            ->whereNotNull($column)
            ->selectRaw("{$column} as label, COUNT(*) as total")
            ->groupBy($column)
            ->orderByDesc('total')
            ->when($limit, fn ($q) => $q->limit($limit))
            ->pluck('total', 'label')
            ->map(fn ($total) => (int) $total)
            ->all();
    }

    /**
     * @return array<string, string>  "type:id" => most common value of $column
     */
    private function topPerContent($base, string $column): array
    {
        $top = [];

        (clone $base)
            ->whereNotNull($column)
            ->selectRaw("page_views.content_type, page_views.content_id, {$column} as value, COUNT(*) as total")
            ->groupBy('page_views.content_type', 'page_views.content_id', DB::raw($column))
            ->orderByDesc('total')
            ->get()
            ->each(function ($row) use (&$top) {
                $top[$row->content_type . ':' . $row->content_id] ??= $row->value;
            });

        return $top;
    }

    private function contentTitles(Collection $rows): array
    {
        $models = ['blog' => Blog::class, 'news' => NewsItem::class, 'research' => Research::class];
        $titles = [];

        foreach ($rows->groupBy('content_type') as $type => $group) {
            if (!isset($models[$type])) {
                continue;
            }

            $models[$type]::query()
                ->whereIn('id', $group->pluck('content_id'))
                ->pluck('title', 'id')
                ->each(function ($title, $id) use (&$titles, $type) {
                    $titles[$type . ':' . $id] = $title;
                });
        }

        return $titles;
    }
}
