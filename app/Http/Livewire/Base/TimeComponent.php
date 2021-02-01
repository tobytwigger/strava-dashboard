<?php

namespace App\Http\Livewire\Base;

use App\Models\StravaActivity;
use Carbon\CarbonInterval;
use Livewire\Component;

abstract class TimeComponent extends Component
{

    public $position;

    public $unit = 'hrs';

    public $time = 0;

    public string $view;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function setUnit(string $unit)
    {
        $this->unit = $unit;
        $this->setTimeToUnit();
    }

    public function render()
    {
        $this->setTimeToUnit();

        return view($this->view, [
            'time' => $this->time,
            'unit' => $this->unit
        ]);
    }

    abstract protected function extractTime(float $totalSeconds, array $stravaActivity): float;

    private function setTimeToUnit()
    {
        $activities = StravaActivity::all();

        $seconds = array_reduce(
            $activities->toArray(),
            [$this, 'extractTime'],
            0.0
        );

        if($this->unit === 'hrs') {
            $this->time = $seconds / 3600;
        } elseif($this->unit === 'days') {
            $this->time = $seconds / 86400;
        } else {
            $this->time = $seconds;
            $this->unit = 'secs';
        }
    }
}
