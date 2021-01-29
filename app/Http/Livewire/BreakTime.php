<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class BreakTime extends Component
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
                $totalSeconds += ($stravaActivity['elapsed_time'] - $stravaActivity['moving_time']);
                return $totalSeconds;
            },
            0
        );
        return view('tiles.break-time', [
            'breakTimeInSeconds' => $seconds,
            'breakTimeInMinutes' => $seconds / 60,
            'breakTimeInHours' => $seconds / 3600,
            'breakTimeInDays' => $seconds / 86400,
            'breakTimeReadable' => CarbonInterval::seconds($seconds)->forHumans(),
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
