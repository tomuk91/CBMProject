<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Supported locales for hreflang alternates.
     */
    private array $locales = ['en', 'hu'];

    public function index()
    {
        $sitemap = Cache::remember('sitemap', 3600, function () {
            return $this->buildSitemap();
        });

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function buildSitemap(): string
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $sitemap .= ' xmlns:xhtml="http://www.w3.org/1999/xhtml">';

        // Home page
        $sitemap .= $this->addUrl(route('home'), '1.0', 'daily', now()->startOfDay());

        // About page
        $sitemap .= $this->addUrl(route('about'), '0.8', 'monthly', now()->subDays(30)->startOfDay());

        // Contact page
        $sitemap .= $this->addUrl(route('contact.show'), '0.7', 'monthly', now()->subDays(30)->startOfDay());

        // Guest slots page
        $sitemap .= $this->addUrl(route('guest.slots'), '0.9', 'daily', now()->startOfDay());

        // Privacy Policy
        $sitemap .= $this->addUrl(route('privacy'), '0.3', 'yearly', now()->subDays(90)->startOfDay());

        // Terms of Service
        $sitemap .= $this->addUrl(route('terms'), '0.3', 'yearly', now()->subDays(90)->startOfDay());

        // Login / Register pages
        $sitemap .= $this->addUrl(route('login'), '0.6', 'monthly', now()->subDays(30)->startOfDay());
        $sitemap .= $this->addUrl(route('register'), '0.6', 'monthly', now()->subDays(30)->startOfDay());

        $sitemap .= '</urlset>';

        return $sitemap;
    }

    private function addUrl(string $loc, string $priority = '0.5', string $changefreq = 'monthly', $lastmod = null): string
    {
        $lastmod = $lastmod ? $lastmod->toW3cString() : now()->toW3cString();

        $xml = '<url>';
        $xml .= '<loc>' . htmlspecialchars($loc) . '</loc>';
        $xml .= '<lastmod>' . $lastmod . '</lastmod>';
        $xml .= '<changefreq>' . $changefreq . '</changefreq>';
        $xml .= '<priority>' . $priority . '</priority>';

        // Add hreflang alternates for each supported locale
        foreach ($this->locales as $locale) {
            $localizedUrl = $this->localizeUrl($loc, $locale);
            $xml .= '<xhtml:link rel="alternate" hreflang="' . $locale . '" href="' . htmlspecialchars($localizedUrl) . '" />';
        }
        $xml .= '<xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($loc) . '" />';

        $xml .= '</url>';

        return $xml;
    }

    /**
     * Build a locale-prefixed URL for hreflang tags.
     */
    private function localizeUrl(string $url, string $locale): string
    {
        // Append locale as a query parameter (compatible with the app's locale switching)
        $separator = str_contains($url, '?') ? '&' : '?';
        return $url . $separator . 'lang=' . $locale;
    }
}
