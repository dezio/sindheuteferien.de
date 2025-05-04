<?php
/**
 * File: HomeControllerTest.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace Tests\Feature\Http\Controllers;

use App\Services\HolidayService;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHome()
    {
        $response = $this->get("/");
        $response->assertStatus(200);

        $response->assertSee("Sind heute Ferien?");

        $bundeslandMap = app(HolidayService::class)->geBundeslandMap();
        foreach ($bundeslandMap as $bundesland) {
            $response->assertSee($bundesland['name']);
            $response->assertSee($bundesland['kuerzel']);
            $response->assertSee($bundesland['route']);
        }
    }

    // has impressum, datenschutz and github link
    public function testImportantLinks()
    {
        $response = $this->get("/");
        $response->assertStatus(200);

        $response->assertSee("Impressum");
        $response->assertSee("Datenschutz");
        $response->assertSee("GitHub");
    }
}
