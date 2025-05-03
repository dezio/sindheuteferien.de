<?php

namespace App\Console\Commands;

use App\Models\SchoolHoliday;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ImportSchoolHolidaysCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-school-holidays {--year= : The year to import holidays for (default: current year)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import German school holidays from OpenHolidaysAPI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->option('year') ?? now()->year;
        $validFrom = Carbon::createFromDate($year, 1, 1)->format('Y-m-d');
        $validTo = Carbon::createFromDate($year, 12, 31)->format('Y-m-d');

        $this->info("Importing school holidays for year: $year");

        try {
            // Fetch data from API
            $url = "https://openholidaysapi.org/SchoolHolidays";
            $response = Http::withoutVerifying()->get($url, [
                'countryIsoCode' => 'DE',
                'languageIsoCode' => 'DE',
                'validFrom' => $validFrom,
                'validTo' => $validTo,
            ]);

            if ($response->failed()) {
                $this->error("API request failed: " . $response->status());
                return 1;
            }

            $holidays = $response->json();

            if (empty($holidays)) {
                $this->info("No school holidays found for the specified period.");
                return 0;
            }

            $this->processHolidays($holidays);

            $this->info("Import completed successfully!");
            return 0;

        } catch (\Exception $e) {
            $this->error("An error occurred: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Process and store holidays.
     *
     * @param array $holidays
     * @return void
     */
    protected function processHolidays(array $holidays): void
    {
        $bar = $this->output->createProgressBar(count($holidays));
        $this->line('Processing holidays...');
        $bar->start();

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($holidays as $holiday) {
            // Skip if not a school holiday
            if ($holiday['type'] !== 'School') {
                $skippedCount++;
                $bar->advance();
                continue;
            }

            // Check if holiday already exists
            $exists = SchoolHoliday::where('uuid', $holiday['id'])->exists();
            if ($exists) {
                $skippedCount++;
                $bar->advance();
                continue;
            }

            // Extract the holiday name
            $name = '';
            if (!empty($holiday['name'])) {
                foreach ($holiday['name'] as $nameObj) {
                    if ($nameObj['language'] === 'DE') {
                        $name = $nameObj['text'];
                        break;
                    }
                }
            }

            // Format subdivisions for storage
            $subdivisions = !empty($holiday['subdivisions']) ? $holiday['subdivisions'] : null;

            // Create new holiday record
            SchoolHoliday::create([
                'uuid' => $holiday['id'],
                'start_date' => $holiday['startDate'],
                'end_date' => $holiday['endDate'],
                'name' => $name,
                'regional_scope' => $holiday['regionalScope'],
                'temporal_scope' => $holiday['temporalScope'],
                'nationwide' => $holiday['nationwide'],
                'subdivisions' => $subdivisions,
            ]);

            $importedCount++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Imported $importedCount new school holidays. Skipped $skippedCount records.");
    }
}
