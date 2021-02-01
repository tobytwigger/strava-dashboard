<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Base\TimeComponent;

class MovingTime extends TimeComponent
{

    public string $view = 'tiles.moving-time';

    protected function extractTime(float $totalSeconds, array $stravaActivity): float
    {
        $totalSeconds += $stravaActivity['moving_time'];
        return $totalSeconds;
    }

}
