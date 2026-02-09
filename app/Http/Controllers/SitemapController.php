<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Home page
        $sitemap .= $this->addUrl(route('home'), '1.0', 'daily');
        
        // About page
        $sitemap .= $this->addUrl(route('about'), '0.8', 'monthly');
        
        // Contact page
        $sitemap .= $this->addUrl(route('contact.show'), '0.7', 'monthly');
        
        // Guest slots page
        $sitemap .= $this->addUrl(route('guest.slots'), '0.9', 'daily');
        
        // Login/Register pages
        $sitemap .= $this->addUrl(route('login'), '0.6', 'monthly');
        $sitemap .= $this->addUrl(route('register'), '0.6', 'monthly');
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    private function addUrl($loc, $priority = '0.5', $changefreq = 'monthly')
    {
        return '<url>' .
            '<loc>' . htmlspecialchars($loc) . '</loc>' .
            '<lastmod>' . now()->toW3cString() . '</lastmod>' .
            '<changefreq>' . $changefreq . '</changefreq>' .
            '<priority>' . $priority . '</priority>' .
            '</url>';
    }
}
