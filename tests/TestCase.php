<?php

namespace Tests;

use App\Models\SchoolHoliday;
use Arr;
use File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public const IMPORT_FILE = "tests/data/holidays.json";
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $dataFileExists = File::exists(base_path(self::IMPORT_FILE));
        if($dataFileExists) {
            $this->importHolidays();
        } else {
            $this->artisan('app:import-school-holidays', ['--year' => date("Y")]);
        }
    }

    private function importHolidays()
    {
        $data = File::json(base_path(self::IMPORT_FILE), true);
        $this->assertNotEmpty($data, "No data found in " . self::IMPORT_FILE);

        SchoolHoliday::unguard();
        foreach($data as $holiday) {
            $data = Arr::except($holiday, ['id']);
            SchoolHoliday::create($data);
        }
        SchoolHoliday::reguard();
    }
}
