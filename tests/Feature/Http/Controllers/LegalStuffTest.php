<?php
/**
 * File: LegalStuffTest.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace Http\Controllers;

class LegalStuffTest extends \Tests\TestCase
{
    public function testImpressum()
    {
        $response = $this->get("/impressum");
        $response->assertStatus(200);
        $response->assertSee("Impressum");
        $response->assertSee(config("app.name"));

        // has description
        $response->assertSee("<meta name=\"description\"", false);
    }

    public function testDatenschutz()
    {
        $response = $this->get("/datenschutz");
        $response->assertStatus(200);
        $response->assertSee("Datenschutz");
        $response->assertSee(config("app.name"));

        // has description
        $response->assertSee("<meta name=\"description\"", false);
    }
}
