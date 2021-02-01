<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Base\TimeComponent;
use App\Models\StravaActivity;
use Carbon\CarbonInterval;

class BreakTime extends TimeComponent
{

    public string $view = 'tiles.break-time';

    protected function extractTime(float $totalSeconds, array $stravaActivity): float
    {
        $totalSeconds += ($stravaActivity['elapsed_time'] - $stravaActivity['moving_time']);
        return $totalSeconds;
    }
}
