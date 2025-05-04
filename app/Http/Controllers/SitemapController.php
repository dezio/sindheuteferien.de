<?php
/**
 * File: SitemapController.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace App\Http\Controllers;

use App\Services\SitemapService;

class SitemapController
{
    public function __invoke(
        SitemapService $sitemapService
    )
    {
        return response()->view('sitemap.index', [
            'statesSitemap' => $sitemapService->getSitemap(),
        ], 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'max-age=3600, public',
        ]);
    }
}
