<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceCanonicalUrl
{
    /**
     * Redirect production requests to the configured HTTPS apex URL.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $canonicalUrl = rtrim((string) config('app.url'), '/');
        $canonical = parse_url($canonicalUrl);

        if (
            app()->environment('production')
            && is_array($canonical)
            && ($canonical['scheme'] ?? null) === 'https'
            && !empty($canonical['host'])
        ) {
            $forwardedProto = $request->header('X-Forwarded-Proto');
            $scheme = $forwardedProto ? strtolower(trim(explode(',', $forwardedProto)[0])) : $request->getScheme();
            $host = strtolower($request->getHost());
            $canonicalHost = strtolower($canonical['host']);

            if ($scheme !== 'https' || $host !== $canonicalHost) {
                $target = $canonicalUrl . $request->getPathInfo();

                if ($request->getQueryString()) {
                    $target .= '?' . $request->getQueryString();
                }

                return redirect()->to($target, 301);
            }
        }

        return $next($request);
    }
}
