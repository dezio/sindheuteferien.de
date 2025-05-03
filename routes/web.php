<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/impressum', function () {
    return view('impressum');
})->name('impressum');


Route::get('/{route}', function ($route) {
    $routeToKuerzel = [
        'baden-wuerttemberg' => 'bw',
        'bayern' => 'by',
        'berlin' => 'be',
        'brandenburg' => 'bb',
        'bremen' => 'hb',
        'hamburg' => 'hh',
        'hessen' => 'he',
        'mecklenburg-vorpommern' => 'mv',
        'niedersachsen' => 'ni',
        'nordrhein-westfalen' => 'nw',
        'rheinland-pfalz' => 'rp',
        'saarland' => 'sl',
        'sachsen' => 'sn',
        'sachsen-anhalt' => 'st',
        'schleswig-holstein' => 'sh',
        'thueringen' => 'th'
    ];

    if (isset($routeToKuerzel[$route])) {
        return view('sind-heute-ferien-in', ['bundesland' => $routeToKuerzel[$route]]);
    }

    abort(404);
})->where('route', '[a-z\-]+')->name('bundesland');
