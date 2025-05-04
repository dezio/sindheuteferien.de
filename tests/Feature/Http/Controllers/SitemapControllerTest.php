<?php
/**
 * File: SitemapControllerTest.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class SitemapControllerTest extends TestCase
{
    public function testSitemap()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');

        // Check if the response contains the expected XML structure
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $response->getContent());
        $this->assertStringContainsString('<urlset', $response->getContent());

        // assert home
        $homeUrl = url('/');
        $this->assertStringContainsString("<loc>$homeUrl</loc>", $response->getContent());

        // assert bundesland
        $bundeslandUrl = url('/bayern');
        $this->assertStringContainsString("<loc>$bundeslandUrl</loc>", $response->getContent());
    }
}
