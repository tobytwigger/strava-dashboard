<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use Chartisan\PHP\Chartisan;
use Fidum\ChartTile\Charts\Chart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TypeDistributionAgainstTimeChart extends Chart
{

    public Team $team;


    public function handler(Request $request): Chartisan
    {
        $activities = $this->team()->stravaActivities;

        $types = array_reduce(
            $activities->toArray(),
            function(float $types, array $stravaActivity): float {
                $type = $stravaActivity['type'];
                if(!isset($types[$type])) {
                    $types[$type] = 0;
                }
                $types[$type] += $stravaActivity['moving_time'];
                return $types;
            },
            []
        );

        $data = [];
        foreach($types as $type => $duration) {
            $data[] = [
                'x' => $type,
                'y' => $duration
            ];
        }

        return Chartisan::build()
            ->labels(collect($data)->pluck('x')->toArray())
            ->dataset('Type of workout vs moving time', $data->toArray());
    }

    public function type(): string
    {
        return 'bar';
    }

    public function options(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            // etc ...
        ];
    }


    public function team()
    {
        if(!isset($this->team)) {
            $team = request()->route('team_slug');

            if($team !== null) {
                $this->team = $team;
                Session::put('homepage.team', $team);
            } else if(Session::has('homepage.team')) {
                return Session::get('homepage.team');
            } else {
                throw new ModelNotFoundException('Could not find team');
            }
        }

        return $this->team;
    }

}
