<?php
/**
 * File: NaturalLanguageService.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace App\Services;

class NaturalLanguageService
{

    public function getEndingInString(
        array $endData
    )
    {
        $holidayDisplay = $this->buildPrefixedName($endData['holiday_name']);
        $prefixedName = $holidayDisplay['name'];
        $days = $endData['days'];
        $endString = $holidayDisplay['plural'] ? "enden" : "endet";

        if ($days === 0) {
            return sprintf("<span class='highlight'>%s</span> %s heute", $prefixedName, $endString);
        }

        if ($days === 1) {
            return sprintf("<span class='highlight'>%s</span> %s morgen", $prefixedName, $endString);
        }

        return sprintf("<span class='highlight'>%s</span> %s in %d Tagen", $prefixedName, $endString, $days);
    }

    public function getButNextAreStartingInString(
        array $startData
    )
    {
        $holidayDisplay = $this->buildPrefixedName($startData['holiday_name']);
        $prefixedName = $holidayDisplay['name'];
        $days = $startData['days'];
        $endString = $holidayDisplay['plural'] ? "beginnen" : "beginnt";

        if ($days === 0) {
            return sprintf("… aber <span class='highlight'>%s</span> %s heute", $prefixedName,$endString);
        }

        if ($days === 1) {
            return sprintf("… aber <span class='highlight'>%s</span> %s morgen", $prefixedName,$endString);
        }

        return sprintf("… aber <span class='highlight'>%s</span> %s in %d Tagen", $prefixedName,$endString, $days);
    }

    /**
     * @param $holidayName
     * @param bool $lowercase
     * @return mixed|string
     */
    private function buildPrefixedName($holidayName, bool $lowercase = false): mixed
    {
        $plural = false;
        $prefixedName = $holidayName;
        $areHolidays = str_contains($holidayName, 'ferien') || str_contains($holidayName, 'tage');
        if ($areHolidays) {
            $prefixedName = ($lowercase ? "die " : "Die ") . $holidayName;
            $plural = true;
        }
        return [
            'name' => $prefixedName,
            'plural' => $plural,
        ];
    }

    public function multiChoice($number, array $choices) {
        $count = count($choices);
        if ($count === 0) {
            return null;
        }

        if ($count === 1) {
            return sprintf($choices[0], $number);
        }

        if($number === 0) {
            return sprintf($choices[0], $number);
        }

        if ($number === 1) {
            return sprintf($choices[1], $number);
        }

        return sprintf($choices[2], $number);
    }
}
