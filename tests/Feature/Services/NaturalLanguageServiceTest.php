<?php
/**
 * File: NaturalLanguageServiceTest.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace Tests\Feature\Services;

use App\Services\NaturalLanguageService;
use Tests\TestCase;

class NaturalLanguageServiceTest extends TestCase
{
    protected NaturalLanguageService $naturalLanguageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->naturalLanguageService = new NaturalLanguageService();
    }

    public function testSommerferienGetEndingInString(): void
    {
        $endData = [
            'holiday_name' => 'Sommerferien',
            'days' => 0,
        ];

        $result = $this->naturalLanguageService->getEndingInString($endData);
        $this->assertEquals("<span class='highlight'>Die Sommerferien</span> enden heute", $result);
    }

    public function testSommerferienGetButNextAreStartingInString(): void
    {
        $startData = [
            'holiday_name' => 'Sommerferien',
            'days' => 1,
        ];

        $result = $this->naturalLanguageService->getButNextAreStartingInString($startData);
        $this->assertEquals("… aber <span class='highlight'>Die Sommerferien</span> beginnen morgen", $result);
    }

    // more than 1
    public function testSommerferienGetEndingInStringMoreThanOneDay(): void
    {
        $endData = [
            'holiday_name' => 'Sommerferien',
            'days' => 5,
        ];

        $result = $this->naturalLanguageService->getEndingInString($endData);
        $this->assertEquals("<span class='highlight'>Die Sommerferien</span> enden in 5 Tagen", $result);
    }

    // something without "ferien" or "tage"
    public function testSomethingWithoutFerienOrTageGetEndingInString(): void
    {
        $endData = [
            'holiday_name' => 'Tag der Deutschen Einheit',
            'days' => 0,
        ];

        $result = $this->naturalLanguageService->getEndingInString($endData);
        $this->assertEquals("<span class='highlight'>Tag der Deutschen Einheit</span> endet heute", $result);
    }

    // starts today
    public function testSomethingWithoutFerienOrTageGetButNextAreStartingInString(): void
    {
        $startData = [
            'holiday_name' => 'Tag der Deutschen Einheit',
            'days' => 0,
        ];

        $result = $this->naturalLanguageService->getButNextAreStartingInString($startData);
        $this->assertEquals("… aber <span class='highlight'>Tag der Deutschen Einheit</span> beginnt heute", $result);
    }

    // beginnt morgen
    public function testSomethingWithoutFerienOrTageGetButNextAreStartingInStringTomorrow(): void
    {
        $startData = [
            'holiday_name' => 'Tag der Deutschen Einheit',
            'days' => 1,
        ];

        $result = $this->naturalLanguageService->getButNextAreStartingInString($startData);
        $this->assertEquals("… aber <span class='highlight'>Tag der Deutschen Einheit</span> beginnt morgen", $result);
    }

    // in 5 tagen
    public function testSomethingWithoutFerienOrTageGetButNextAreStartingInStringIn5Days(): void
    {
        $startData = [
            'holiday_name' => 'Tag der Deutschen Einheit',
            'days' => 5,
        ];

        $result = $this->naturalLanguageService->getButNextAreStartingInString($startData);
        $this->assertEquals("… aber <span class='highlight'>Tag der Deutschen Einheit</span> beginnt in 5 Tagen", $result);
    }
}
