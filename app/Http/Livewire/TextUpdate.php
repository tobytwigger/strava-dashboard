<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class TextUpdate extends Component
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
            function(float $totalMetres, array $stravaActivity): float {
                $totalMetres += $stravaActivity['distance'];
                return $totalMetres;
            },
            0.0
        );
        return view('tiles.total-distance', [
            'distanceInKilometers' => $meters / 1000,
            'distanceInMiles' => $meters / 1600,
            'distanceInMeters' => $meters,
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
