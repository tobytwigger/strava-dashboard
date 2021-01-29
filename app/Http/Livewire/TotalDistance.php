<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use Livewire\Component;

class TotalDistance extends Component
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
        $team = request()->route('team_slug');
        $this->team = $team;
        
        $activities = $team->stravaActivities;

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

}
