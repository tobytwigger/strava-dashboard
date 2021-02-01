<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Base\TimeComponent;

class ElapsedTime extends TimeComponent
{

    public string $view = 'tiles.elapsed-time';

    protected function extractTime(float $totalSeconds, array $stravaActivity): float
    {
        $totalSeconds += $stravaActivity['elapsed_time'];
        return $totalSeconds;
    }

}
