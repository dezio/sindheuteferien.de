<?php
/**
 * File: DatenschutzController.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace App\Http\Controllers;

use App\Facades\Page;

class DatenschutzController
{
    public function __invoke()
    {
        Page::setTitle("Datenschutz")->setDescription(sprintf(
            "Informationen zum Datenschutz und Datenschutzerklärung von %s",
            config('app.name')
        ));
        return view('datenschutz');
    }
}
