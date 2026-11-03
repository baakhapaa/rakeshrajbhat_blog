@extends('admin.layouts.app')

@section('title', 'Analytics · Admin')

@section('content')
@php
    $sourceTotal = array_sum(array_column($sources, 'count'));
    $sourceItems = collect($sources)->filter(fn ($s) => $s['count'] > 0)->mapWithKeys(fn ($s) => [$s['label'] => $s['count']])->all();
@endphp
<div class="max-w-7xl mx-auto analytics-page">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-[#D4AF37]/10 border border-[#D4AF37]/20 flex items-center justify-center">
                <i class="fas fa-chart-pie text-[#D4AF37] text-lg"></i>
            </div>
            <div>
                <h1 class="text-3xl font-serif font-bold text-white">Analytics</h1>
                <p class="text-gray-500 text-xs mt-0.5">Website visits, traffic sources, readers and devices. Charts and breakdowns cover {{ $range ? 'the last ' . $range . ' days' : 'all time' }} (Nepal time).</p>
            </div>
        </div>
        <div class="analytics-toolbar">
            <nav class="analytics-range" aria-label="Date range">
                @foreach($ranges as $option)
                    <a href="{{ route('admin.analytics', array_filter(['range' => $option, 'page' => $selectedPage, 'content' => $contentType])) }}"
                       class="{{ $option === $range ? 'is-active' : '' }}">{{ $option }} days</a>
                @endforeach
                <a href="{{ route('admin.analytics', array_filter(['range' => 'all', 'page' => $selectedPage, 'content' => $contentType])) }}"
                   class="{{ $range === null ? 'is-active' : '' }}">All time</a>
            </nav>
            <a href="{{ route('admin.analytics.export', array_filter(['range' => $range ?? 'all', 'page' => $selectedPage])) }}" class="analytics-export">
                <i class="fas fa-download"></i> Export report
            </a>
        </div>
    </div>

    {{-- TOTAL WEBSITE VIEWS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        @foreach($totals as $period)
            <div class="analytics-card">
                <p class="analytics-card__label">{{ $period['label'] }}</p>
                <p class="analytics-card__number">{{ number_format($period['views']) }}</p>
                <p class="analytics-card__hint">page views</p>
                <div class="analytics-card__meta">
                    <span><strong>{{ number_format($period['visitors']) }}</strong> visitors</span>
                    <span><strong>{{ number_format($period['visits']) }}</strong> visits</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- TRAFFIC OVER TIME --}}
    <section class="analytics-section mb-6">
        <header class="analytics-section__header analytics-section__header--split">
            <div>
                <h2>Traffic over time</h2>
                <p>Daily page views, visits and unique visitors.</p>
            </div>
            <div class="analytics-legend-totals">
                <span><i style="background:#D4AF37"></i>{{ number_format(array_sum($daily['views'])) }} views</span>
                <span><i style="background:#60a5fa"></i>{{ number_format(array_sum($daily['visits'])) }} visits</span>
                <span><i style="background:#34d399"></i>{{ number_format(array_sum($daily['visitors'])) }} visitors</span>
            </div>
        </header>
        <div class="analytics-section__body">
            <div class="analytics-chart analytics-chart--line"><canvas id="trafficChart"></canvas></div>
        </div>
    </section>

    <section class="analytics-section mb-6">
        <header class="analytics-section__header">
            <h2>Traffic sources over time</h2>
            <p>Daily visits from direct, search, other websites, social media, ads and campaigns.</p>
        </header>
        <div class="analytics-section__body">
            @if(empty($daily['sources']))
                <p class="analytics-empty">No visits recorded in this period.</p>
            @else
                <div class="analytics-chart analytics-chart--line"><canvas id="sourcesBarChart"></canvas></div>
            @endif
        </div>
    </section>

    {{-- TRAFFIC SOURCES --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <section class="analytics-section">
            <header class="analytics-section__header">
                <h2>Where visitors come from</h2>
                <p>Direct means the visitor typed the address or used a bookmark. Other websites include news sites.</p>
            </header>
            <div class="analytics-section__body">
                @if($sourceTotal === 0)
                    <p class="analytics-empty">No visits recorded yet.</p>
                @else
                    <div class="analytics-chart analytics-chart--doughnut"><canvas id="sourcesChart"></canvas></div>
                    @include('admin.analytics.partials.bar-list', ['items' => $sourceItems])
                @endif
            </div>
        </section>

        <section class="analytics-section">
            <header class="analytics-section__header">
                <h2>Top referring websites</h2>
                <p>Sites that sent visitors here, such as news sites, search engines and social media.</p>
            </header>
            <div class="analytics-section__body">
                @if($referrers->isEmpty())
                    <p class="analytics-empty">No visits from other websites yet.</p>
                @else
                    <table class="analytics-table">
                        <thead>
                            <tr><th>Website</th><th>Type</th><th class="text-right">Visits</th></tr>
                        </thead>
                        <tbody>
                            @foreach($referrers as $referrer)
                                <tr>
                                    <td class="text-white">{{ $referrer['host'] }}</td>
                                    <td>{{ $referrer['source'] }}</td>
                                    <td class="text-right text-[#D4AF37] font-semibold">{{ number_format($referrer['count']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>
    </div>

    {{-- VIEWS BY ARTICLE --}}
    @php
        $contentLabels = ['blog' => ['Blogs', 'blogs'], 'news' => ['News', 'news items'], 'research' => ['Research', 'research items']];
    @endphp
    <section class="analytics-section mb-6">
        <header class="analytics-section__header analytics-section__header--split">
            <div>
                <h2>Views by article</h2>
                <p>Every item with its views and where its readers are. Click a row to see all its locations. {{ $contentArticles->perPage() }} per page. Each export includes every item for this date range.</p>
            </div>
            <div class="analytics-article-tools">
                <select id="contentTypeSelect" class="analytics-select" aria-label="Content type">
                    @foreach($contentLabels as $type => [$label])
                        <option value="{{ $type }}" @selected($contentType === $type)>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="analytics-exports" aria-label="Export views by article">
                    @foreach($contentLabels as $type => [$label])
                        <a href="{{ route('admin.analytics.export-articles', ['range' => $range ?? 'all', 'content' => $type]) }}" class="analytics-export analytics-export--small">
                            <i class="fas fa-download"></i> {{ $label }} CSV
                        </a>
                    @endforeach
                </div>
            </div>
        </header>
        <div class="analytics-section__body overflow-x-auto">
            @if($contentArticles->isEmpty())
                <p class="analytics-empty">No {{ $contentLabels[$contentType][1] }} yet.</p>
            @else
                <table class="analytics-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="text-right whitespace-nowrap">Views ({{ $range ? $range . ' days' : 'all time' }})</th>
                            <th class="text-right whitespace-nowrap">All time</th>
                            <th class="text-right">Visitors</th>
                            <th>Locations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contentArticles as $item)
                            @php $hasLocations = !empty($item['countries']); @endphp
                            <tr class="{{ $hasLocations ? 'analytics-content__row' : '' }}" @if($hasLocations) data-toggle-row="{{ $contentType }}-{{ $item['id'] }}" tabindex="0" aria-expanded="false" @endif>
                                <td class="text-white max-w-[340px] truncate" title="{{ $item['title'] }}">
                                    @if($hasLocations)<i class="fas fa-chevron-right analytics-content__caret"></i>@endif
                                    @if($item['url'])
                                        <a href="{{ $item['url'] }}" target="_blank" class="analytics-content__link">{{ $item['title'] }}</a>
                                    @else
                                        {{ $item['title'] }}
                                    @endif
                                </td>
                                <td class="text-right font-semibold {{ $item['views'] > 0 ? 'text-[#D4AF37]' : 'text-white/30' }}">{{ number_format($item['views']) }}</td>
                                <td class="text-right">{{ number_format($item['all_views']) }}</td>
                                <td class="text-right">{{ number_format($item['visitors']) }}</td>
                                <td>
                                    @if(!$hasLocations)
                                        <span class="text-white/30">No views yet</span>
                                    @else
                                        <div class="analytics-chips">
                                            @foreach(array_slice($item['countries'], 0, 3) as $country)
                                                <span class="analytics-chip">{{ $country['name'] }} <strong>{{ number_format($country['views']) }}</strong></span>
                                            @endforeach
                                            @if(count($item['countries']) > 3)
                                                <span class="analytics-chip analytics-chip--more">+{{ count($item['countries']) - 3 }} more</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @if($hasLocations)
                                <tr class="analytics-content__detail" data-detail-row="{{ $contentType }}-{{ $item['id'] }}" hidden>
                                    <td colspan="5">
                                        <div class="analytics-locations">
                                            @foreach($item['countries'] as $country)
                                                <div class="analytics-location">
                                                    <div class="analytics-bars__row">
                                                        <span class="analytics-bars__label">
                                                            @if($country['code'])<span class="analytics-code">{{ $country['code'] }}</span>@endif{{ $country['name'] }}
                                                        </span>
                                                        <span class="analytics-bars__value">{{ number_format($country['views']) }}<small>{{ round($country['views'] / max(1, $item['views']) * 100) }}%</small></span>
                                                    </div>
                                                    <div class="analytics-bars__track"><span style="width: {{ round($country['views'] / max(1, $item['views']) * 100, 1) }}%"></span></div>
                                                    @if(!empty($country['cities']))
                                                        <p class="analytics-location__cities">
                                                            {{ collect($country['cities'])->map(fn ($count, $city) => $city . ' ' . number_format($count))->implode(' · ') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                @if($contentArticles->hasPages())
                    <div class="analytics-content__pager">
                        <p class="analytics-content__pager-meta">
                            Showing {{ $contentArticles->firstItem() }}–{{ $contentArticles->lastItem() }} of {{ number_format($contentArticles->total()) }} {{ $contentLabels[$contentType][1] }}
                        </p>
                        {{ $contentArticles->withQueryString()->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- LOCATIONS --}}
    <section class="analytics-section mb-6">
        <header class="analytics-section__header">
            <h2>Traffic by country</h2>
            <p>Brighter gold means more visits. Hover a country to see its numbers.</p>
        </header>
        <div class="analytics-section__body">
            @if($countries->isEmpty())
                <p class="analytics-empty">No country data yet. Countries appear once the site runs behind Cloudflare.</p>
            @else
                <div class="analytics-geo">
                    <div id="countryMap" class="analytics-map"></div>
                    <div class="analytics-geo__table">
                        <table class="analytics-table">
                            <thead>
                                <tr>
                                    <th>Country</th>
                                    <th class="text-right">Visits</th>
                                    <th class="text-right">Views</th>
                                    <th class="text-right">Share</th>
                                </tr>
                            </thead>
                            <tbody id="countryTableBody">
                                @foreach($countries as $country)
                                    <tr data-country-row @if($loop->index >= 12) hidden @endif>
                                        <td class="text-white">
                                            <span class="analytics-code">{{ $country['code'] }}</span>{{ $country['name'] }}
                                        </td>
                                        <td class="text-right text-[#D4AF37] font-semibold">{{ number_format($country['visits']) }}</td>
                                        <td class="text-right">{{ number_format($country['views']) }}</td>
                                        <td class="text-right whitespace-nowrap">
                                            <div class="analytics-share"><span style="width: {{ $country['share'] }}%"></span></div>
                                            {{ $country['share'] }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($countries->count() > 12)
                            <div class="analytics-content__pager" id="countryPager">
                                <p class="analytics-content__pager-meta" id="countryPagerMeta"></p>
                                <nav aria-label="Countries">
                                    <ul class="pagination" id="countryPagerPages"></ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <section class="analytics-section">
            <header class="analytics-section__header">
                <h2>Top cities</h2>
                <p>Visits by city.</p>
            </header>
            <div class="analytics-section__body">
                @include('admin.analytics.partials.bar-list', ['items' => $cities, 'empty' => config('services.geoip.city_db') ? 'No city data yet.' : 'City data needs the GeoLite2-City database (set GEOIP_CITY_DB in .env).'])
            </div>
        </section>

        {{-- DEVICES --}}
        <section class="analytics-section">
            <header class="analytics-section__header">
                <h2>Devices</h2>
                <p>Mobile, tablet and desktop.</p>
            </header>
            <div class="analytics-section__body">
                @if(empty($devices))
                    <p class="analytics-empty">No visits recorded yet.</p>
                @else
                    <div class="analytics-chart analytics-chart--doughnut"><canvas id="devicesChart"></canvas></div>
                    @include('admin.analytics.partials.bar-list', ['items' => $devices])
                @endif
            </div>
        </section>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <section class="analytics-section">
            <header class="analytics-section__header">
                <h2>Browsers</h2>
                <p>Most used browsers.</p>
            </header>
            <div class="analytics-section__body">
                @include('admin.analytics.partials.bar-list', ['items' => $browsers, 'empty' => 'No visits recorded yet.'])
            </div>
        </section>

        <section class="analytics-section">
            <header class="analytics-section__header">
                <h2>Operating systems</h2>
                <p>Android, iOS, Windows and others.</p>
            </header>
            <div class="analytics-section__body">
                @include('admin.analytics.partials.bar-list', ['items' => $operatingSystems, 'empty' => 'No visits recorded yet.'])
            </div>
        </section>
    </div>

    {{-- AGE AND GENDER (GA4) --}}
    <section class="analytics-section mb-6">
        <header class="analytics-section__header analytics-section__header--split">
            <div>
                <h2>Age and gender</h2>
                <p>Estimated by Google Analytics 4 for {{ $range ? 'the last ' . $range . ' days' : 'all time' }}. Updates every 6 hours.</p>
            </div>
            @if($demographics['configured'])
                <form method="GET" action="{{ route('admin.analytics') }}">
                    <input type="hidden" name="range" value="{{ $range ?? 'all' }}">
                    <input type="hidden" name="content" value="{{ $contentType }}">
                    <select name="page" class="analytics-select" onchange="this.form.submit()">
                        @foreach($demographicPages as $path => $label)
                            <option value="{{ $path }}" @selected($selectedPage === $path)>{{ \Illuminate\Support\Str::limit($label, 60) }}</option>
                        @endforeach
                    </select>
                </form>
            @endif
        </header>
        <div class="analytics-section__body">
            @if(!$demographics['configured'])
                <p class="analytics-empty">
                    Google Analytics is not connected yet. Set GA_MEASUREMENT_ID, GA4_PROPERTY_ID and GA4_CREDENTIALS in .env,
                    and turn on Google Signals in the GA4 admin.
                </p>
            @elseif($demographics['error'])
                <p class="analytics-empty text-red-300">{{ $demographics['error'] }}</p>
            @elseif(empty($demographics['age']) && empty($demographics['gender']))
                <p class="analytics-empty">Not enough data yet. Google only shows age and gender once enough visitors have been counted.</p>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="analytics-subtitle">Age</h3>
                        <div class="analytics-chart"><canvas id="ageChart"></canvas></div>
                    </div>
                    <div>
                        <h3 class="analytics-subtitle">Gender</h3>
                        <div class="analytics-chart"><canvas id="genderChart"></canvas></div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .analytics-card,
    .analytics-section {
        background: #1a1f26;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
    }

    .analytics-card {
        padding: 22px;
    }

    .analytics-card,
    .analytics-section {
        min-width: 0;
    }

    .analytics-card__label {
        color: rgba(255, 255, 255, 0.58);
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .analytics-card__number {
        color: #fff;
        font-size: 30px;
        line-height: 1;
        font-weight: 700;
    }

    .analytics-card__hint {
        color: rgba(255, 255, 255, 0.32);
        font-size: 11px;
        margin-top: 6px;
    }

    .analytics-card__meta {
        display: flex;
        gap: 16px;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.45);
        font-size: 12px;
    }

    .analytics-card__meta strong {
        color: #D4AF37;
    }

    .analytics-section__header {
        padding: 18px 22px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .analytics-section__header--split {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .analytics-section__header h2 {
        color: #fff;
        font-size: 15px;
        font-weight: 600;
    }

    .analytics-section__header p {
        color: rgba(255, 255, 255, 0.35);
        font-size: 11px;
        margin-top: 3px;
    }

    .analytics-section__body {
        padding: 18px 22px 22px;
    }

    .analytics-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .analytics-empty {
        color: rgba(255, 255, 255, 0.4);
        font-size: 13px;
        padding: 18px 0;
    }

    .analytics-chart {
        position: relative;
        height: 240px;
    }

    .analytics-chart--doughnut {
        height: 200px;
        margin-bottom: 18px;
    }

    .analytics-bars {
        display: grid;
        gap: 12px;
    }

    .analytics-bars__row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .analytics-bars__label {
        color: rgba(255, 255, 255, 0.8);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .analytics-bars__value {
        color: #fff;
        font-weight: 600;
        white-space: nowrap;
    }

    .analytics-bars__value small {
        color: rgba(255, 255, 255, 0.35);
        font-weight: 400;
        margin-left: 4px;
    }

    .analytics-bars__track {
        height: 6px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.05);
        overflow: hidden;
    }

    .analytics-bars__track span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #b8932a, #D4AF37);
    }

    .analytics-table {
        width: 100%;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.6);
    }

    .analytics-table th {
        color: rgba(255, 255, 255, 0.45);
        font-weight: 500;
        text-align: left;
        padding: 0 10px 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .analytics-table th.text-right {
        text-align: right;
    }

    .analytics-table td {
        padding: 11px 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .analytics-pill {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        color: #D4AF37;
        background: rgba(212, 175, 55, 0.1);
    }

    .analytics-select {
        max-width: 320px;
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: #11151a;
        color: #fff;
        font-size: 13px;
    }

    .analytics-content__row {
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .analytics-content__row:hover,
    .analytics-content__row:focus-visible {
        background: rgba(255, 255, 255, 0.025);
        outline: none;
    }

    .analytics-content__caret {
        width: 12px;
        margin-right: 8px;
        color: rgba(255, 255, 255, 0.35);
        font-size: 10px;
        transition: transform 0.2s ease;
    }

    .analytics-content__row[aria-expanded="true"] .analytics-content__caret {
        transform: rotate(90deg);
        color: #D4AF37;
    }

    .analytics-content__link {
        color: inherit;
        text-decoration: none;
    }

    .analytics-content__link:hover {
        color: #D4AF37;
    }

    .analytics-content__detail > td {
        padding: 6px 10px 18px 30px;
        background: rgba(0, 0, 0, 0.12);
    }

    .analytics-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .analytics-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        white-space: nowrap;
        color: rgba(255, 255, 255, 0.75);
        background: rgba(255, 255, 255, 0.05);
    }

    .analytics-chip strong {
        color: #D4AF37;
        font-weight: 600;
    }

    .analytics-chip--more {
        color: rgba(255, 255, 255, 0.45);
    }

    .analytics-locations {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px 24px;
        padding-top: 10px;
    }

    .analytics-location {
        min-width: 0;
    }

    .analytics-location__cities {
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.4);
        font-size: 11px;
    }

    .analytics-content__pager {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .analytics-content__pager-meta {
        color: rgba(255, 255, 255, 0.45);
        font-size: 12px;
    }

    .analytics-content__pager nav {
        margin-left: auto;
    }

    .analytics-content__pager .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .analytics-content__pager .page-link,
    .analytics-content__pager .page-item span {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font: inherit;
        font-size: 12px;
        line-height: 1.2;
        text-decoration: none;
        cursor: pointer;
        color: rgba(255, 255, 255, 0.65);
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .analytics-content__pager .page-item.active span {
        color: #0b0e12;
        background: #D4AF37;
        border-color: #D4AF37;
    }

    .analytics-content__pager .page-item.disabled span {
        opacity: 0.35;
    }

    .analytics-content__pager .page-link:hover {
        color: #fff;
        border-color: rgba(212, 175, 55, 0.35);
    }

    .analytics-range {
        display: inline-flex;
        flex-wrap: wrap;
        padding: 4px;
        border-radius: 12px;
        background: #1a1f26;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .analytics-range a {
        padding: 7px 14px;
        border-radius: 9px;
        color: rgba(255, 255, 255, 0.55);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .analytics-range a:hover {
        color: #fff;
    }

    .analytics-range a.is-active {
        color: #0b0e12;
        background: #D4AF37;
    }

    .analytics-toolbar,
    .analytics-article-tools {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }

    .analytics-exports {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .analytics-export {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid rgba(212, 175, 55, 0.35);
        background: rgba(212, 175, 55, 0.12);
        color: #D4AF37;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .analytics-export:hover {
        background: #D4AF37;
        color: #0b0e12;
    }

    .analytics-export--small {
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    @media (min-width: 640px) {
        .analytics-toolbar,
        .analytics-article-tools,
        .analytics-exports {
            align-items: flex-end;
            justify-content: flex-end;
        }
    }

    .analytics-chart--line {
        height: 300px;
    }

    .analytics-legend-totals {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        color: rgba(255, 255, 255, 0.75);
        font-size: 13px;
        font-weight: 600;
    }

    .analytics-legend-totals i {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 3px;
        margin-right: 7px;
    }

    .analytics-geo {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }

    .analytics-map {
        height: 360px;
        border-radius: 12px;
        background: #11151a;
    }

    .analytics-code {
        display: inline-block;
        min-width: 28px;
        margin-right: 8px;
        padding: 2px 5px;
        border-radius: 5px;
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.55);
        font-size: 10px;
        font-weight: 600;
        text-align: center;
    }

    .analytics-share {
        display: inline-block;
        width: 54px;
        height: 5px;
        margin-right: 6px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.06);
        overflow: hidden;
        vertical-align: middle;
    }

    .analytics-share span {
        display: block;
        height: 100%;
        background: #D4AF37;
    }

    .jvm-tooltip {
        padding: 7px 10px;
        border-radius: 8px;
        background: #0b0e12;
        border: 1px solid rgba(212, 175, 55, 0.35);
        color: #fff;
        font-family: inherit;
        font-size: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    @media (max-width: 1023px) {
        .analytics-geo {
            grid-template-columns: 1fr;
        }

        .analytics-map {
            height: 260px;
        }
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.6.0/dist/jsvectormap.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.6.0/dist/jsvectormap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.6.0/dist/maps/world.js"></script>
<script>
    (() => {
        const typeSelect = document.getElementById('contentTypeSelect');

        typeSelect?.addEventListener('change', () => {
            const url = new URL(window.location.href);
            url.searchParams.set('content', typeSelect.value);
            url.searchParams.set('articles_page', '1');
            window.location.href = url.toString();
        });

        const toggleRow = (row) => {
            const detail = document.querySelector(`[data-detail-row="${row.dataset.toggleRow}"]`);
            if (!detail) return;
            detail.hidden = !detail.hidden;
            row.setAttribute('aria-expanded', String(!detail.hidden));
        };

        document.querySelectorAll('[data-toggle-row]').forEach((row) => {
            row.addEventListener('click', (event) => {
                if (!event.target.closest('a')) toggleRow(row);
            });
            row.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    toggleRow(row);
                }
            });
        });
    })();

    (() => {
        const countries = @json($countries->values());
        const countryRows = [...document.querySelectorAll('[data-country-row]')];
        const countryPerPage = 12;
        const countryPages = Math.ceil(countryRows.length / countryPerPage);
        const countryMeta = document.getElementById('countryPagerMeta');
        const countryPager = document.getElementById('countryPagerPages');

        const showCountryPage = (page) => {
            const current = Math.min(Math.max(page, 1), countryPages);
            const start = (current - 1) * countryPerPage;
            countryRows.forEach((row, index) => {
                row.hidden = index < start || index >= start + countryPerPage;
            });
            if (countryMeta) {
                const end = Math.min(start + countryPerPage, countryRows.length);
                countryMeta.textContent = `Showing ${start + 1}–${end} of ${countryRows.length} countries`;
            }
            if (!countryPager) return;
            countryPager.innerHTML = '';
            const addItem = (label, target, disabled, active) => {
                const item = document.createElement('li');
                item.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
                if (disabled || active) {
                    const span = document.createElement('span');
                    span.textContent = label;
                    item.appendChild(span);
                } else {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'page-link';
                    button.textContent = label;
                    button.addEventListener('click', () => showCountryPage(target));
                    item.appendChild(button);
                }
                countryPager.appendChild(item);
            };
            addItem('Prev', current - 1, current === 1, false);
            for (let number = 1; number <= countryPages; number++) addItem(String(number), number, false, number === current);
            addItem('Next', current + 1, current === countryPages, false);
        };

        if (countryPages > 1) showCountryPage(1);

        if (window.jsVectorMap && document.getElementById('countryMap')) {
            const byCode = Object.fromEntries(countries.map((c) => [c.code, c]));
            const shades = ['#4a3f1c', '#6e5a22', '#957a28', '#bb982f', '#e2bb3d'];
            const maxVisits = Math.max(1, ...countries.map((c) => c.visits));
            const shadeOf = (visits) => {
                const level = Math.log(1 + visits) / Math.log(1 + maxVisits);
                return 'shade' + Math.min(shades.length - 1, Math.floor(level * shades.length));
            };

            new jsVectorMap({
                selector: '#countryMap',
                map: 'world',
                zoomButtons: true,
                zoomOnScroll: false,
                backgroundColor: 'transparent',
                regionStyle: {
                    initial: { fill: '#2a313b', stroke: '#11151a', strokeWidth: 0.4, fillOpacity: 1 },
                    hover: { fill: '#f0d36b', fillOpacity: 1, cursor: 'pointer' },
                },
                series: {
                    regions: [{
                        attribute: 'fill',
                        scale: Object.fromEntries(shades.map((color, i) => ['shade' + i, color])),
                        values: Object.fromEntries(countries.map((c) => [c.code, shadeOf(c.visits)])),
                    }],
                },
                onRegionTooltipShow(event, tooltip, code) {
                    const row = byCode[code];
                    const name = tooltip.text();
                    tooltip.text(row
                        ? `<strong>${name}</strong><br>${row.visits.toLocaleString()} visits · ${row.views.toLocaleString()} views<br>${row.share}% of traffic`
                        : `<strong>${name}</strong><br>No visits`, true);
                },
            });
        }

        if (!window.Chart) return;

        const palette = ['#D4AF37', '#60a5fa', '#34d399', '#a78bfa', '#f87171', '#fb923c', '#94a3b8', '#f472b6'];
        const sourceLabels = @json(array_values(\App\Support\TrafficSource::LABELS));
        const sourceColor = (label) => palette[Math.max(0, sourceLabels.indexOf(label)) % palette.length];
        Chart.defaults.color = 'rgba(255, 255, 255, 0.6)';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.06)';

        const fade = (hex, alpha) => {
            const n = parseInt(hex.slice(1), 16);
            return `rgba(${n >> 16}, ${(n >> 8) & 255}, ${n & 255}, ${alpha})`;
        };

        const lineDataset = (label, data, color, filled) => ({
            label,
            data,
            borderColor: color,
            borderWidth: 2,
            pointRadius: 0,
            pointHoverRadius: 4,
            pointBackgroundColor: color,
            cubicInterpolationMode: 'monotone',
            fill: filled ? 'origin' : false,
            backgroundColor: (ctx) => {
                const { chart } = ctx;
                if (!filled || !chart.chartArea) return 'transparent';
                const gradient = chart.ctx.createLinearGradient(0, chart.chartArea.top, 0, chart.chartArea.bottom);
                gradient.addColorStop(0, fade(color, 0.28));
                gradient.addColorStop(1, fade(color, 0));
                return gradient;
            },
        });

        const lineChart = (id, labels, datasets) => {
            const canvas = document.getElementById(id);
            if (!canvas) return;
            new Chart(canvas, {
                type: 'line',
                data: { labels, datasets },
                options: {
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { boxWidth: 10, boxHeight: 10, usePointStyle: true } },
                        tooltip: { backgroundColor: '#0b0e12', borderColor: 'rgba(212, 175, 55, 0.35)', borderWidth: 1, padding: 10 },
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 10, maxRotation: 0 } },
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });
        };

        const daily = @json($daily);

        lineChart('trafficChart', daily.labels, [
            lineDataset('Page views', daily.views, '#D4AF37', true),
            lineDataset('Visits', daily.visits, '#60a5fa', false),
            lineDataset('Visitors', daily.visitors, '#34d399', false),
        ]);

        const sourcesCanvas = document.getElementById('sourcesBarChart');
        if (sourcesCanvas) {
            new Chart(sourcesCanvas, {
                type: 'bar',
                data: {
                    labels: daily.labels,
                    datasets: Object.entries(daily.sources).map(([label, data]) => ({
                        label,
                        data,
                        backgroundColor: sourceColor(label),
                        borderRadius: 3,
                        borderSkipped: false,
                        maxBarThickness: 22,
                    })),
                },
                options: {
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { boxWidth: 10, boxHeight: 10, usePointStyle: true } },
                        tooltip: {
                            backgroundColor: '#0b0e12',
                            borderColor: 'rgba(212, 175, 55, 0.35)',
                            borderWidth: 1,
                            padding: 10,
                            filter: (item) => item.raw > 0,
                            footer: (items) => 'Total: ' + items.reduce((sum, item) => sum + item.raw, 0),
                        },
                    },
                    scales: {
                        x: { stacked: true, grid: { display: false }, ticks: { maxTicksLimit: 10, maxRotation: 0 } },
                        y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });
        }

        const doughnut = (id, data, colors = palette) => {
            const canvas = document.getElementById(id);
            if (!canvas) return;
            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(data),
                    datasets: [{ data: Object.values(data), backgroundColor: colors, borderWidth: 0 }],
                },
                options: { maintainAspectRatio: false, cutout: '65%', plugins: { legend: { position: 'right' } } },
            });
        };

        const bars = (id, data) => {
            const canvas = document.getElementById(id);
            if (!canvas) return;
            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: Object.keys(data),
                    datasets: [{ label: 'Active users', data: Object.values(data), backgroundColor: '#D4AF37', borderRadius: 6 }],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                },
            });
        };

        const sourceItems = @json((object) $sourceItems);
        doughnut('sourcesChart', sourceItems, Object.keys(sourceItems).map(sourceColor));
        doughnut('devicesChart', @json((object) $devices));
        bars('ageChart', @json((object) $demographics['age']));
        bars('genderChart', @json((object) $demographics['gender']));
    })();
</script>
@endpush
