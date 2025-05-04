<?php

namespace App\Http\Controllers;

use App\Services\HolidayService;
use App\Services\PageService;
use Arr;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __invoke(Request $request, PageService $page, HolidayService $holidayService)
    {

        $routeId = $request->route('route');
        $routeToKuerzel = [
            'baden-wuerttemberg'     => 'bw',
            'bayern'                 => 'by',
            'berlin'                 => 'be',
            'brandenburg'            => 'bb',
            'bremen'                 => 'hb',
            'hamburg'                => 'hh',
            'hessen'                 => 'he',
            'mecklenburg-vorpommern' => 'mv',
            'niedersachsen'          => 'ni',
            'nordrhein-westfalen'    => 'nw',
            'rheinland-pfalz'        => 'rp',
            'saarland'               => 'sl',
            'sachsen'                => 'sn',
            'sachsen-anhalt'         => 'st',
            'schleswig-holstein'     => 'sh',
            'thueringen'             => 'th'
        ];

        if (isset($routeToKuerzel[$routeId])) {
            $selectedState = Arr::get($holidayService->geBundeslandMap(), $routeToKuerzel[$routeId]);
            if ($selectedState) {
                $page->setTitle(sprintf("Sind heute Ferien in %s?", $selectedState['name']))
                    ->setDescription(sprintf(
                        "Finde heraus, ob heute Ferien im Bundesland %s sind.",
                        $selectedState['name']
                    ));
            } // if end

            return view('sind-heute-ferien-in', ['bundesland' => $routeToKuerzel[$routeId]]);
        }

        abort(404);
    }
}
