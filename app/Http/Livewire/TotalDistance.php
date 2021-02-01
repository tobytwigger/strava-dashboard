<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Base\LengthComponent;

class TotalDistance extends LengthComponent
{

    public string $view = 'tiles.total-distance';

    protected function extractLength(float $totalMeters, array $stravaActivity): float
    {
        $totalMeters += $stravaActivity['distance'];
        return $totalMeters;
    }
}
