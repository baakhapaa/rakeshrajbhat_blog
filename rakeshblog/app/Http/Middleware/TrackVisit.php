<?php

namespace App\Http\Middleware;

use App\Services\VisitTracker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackVisit
{
    /**
     * Records public page views and content views (blog, news, research) for the admin analytics page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $this->track($request, $response);
        } catch (Throwable $e) {
            Log::warning('Visit tracking failed: ' . $e->getMessage());
        }

        return $response;
    }

    private function track(Request $request, Response $response): void
    {
        if ($response->getStatusCode() !== 200 || !VisitTracker::isTrackable($request)) {
            return;
        }

        $content = VisitTracker::content($request);
        $isPage = !$request->ajax()
            && !$request->expectsJson()
            && str_contains((string) $response->headers->get('Content-Type'), 'text/html');

        if (!$isPage && $content === null) {
            return;
        }

        $visitId = VisitTracker::visitId($request);

        app()->terminating(static function () use ($visitId, $request, $content) {
            try {
                VisitTracker::recordPageView($visitId, $request, $content);
            } catch (Throwable $e) {
                Log::warning('Page view tracking failed: ' . $e->getMessage());
            }
        });
    }
}
