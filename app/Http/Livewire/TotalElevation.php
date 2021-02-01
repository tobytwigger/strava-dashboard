<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Base\LengthComponent;

class TotalElevation extends LengthComponent
{

    public string $view = 'tiles.total-elevation';

    protected function extractLength(float $totalMeters, array $stravaActivity): float
    {
        $totalMeters += $stravaActivity['elevation_gain'];
        return $totalMeters;
    }
}


