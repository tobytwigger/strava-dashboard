<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class TotalElevation extends Component
{

    /** @var string */
    public $position;

    public Team $team;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        $activities = $this->team()->stravaActivities;

        $meters = array_reduce(
            $activities->toArray(),
            function(float $totalElevation, array $stravaActivity): float {
                $totalElevation += $stravaActivity['elevation_gain'];
                return $totalElevation;
            },
            0.0
        );
        return view('tiles.total-elevation', [
            'elevationInKilometers' => $meters / 1000,
            'elevationInMiles' => $meters / 1600,
            'elevationInMeters' => $meters,
        ]);
    }

    public function team()
    {
        if(!isset($this->team)) {
            $team = request()->route('team_slug');

            if($team !== null) {
                $this->team = $team;
            } else {
                throw new ModelNotFoundException('Could not find team');
            }
        }

        return $this->team;
    }

}
