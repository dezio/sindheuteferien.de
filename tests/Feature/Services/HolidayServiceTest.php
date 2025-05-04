<?php
/**
 * File: HolidayServiceTest.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace Tests\Feature\Services;

use App\Services\HolidayService;
use Tests\TestCase;

class HolidayServiceTest extends TestCase
{
    protected HolidayService $holidayService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->holidayService = new HolidayService();
    }

    public function testGeBundeslandMap()
    {
        $bundeslandMap = $this->holidayService->geBundeslandMap();

        $this->assertIsArray($bundeslandMap);
        $this->assertArrayHasKey('bw', $bundeslandMap);
        $this->assertArrayHasKey('by', $bundeslandMap);
        $this->assertArrayHasKey('be', $bundeslandMap);
        $this->assertArrayHasKey('bb', $bundeslandMap);
        $this->assertArrayHasKey('hb', $bundeslandMap);
        $this->assertArrayHasKey('hh', $bundeslandMap);
        $this->assertArrayHasKey('he', $bundeslandMap);
        $this->assertArrayHasKey('mv', $bundeslandMap);

        // assert route in bundeslandMap
        $example = $bundeslandMap['bw'];
        $this->assertArrayHasKey('route', $example);
        $this->assertEquals('baden-wuerttemberg', $example['route']);

        // assert name in bundeslandMap
        $this->assertArrayHasKey('name', $example);
        $this->assertEquals('Baden-Württemberg', $example['name']);
    }
}
