<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class RichText
{
    /**
     * Keep formatting from the editor and drop scripts and unsafe links.
     */
    public static function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        $allowed = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'h1', 'h2', 'h3', 'h4', 'ul', 'ol', 'li', 'a', 'blockquote', 'span', 'mark', 'hr', 'img', 'figure', 'figcaption', 'div'];
        $removed = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button'];

        $document = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8"><div id="rich-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $document->getElementById('rich-root');
        if (! $root) {
            return '';
        }

        self::sanitize($root, $allowed, $removed);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $document->saveHTML($child);
        }

        return trim($output);
    }

    /**
     * @param  list<string>  $allowed
     * @param  list<string>  $removed
     */
    private static function sanitize(DOMNode $node, array $allowed, array $removed): void
    {
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if (! $child instanceof DOMElement) {
                continue;
            }

            $tag = strtolower($child->tagName);
            if (in_array($tag, $removed, true)) {
                $node->removeChild($child);
                continue;
            }

            self::sanitize($child, $allowed, $removed);

            if (! in_array($tag, $allowed, true)) {
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);
                continue;
            }

            self::filterAttributes($child);
        }
    }

    private static function filterAttributes(DOMElement $element): void
    {
        $tag = strtolower($element->tagName);
        $keep = match ($tag) {
            'a' => ['href', 'title', 'target'],
            'img' => ['src', 'alt', 'title', 'width', 'height'],
            'span', 'mark' => ['style'],
            'div' => ['class'],
            default => [],
        };
        $remove = [];

        foreach ($element->attributes as $attribute) {
            if (! in_array(strtolower($attribute->name), $keep, true)) {
                $remove[] = $attribute->name;
            }
        }

        foreach ($remove as $name) {
            $element->removeAttribute($name);
        }

        if ($element->hasAttribute('style')) {
            $style = self::safeStyle($element->getAttribute('style'));
            if ($style === '') {
                $element->removeAttribute('style');
            } else {
                $element->setAttribute('style', $style);
            }
        }

        if ($tag === 'img') {
            $src = self::normalizeMediaSrc(trim($element->getAttribute('src')));

            if ($src === null) {
                $element->parentNode?->removeChild($element);

                return;
            }

            $element->setAttribute('src', $src);

            return;
        }

        if ($tag !== 'a' || ! $element->hasAttribute('href')) {
            return;
        }

        $href = trim($element->getAttribute('href'));
        $safe = (str_starts_with($href, '/') && ! str_starts_with($href, '//'))
            || str_starts_with($href, '#')
            || str_starts_with(strtolower($href), 'mailto:')
            || (bool) preg_match('#^https?://#i', $href);

        if (! $safe) {
            $element->removeAttribute('href');

            return;
        }

        if (strtolower($element->getAttribute('target')) === '_blank') {
            $element->setAttribute('rel', 'noopener noreferrer');
        } else {
            $element->removeAttribute('target');
        }
    }

    private static function safeStyle(string $style): string
    {
        $kept = [];

        foreach (explode(';', $style) as $declaration) {
            if (! str_contains($declaration, ':')) {
                continue;
            }

            [$property, $value] = array_map('trim', explode(':', $declaration, 2));
            $property = strtolower($property);

            if (! in_array($property, ['color', 'background-color', 'font-size'], true)) {
                continue;
            }

            if (preg_match('/url\s*\(|expression|javascript/i', $value)) {
                continue;
            }

            $color = '/^(#[0-9a-f]{3,8}|rgba?\([^)]+\)|hsla?\([^)]+\))$/i';
            $size = '/^\d+(\.\d+)?(px|em|rem|%)$/';

            if (in_array($property, ['color', 'background-color'], true) && ! preg_match($color, $value)) {
                continue;
            }

            if ($property === 'font-size' && ! preg_match($size, $value)) {
                continue;
            }

            $kept[] = $property.':'.$value;
        }

        return implode(';', $kept);
    }

    /**
     * Keep site/media image URLs and rewrite TinyMCE relative paths back to /storage/...
     */
    private static function normalizeMediaSrc(string $src): ?string
    {
        if ($src === '' || str_starts_with(strtolower($src), 'blob:') || str_starts_with(strtolower($src), 'data:')) {
            return null;
        }

        if ((bool) preg_match('#^https?://#i', $src)) {
            $path = parse_url($src, PHP_URL_PATH);

            if (is_string($path) && str_starts_with($path, '/storage/')) {
                return $path;
            }

            return $src;
        }

        if (str_starts_with($src, '/') && ! str_starts_with($src, '//')) {
            return $src;
        }

        // TinyMCE often turns /storage/... into ../storage/... from /admin pages.
        if (preg_match('#(?:^|/)storage/(.+)$#', str_replace('\\', '/', $src), $matches)) {
            return '/storage/'.$matches[1];
        }

        return null;
    }
}
