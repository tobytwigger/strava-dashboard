<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use App\Support\Team\CurrentTeamResolver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class TextUpdate extends Component
{

    /** @var string */
    public $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        $activities = StravaActivity::all();

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
