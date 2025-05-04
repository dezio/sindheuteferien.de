<?php
/**
 * File: ExportHolidaysCommand.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace App\Console\Commands;

use App\Models\SchoolHoliday;
use File;
use Illuminate\Console\Command;
use JsonException;

class ExportHolidaysCommand extends Command
{
    protected $signature = 'export:holidays';

    protected $description = 'Command description';

    /**
     * @throws JsonException
     */
    public function handle(): void
    {
        $this->info('Exporting holidays...');

        $all = SchoolHoliday::all();
        // Write to tests/data/holidays.json

        $path = base_path('tests/data/holidays.json');
        $this->info("Writing to $path");
        $json = json_encode($all, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        File::put($path, $json);
    }
}
