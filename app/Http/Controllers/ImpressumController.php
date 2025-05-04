<?php
/**
 * File: ImpressumController.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace App\Http\Controllers;

use App\Facades\Page;

class ImpressumController
{
    public function __invoke()
    {
        Page::setTitle("Impressum");
        Page::setDescription(sprintf(
            "Impressum und Anbieterkennung von %s",
            config('app.name')
        ));
        return view('impressum');
    }
}
