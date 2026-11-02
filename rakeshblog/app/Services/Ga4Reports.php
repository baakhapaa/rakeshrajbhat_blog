<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class Ga4Reports
{
    private const CACHE_SECONDS = 21600;
    private const ERROR_CACHE_SECONDS = 600;

    public static function isConfigured(): bool
    {
        $credentials = (string) config('services.ga4.credentials');

        return config('services.ga4.property_id') && $credentials !== '' && is_file($credentials);
    }

    /**
     * Active users by age bracket and by gender for the whole site, or for one page path.
     *
     * @return array{configured: bool, error: ?string, age: array<string, int>, gender: array<string, int>}
     */
    public static function demographics(int $days = 30, ?string $pagePath = null): array
    {
        if (!self::isConfigured()) {
            return ['configured' => false, 'error' => null, 'age' => [], 'gender' => []];
        }

        $key = 'ga4.demographics.' . md5($days . '|' . $pagePath);
        $cached = Cache::get($key);

        if (is_array($cached)) {
            return $cached;
        }

        try {
            $client = new BetaAnalyticsDataClient([
                'credentials' => (string) config('services.ga4.credentials'),
                'transport' => 'rest',
            ]);

            $result = [
                'configured' => true,
                'error' => null,
                'age' => self::breakdown($client, 'userAgeBracket', $days, $pagePath),
                'gender' => self::breakdown($client, 'userGender', $days, $pagePath),
            ];

            $client->close();
            Cache::put($key, $result, self::CACHE_SECONDS);
        } catch (Throwable $e) {
            Log::warning('GA4 report failed: ' . $e->getMessage());
            $result = ['configured' => true, 'error' => 'Google Analytics could not be reached. Check the property ID and service-account access.', 'age' => [], 'gender' => []];
            Cache::put($key, $result, self::ERROR_CACHE_SECONDS);
        }

        return $result;
    }

    /**
     * @return array<string, int>
     */
    private static function breakdown(BetaAnalyticsDataClient $client, string $dimension, int $days, ?string $pagePath): array
    {
        $request = (new RunReportRequest())
            ->setProperty('properties/' . config('services.ga4.property_id'))
            ->setDateRanges([new DateRange(['start_date' => $days . 'daysAgo', 'end_date' => 'today'])])
            ->setDimensions([new Dimension(['name' => $dimension])])
            ->setMetrics([new Metric(['name' => 'activeUsers'])]);

        if ($pagePath !== null && $pagePath !== '') {
            $request->setDimensionFilter(new FilterExpression([
                'filter' => new Filter([
                    'field_name' => 'pagePath',
                    'string_filter' => new StringFilter([
                        'match_type' => MatchType::EXACT,
                        'value' => $pagePath,
                    ]),
                ]),
            ]));
        }

        $rows = [];

        foreach ($client->runReport($request)->getRows() as $row) {
            $label = (string) $row->getDimensionValues()[0]->getValue();
            $label = $label === '' || $label === '(not set)' || $label === 'unknown' ? 'Unknown' : ucfirst($label);
            $rows[$label] = ($rows[$label] ?? 0) + (int) $row->getMetricValues()[0]->getValue();
        }

        uksort($rows, static fn ($a, $b) => $a === 'Unknown' ? 1 : ($b === 'Unknown' ? -1 : strnatcmp($a, $b)));

        return $rows;
    }
}
