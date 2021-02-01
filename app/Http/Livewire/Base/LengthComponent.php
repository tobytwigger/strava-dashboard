<?php

namespace App\Http\Livewire\Base;

use App\Models\StravaActivity;
use App\Models\Team;
use App\Support\Team\CurrentTeamResolver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

abstract class LengthComponent extends Component
{

    public $position;

    public $unit = 'km';

    public $distance = 0;

    public string $view;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function setUnit(string $unit)
    {
        $this->unit = $unit;
        $this->setDistanceToUnit();
    }

    public function render()
    {
        $this->setDistanceToUnit();

        return view($this->view, [
            'distance' => $this->distance,
            'unit' => $this->unit
        ]);
    }

    abstract protected function extractLength(float $totalMeters, array $stravaActivity): float;

    private function setDistanceToUnit()
    {
        $activities = StravaActivity::all();

        $meters = array_reduce(
            $activities->toArray(),
            [$this, 'extractLength'],
            0.0
        );

        if($this->unit === 'km') {
            $this->distance = $meters / 1000;
        } elseif($this->unit === 'mi') {
            $this->distance = $meters / 1600;
        } else {
            $this->distance = $meters;
            $this->unit = 'm';
        }

    }
}
