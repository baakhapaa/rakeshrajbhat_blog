<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ga4Reports;
use App\Services\SiteAnalytics;
use App\Support\TrafficSource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    private const CONTENT_LABELS = [
        'blog' => 'Blogs',
        'news' => 'News',
        'research' => 'Research',
    ];

    public function index(Request $request)
    {
        $range = $this->range($request);
        $analytics = new SiteAnalytics($range);
        $pages = $analytics->demographicPages();
        $selectedPage = $this->selectedPage($request, $pages);
        $contentType = $this->contentType($request);

        return view('admin.analytics.index', [
            'range' => $range,
            'ranges' => SiteAnalytics::RANGES,
            'totals' => $analytics->totals(),
            'daily' => $analytics->dailyTraffic(),
            'sources' => $analytics->sources(),
            'referrers' => $analytics->topReferrers(),
            'contentArticles' => $analytics->contentBreakdownPaginated($contentType, max(1, (int) $request->query('articles_page', 1))),
            'contentType' => $contentType,
            'countries' => $analytics->countryStats(),
            'cities' => $analytics->cities(),
            'devices' => $analytics->devices(),
            'browsers' => $analytics->browsers(),
            'operatingSystems' => $analytics->operatingSystems(),
            'demographics' => Ga4Reports::demographics($range, $selectedPage !== '' ? $selectedPage : null),
            'demographicPages' => $pages,
            'selectedPage' => $selectedPage,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $range = $this->range($request);
        $analytics = new SiteAnalytics($range);
        $pages = $analytics->demographicPages();
        $selectedPage = $this->selectedPage($request, $pages);
        $demographics = Ga4Reports::demographics($range, $selectedPage !== '' ? $selectedPage : null);
        $daily = $analytics->dailyTraffic();
        $rangeTotals = $analytics->rangeTotals();
        $sourceLabels = array_values(TrafficSource::LABELS);

        return $this->csv('analytics-' . $this->rangeSlug($range) . '.csv', function ($file) use ($analytics, $range, $daily, $rangeTotals, $sourceLabels, $demographics, $pages, $selectedPage) {
            $this->preamble($file, 'Analytics report', $range);
            fputcsv($file, ['Page views', $rangeTotals['views']]);
            fputcsv($file, ['Visits', $rangeTotals['visits']]);
            fputcsv($file, ['Visitors', $rangeTotals['visitors']]);
            fputcsv($file, []);

            $this->section($file, 'Overview', ['Period', 'Page views', 'Visitors', 'Visits'], array_map(
                fn (array $period) => [$period['label'], $period['views'], $period['visitors'], $period['visits']],
                $analytics->totals(),
            ));

            $this->section($file, 'Traffic by day', array_merge(['Date', 'Page views', 'Visits', 'Visitors'], $sourceLabels), array_map(
                function (int $index) use ($daily, $sourceLabels) {
                    $row = [
                        $daily['dates'][$index],
                        $daily['views'][$index],
                        $daily['visits'][$index],
                        $daily['visitors'][$index],
                    ];

                    foreach ($sourceLabels as $label) {
                        $row[] = $daily['sources'][$label][$index] ?? 0;
                    }

                    return $row;
                },
                array_keys($daily['dates']),
            ));

            $this->section($file, 'Where visitors come from', ['Source', 'Visits'], array_map(
                fn (array $source) => [$source['label'], $source['count']],
                $analytics->sources(),
            ));

            $this->section($file, 'Top referring websites', ['Website', 'Type', 'Visits'], $analytics->topReferrers(null)->map(
                fn (array $referrer) => [$referrer['host'], $referrer['source'], $referrer['count']],
            )->all());

            $articleRows = [];

            foreach (self::CONTENT_LABELS as $type => $label) {
                foreach ($analytics->contentBreakdownAll($type) as $item) {
                    foreach ($this->articleLocationRows($item) as $row) {
                        $articleRows[] = array_merge([$label], $row);
                    }
                }
            }

            $this->section($file, 'Views by article', ['Type', 'Title', 'URL', 'Views', 'All-time views', 'Visitors', 'Country', 'City', 'Location views'], $articleRows);

            $this->section($file, 'Traffic by country', ['Country', 'Code', 'Visits', 'Visitors', 'Page views', 'Share'], $analytics->countryStats()->map(
                fn (array $country) => [$country['name'], $country['code'], $country['visits'], $country['visitors'], $country['views'], $country['share'] . '%'],
            )->all());

            $this->section($file, 'Cities', ['City', 'Visits'], $this->pairs($analytics->cities(null)));
            $this->section($file, 'Devices', ['Device', 'Visits'], $this->pairs($analytics->devices()));
            $this->section($file, 'Browsers', ['Browser', 'Visits'], $this->pairs($analytics->browsers(null)));
            $this->section($file, 'Operating systems', ['Operating system', 'Visits'], $this->pairs($analytics->operatingSystems(null)));

            fputcsv($file, ['Age and gender']);
            fputcsv($file, ['Page', $pages[$selectedPage] ?? 'Whole website']);

            if (!$demographics['configured']) {
                fputcsv($file, ['Google Analytics is not connected.']);
            } elseif ($demographics['error']) {
                fputcsv($file, [$demographics['error']]);
            } else {
                fputcsv($file, []);
                $this->section($file, 'Age', ['Age', 'Active users'], $this->pairs($demographics['age']));
                $this->section($file, 'Gender', ['Gender', 'Active users'], $this->pairs($demographics['gender']));
            }
        });
    }

    public function exportArticles(Request $request): StreamedResponse
    {
        $range = $this->range($request);
        $type = $this->contentType($request);
        $label = self::CONTENT_LABELS[$type];
        $items = (new SiteAnalytics($range))->contentBreakdownAll($type);

        $filename = 'views-' . ($type === 'blog' ? 'blogs' : $type) . '-' . $this->rangeSlug($range) . '.csv';

        return $this->csv($filename, function ($file) use ($range, $label, $items) {
            $this->preamble($file, 'Views by article', $range);
            fputcsv($file, ['Content', $label]);
            fputcsv($file, []);
            fputcsv($file, ['Title', 'URL', 'Views', 'All-time views', 'Visitors', 'Country', 'City', 'Location views']);

            foreach ($items as $item) {
                foreach ($this->articleLocationRows($item) as $row) {
                    fputcsv($file, $row);
                }
            }
        });
    }

    private function range(Request $request): ?int
    {
        $requested = (string) $request->query('range', '30');

        return $requested === 'all'
            ? null
            : (in_array((int) $requested, SiteAnalytics::RANGES, true) ? (int) $requested : 30);
    }

    private function contentType(Request $request): string
    {
        $contentType = (string) $request->query('content', 'blog');

        return array_key_exists($contentType, SiteAnalytics::CONTENT_MODELS) ? $contentType : 'blog';
    }

    private function selectedPage(Request $request, array $pages): string
    {
        $selectedPage = (string) $request->query('page', '');

        return array_key_exists($selectedPage, $pages) ? $selectedPage : '';
    }

    private function rangeSlug(?int $range): string
    {
        return $range === null ? 'all-time' : 'last-' . $range . '-days';
    }

    private function rangeText(?int $range): string
    {
        return $range === null ? 'All time' : 'Last ' . $range . ' days';
    }

    private function csv(string $filename, callable $write): StreamedResponse
    {
        return response()->streamDownload(function () use ($write) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            $write($file);
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function preamble($file, string $title, ?int $range): void
    {
        fputcsv($file, [$title]);
        fputcsv($file, ['Range', $this->rangeText($range)]);
        fputcsv($file, ['Timezone', 'Asia/Kathmandu']);
        fputcsv($file, ['Generated', now('Asia/Kathmandu')->format('Y-m-d H:i')]);
        fputcsv($file, []);
    }

    /**
     * @param  array<int, string>  $headers
     * @param  array<int, array<int, mixed>>  $rows
     */
    private function section($file, string $title, array $headers, array $rows): void
    {
        fputcsv($file, [$title]);
        fputcsv($file, $headers);

        foreach ($rows as $row) {
            fputcsv($file, $row);
        }

        fputcsv($file, []);
    }

    /**
     * @param  array<string, int>  $pairs
     * @return array<int, array{0: string, 1: int}>
     */
    private function pairs(array $pairs): array
    {
        $rows = [];

        foreach ($pairs as $label => $count) {
            $rows[] = [$label, $count];
        }

        return $rows;
    }

    /**
     * One row per location, so a spreadsheet can filter by country or city.
     * Views with no city stay on their own row and still add up to the article total.
     *
     * @return array<int, array<int, mixed>>
     */
    private function articleLocationRows(array $item): array
    {
        $base = [$item['title'], $item['url'] ?? '', $item['views'], $item['all_views'], $item['visitors']];

        if ($item['countries'] === []) {
            return [array_merge($base, ['', '', ''])];
        }

        $rows = [];

        foreach ($item['countries'] as $country) {
            $cities = $country['cities'];

            if ($cities === []) {
                $rows[] = array_merge($base, [$country['name'], '', $country['views']]);
                continue;
            }

            foreach ($cities as $city => $count) {
                $rows[] = array_merge($base, [$country['name'], $city, $count]);
            }

            $unspecified = $country['views'] - array_sum($cities);

            if ($unspecified > 0) {
                $rows[] = array_merge($base, [$country['name'], '', $unspecified]);
            }
        }

        return $rows;
    }
}
