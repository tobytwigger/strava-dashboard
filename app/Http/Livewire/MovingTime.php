<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class MovingTime extends Component
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

        $seconds = array_reduce(
            $activities->toArray(),
            function(float $totalSeconds, array $stravaActivity): float {
                $totalSeconds += $stravaActivity['moving_time'];
                return $totalSeconds;
            },
            0
        );
        return view('tiles.moving-time', [
            'movingTimeInSeconds' => $seconds,
            'movingTimeInMinutes' => $seconds / 60,
            'movingTimeInHours' => $seconds / 3600,
            'movingTimeInDays' => $seconds / 86400,
            'movingTimeReadable' => CarbonInterval::seconds($seconds)->forHumans(),
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
