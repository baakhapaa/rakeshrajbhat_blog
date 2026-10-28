<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class NewsSourceReader
{
    private const MAX_HTML_BYTES = 1500000;

    private const MAX_IMAGE_BYTES = 4000000;

    public function read(string $url): array
    {
        [$finalUrl, $html] = $this->fetchHtml($url);

        return $this->fromHtml($html, $finalUrl);
    }

    public function fromHtml(string $html, string $pageUrl): array
    {
        $pageUrl = $this->normalizeUrl($pageUrl);
        $this->assertPublicUrl($pageUrl);

        $document = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NOWARNING | LIBXML_NOERROR);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new \DOMXPath($document);
        $meta = $this->metaMap($xpath);
        $jsonLd = $this->jsonLd($xpath);

        $title = $this->firstText([
            $meta['og:title'] ?? null,
            $meta['twitter:title'] ?? null,
            $jsonLd['headline'] ?? null,
            $this->nodeText($xpath->query('//title')->item(0)),
        ]);

        if ($title === '') {
            throw new InvalidArgumentException('That page did not include a news title.');
        }

        $excerpt = $this->firstText([
            $meta['og:description'] ?? null,
            $meta['description'] ?? null,
            $meta['twitter:description'] ?? null,
            $jsonLd['description'] ?? null,
        ]);

        $content = $this->articleHtml($xpath, (string) ($jsonLd['articleBody'] ?? ''));

        if ($content === '' && $excerpt !== '') {
            $content = '<p>'.e($excerpt).'</p>';
        }

        $sourceName = $this->firstText([
            $meta['og:site_name'] ?? null,
            $jsonLd['publisher'] ?? null,
            $this->hostLabel($pageUrl),
        ]);

        $imageUrls = $this->imageUrls($xpath, $meta, $jsonLd, $pageUrl);
        $storedImages = $this->storeImages($imageUrls);

        return [
            'source_url' => $pageUrl,
            'source_hash' => hash('sha256', $pageUrl),
            'source_name' => Str::limit($sourceName, 120, ''),
            'title' => Str::limit($title, 250, ''),
            'excerpt' => $excerpt !== '' ? Str::limit($excerpt, 500, '') : null,
            'content' => $content !== '' ? $content : null,
            'image_url' => $storedImages[0] ?? null,
            'images' => $storedImages,
            'published_at' => $this->publishedAt($meta['article:published_time'] ?? null, $jsonLd['datePublished'] ?? null),
        ];
    }

    private function fetchHtml(string $url): array
    {
        $current = $this->normalizeUrl($url);

        for ($hop = 0; $hop < 4; $hop++) {
            try {
                $response = $this->fetchPublic($current, 'text/html,application/xhtml+xml');
            } catch (InvalidArgumentException $exception) {
                throw $exception;
            } catch (\Throwable $exception) {
                throw new RuntimeException('That link could not be opened. Check it and try again.');
            }

            if ($response === null) {
                throw new RuntimeException('That link could not be opened. Check it and try again.');
            }

            if ($response->redirect()) {
                $location = $response->header('Location');

                if (! is_string($location) || trim($location) === '') {
                    throw new RuntimeException('That link could not be opened. Check it and try again.');
                }

                $current = $this->absoluteUrl($location, $current) ?? $location;
                continue;
            }

            if (! $response->successful()) {
                throw new RuntimeException('That page did not respond. Check the link and try again.');
            }

            $type = strtolower((string) $response->header('Content-Type'));

            if ($type !== '' && ! str_contains($type, 'html') && ! str_contains($type, 'xml') && ! str_contains($type, 'text/plain')) {
                throw new InvalidArgumentException('Paste a link to a news article page.');
            }

            $html = $response->body();

            if (strlen($html) > self::MAX_HTML_BYTES) {
                $html = substr($html, 0, self::MAX_HTML_BYTES);
            }

            if (trim($html) === '') {
                throw new RuntimeException('That page did not include any news.');
            }

            return [$current, $html];
        }

        throw new RuntimeException('That link redirected too many times.');
    }

    private function articleHtml(\DOMXPath $xpath, string $jsonBody): string
    {
        $jsonHtml = $this->paragraphsFromText($jsonBody);
        $root = $xpath->query('//article | //*[@itemprop="articleBody"] | //main')->item(0);
        $nodes = $root
            ? $xpath->query('.//h2 | .//h3 | .//p | .//blockquote', $root)
            : $xpath->query('//h2 | //h3 | //p');

        $blocks = [];

        if ($nodes) {
            foreach ($nodes as $node) {
                $text = $this->cleanText($node->textContent ?? '');

                if ($text === '' || $this->isBoilerplate($text)) {
                    continue;
                }

                $tag = strtolower($node->nodeName);
                $isHeading = in_array($tag, ['h2', 'h3'], true);

                if (! $isHeading && mb_strlen($text) < 40) {
                    continue;
                }

                $element = $isHeading ? 'h3' : ($tag === 'blockquote' ? 'blockquote' : 'p');
                $blocks[] = '<'.$element.'>'.e($text).'</'.$element.'>';

                if (count($blocks) >= 40) {
                    break;
                }
            }
        }

        $html = implode('', $blocks);

        if (mb_strlen(strip_tags($jsonHtml)) > mb_strlen(strip_tags($html))) {
            return $jsonHtml;
        }

        return $html;
    }

    private function paragraphsFromText(string $text): string
    {
        $text = trim(html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        if ($text === '') {
            return '';
        }

        $parts = preg_split("/\n{2,}/", $text) ?: [];
        $blocks = [];

        foreach ($parts as $part) {
            $part = $this->cleanText($part);

            if (mb_strlen($part) < 40 || $this->isBoilerplate($part)) {
                continue;
            }

            $blocks[] = '<p>'.e($part).'</p>';

            if (count($blocks) >= 40) {
                break;
            }
        }

        return implode('', $blocks);
    }

    private function imageUrls(\DOMXPath $xpath, array $meta, array $jsonLd, string $pageUrl): array
    {
        $candidates = [
            $meta['og:image'] ?? null,
            $meta['og:image:url'] ?? null,
            $meta['twitter:image'] ?? null,
            $meta['twitter:image:src'] ?? null,
        ];

        $jsonImages = $jsonLd['image'] ?? null;

        if (is_string($jsonImages)) {
            $candidates[] = $jsonImages;
        } elseif (is_array($jsonImages)) {
            foreach ($jsonImages as $image) {
                $candidates[] = is_array($image) ? ($image['url'] ?? null) : $image;
            }
        }

        $article = $xpath->query('//article | //*[@itemprop="articleBody"] | //main')->item(0);
        $images = $article
            ? $xpath->query('.//img', $article)
            : $xpath->query('//img');

        if ($images) {
            foreach ($images as $image) {
                $candidates[] = $image->getAttribute('src');
                $candidates[] = $image->getAttribute('data-src');
                $srcset = $image->getAttribute('srcset');

                if ($srcset !== '') {
                    $first = trim(strtok($srcset, ','));
                    $candidates[] = trim(strtok($first, ' '));
                }
            }
        }

        $urls = [];

        foreach ($candidates as $candidate) {
            if (! is_string($candidate) || trim($candidate) === '') {
                continue;
            }

            $absolute = $this->absoluteUrl(trim(html_entity_decode($candidate)), $pageUrl);

            if (! $absolute || isset($urls[$absolute])) {
                continue;
            }

            $path = strtolower((string) parse_url($absolute, PHP_URL_PATH));

            if (str_ends_with($path, '.svg') || str_ends_with($path, '.gif') || str_contains($path, 'sprite') || str_contains($path, 'logo') || str_contains($path, 'icon')) {
                continue;
            }

            $urls[$absolute] = true;
            break;
        }

        return array_keys($urls);
    }

    private function storeImages(array $urls): array
    {
        $stored = [];

        foreach ($urls as $url) {
            $response = null;

            for ($hop = 0; $hop < 4; $hop++) {
                try {
                    $response = $this->fetchPublic($url, 'image/*,*/*');
                } catch (\Throwable $exception) {
                    $response = null;
                    break;
                }

                if ($response === null || ! $response->redirect()) {
                    break;
                }

                $location = $response->header('Location');
                $next = is_string($location) ? $this->absoluteUrl($location, $url) : null;

                if ($next === null) {
                    $response = null;
                    break;
                }

                $url = $next;
                $response = null;
            }

            if ($response === null || ! $response->successful()) {
                continue;
            }

            $body = $response->body();

            if ($body === '' || strlen($body) > self::MAX_IMAGE_BYTES) {
                continue;
            }

            $type = strtolower(strtok((string) $response->header('Content-Type'), ';') ?: '');
            $extension = match ($type) {
                'image/jpeg', 'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                default => null,
            };

            if ($extension === null) {
                continue;
            }

            $path = 'news/'.Str::uuid().'.'.$extension;
            Storage::disk('media')->put($path, $body);
            $stored[] = Storage::disk('media')->url($path);
        }

        return $stored;
    }

    private function metaMap(\DOMXPath $xpath): array
    {
        $map = [];
        $nodes = $xpath->query('//meta[@property or @name]');

        if (! $nodes) {
            return $map;
        }

        foreach ($nodes as $node) {
            $key = strtolower($node->getAttribute('property') ?: $node->getAttribute('name'));
            $value = trim($node->getAttribute('content'));

            if ($key !== '' && $value !== '' && ! isset($map[$key])) {
                $map[$key] = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }

        return $map;
    }

    private function jsonLd(\DOMXPath $xpath): array
    {
        $nodes = $xpath->query('//script[@type="application/ld+json"]');
        $found = [];

        if (! $nodes) {
            return $found;
        }

        foreach ($nodes as $node) {
            $decoded = json_decode(trim($node->textContent ?? ''), true);

            if (! is_array($decoded)) {
                continue;
            }

            $this->collectJsonLd($decoded, $found);

            if (isset($found['headline'], $found['articleBody'])) {
                break;
            }
        }

        return $found;
    }

    private function collectJsonLd(array $data, array &$found): void
    {
        if (isset($data['@graph']) && is_array($data['@graph'])) {
            foreach ($data['@graph'] as $item) {
                if (is_array($item)) {
                    $this->collectJsonLd($item, $found);
                }
            }
        }

        $type = $data['@type'] ?? '';
        $types = is_array($type) ? $type : [$type];
        $isArticle = count(array_intersect($types, ['NewsArticle', 'Article', 'BlogPosting', 'ReportageNewsArticle'])) > 0;

        if (! $isArticle && isset($data['headline'])) {
            $isArticle = true;
        }

        if (! $isArticle) {
            return;
        }

        foreach (['headline', 'description', 'articleBody', 'datePublished', 'image'] as $key) {
            if (! isset($found[$key]) && isset($data[$key]) && $data[$key] !== '') {
                $found[$key] = $data[$key];
            }
        }

        if (! isset($found['publisher'])) {
            $publisher = $data['publisher']['name'] ?? null;

            if (is_string($publisher) && $publisher !== '') {
                $found['publisher'] = $publisher;
            }
        }
    }

    private function publishedAt(?string $metaDate, mixed $jsonDate): ?string
    {
        $value = $this->firstText([$metaDate, is_string($jsonDate) ? $jsonDate : null]);

        if ($value === '') {
            return null;
        }

        try {
            return \Illuminate\Support\Carbon::parse($value)->toDateTimeString();
        } catch (\Throwable $exception) {
            return null;
        }
    }

    private function fetchPublic(string $url, string $accept): ?\Illuminate\Http\Client\Response
    {
        $this->assertPublicUrl($url);

        return Http::timeout(12)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept' => $accept,
            ])
            ->withOptions(['allow_redirects' => false])
            ->get($url);
    }

    private function assertPublicUrl(string $url): void
    {
        $parts = parse_url($url);
        $scheme = strtolower((string) ($parts['scheme'] ?? ''));
        $host = strtolower(trim((string) ($parts['host'] ?? ''), '[]'));

        if (! in_array($scheme, ['http', 'https'], true) || $host === '') {
            throw new InvalidArgumentException('Paste a full http or https news link.');
        }

        if (in_array($host, ['localhost', 'localhost.localdomain'], true) || str_ends_with($host, '.local') || str_ends_with($host, '.internal')) {
            throw new InvalidArgumentException('Paste a public news link.');
        }

        $ips = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : (gethostbynamel($host) ?: []);

        if ($ips === []) {
            throw new InvalidArgumentException('That link could not be reached.');
        }

        foreach ($ips as $ip) {
            if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                throw new InvalidArgumentException('Paste a public news link.');
            }
        }
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            throw new InvalidArgumentException('Paste a news link.');
        }

        $parts = parse_url($url);

        if (! is_array($parts) || empty($parts['host'])) {
            throw new InvalidArgumentException('Paste a full news link, including https://.');
        }

        $scheme = strtolower((string) ($parts['scheme'] ?? ''));
        $host = strtolower($parts['host']);
        $port = isset($parts['port']) ? ':'.$parts['port'] : '';
        $path = $parts['path'] ?? '/';
        $query = isset($parts['query']) ? '?'.$parts['query'] : '';

        return $scheme.'://'.$host.$port.$path.$query;
    }

    private function absoluteUrl(string $value, string $base): ?string
    {
        if ($value === '' || str_starts_with($value, 'data:') || str_starts_with(strtolower($value), 'javascript:')) {
            return null;
        }

        if (str_starts_with($value, '//')) {
            $value = 'https:'.$value;
        }

        if (preg_match('#^https?://#i', $value)) {
            return $this->safeNormalize($value);
        }

        $parts = parse_url($base);

        if (! is_array($parts) || empty($parts['host'])) {
            return null;
        }

        $origin = $parts['scheme'].'://'.$parts['host'].(isset($parts['port']) ? ':'.$parts['port'] : '');

        if (str_starts_with($value, '/')) {
            return $this->safeNormalize($origin.$value);
        }

        $directory = rtrim(dirname($parts['path'] ?? '/'), '/\\');

        return $this->safeNormalize($origin.($directory === '' || $directory === '.' ? '' : $directory).'/'.$value);
    }

    private function safeNormalize(string $url): ?string
    {
        try {
            return $this->normalizeUrl($url);
        } catch (InvalidArgumentException $exception) {
            return null;
        }
    }

    private function firstText(array $values): string
    {
        foreach ($values as $value) {
            $text = $this->cleanText(is_string($value) ? $value : '');

            if ($text !== '') {
                return $text;
            }
        }

        return '';
    }

    private function nodeText(?\DOMNode $node): string
    {
        return $this->cleanText($node?->textContent ?? '');
    }

    private function cleanText(string $value): string
    {
        $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

        return trim($value);
    }

    private function isBoilerplate(string $text): bool
    {
        return (bool) preg_match('/\b(cookie|subscribe|sign up|newsletter|advertisement|all rights reserved)\b/i', $text)
            && mb_strlen($text) < 180;
    }

    private function hostLabel(string $url): string
    {
        $host = (string) parse_url($url, PHP_URL_HOST);

        return preg_replace('/^www\./', '', $host) ?: $host;
    }
}
