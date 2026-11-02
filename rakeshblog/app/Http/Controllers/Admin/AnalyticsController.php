<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ga4Reports;
use App\Services\SiteAnalytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $range = (int) $request->query('range', 30);
        $range = in_array($range, SiteAnalytics::RANGES, true) ? $range : 30;

        $analytics = new SiteAnalytics($range);
        $pages = $analytics->demographicPages();
        $selectedPage = (string) $request->query('page', '');

        if (!array_key_exists($selectedPage, $pages)) {
            $selectedPage = '';
        }

        return view('admin.analytics.index', [
            'range' => $range,
            'ranges' => SiteAnalytics::RANGES,
            'totals' => $analytics->totals(),
            'daily' => $analytics->dailyTraffic(),
            'sources' => $analytics->sources(),
            'referrers' => $analytics->topReferrers(),
            'content' => $analytics->contentPerformance(),
            'topLists' => [
                'Top 5 Blogs' => ['icon' => 'fa-newspaper', 'items' => $analytics->topContent('blog')],
                'Top 5 Research' => ['icon' => 'fa-flask', 'items' => $analytics->topContent('research')],
                'Top 5 News' => ['icon' => 'fa-rss', 'items' => $analytics->topContent('news')],
            ],
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
}
