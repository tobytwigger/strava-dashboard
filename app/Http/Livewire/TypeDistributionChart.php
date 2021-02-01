<?php

namespace App\Http\Livewire;

use App\Models\StravaActivity;
use App\Models\Team;
use App\Support\Team\CurrentTeamResolver;
use Chartisan\PHP\Chartisan;
use Fidum\ChartTile\Charts\Chart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TypeDistributionChart extends Chart
{

    public Team $team;


    public function handler(Request $request): Chartisan
    {
        $data = $this->getData();

        return Chartisan::build()
            ->labels(collect($data)->pluck('labels')->toArray())
            ->dataset('Type of workout vs moving time', collect($data)->pluck('data')->toArray());
    }

    public function type(): string
    {
        return 'pie';
    }

    public function options(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'legend' => [
                'display' => true,
                'position' => 'right',
            ],
            'scales' => [
                'xAxes' => ['display' => false],
                'yAxes' => ['display' => false],
            ]
        ];
    }


    public function team(): Team
    {
        return app(CurrentTeamResolver::class)->currentTeam();
    }

    public function colors(): array
    {
        $colours = [];
        foreach($this->getData() as $option) {
            $colours[] = [sprintf("#%06X\n", mt_rand(0, 0xFFFFFF))];
        }
        return [$colours];
    }

    private function getData()
    {
        $activities = $this->team()->stravaActivities;

        $types = array_reduce(
            $activities->toArray(),
            function (array $types, array $stravaActivity): array {
                $type = $stravaActivity['type'];
                if (!isset($types[$type])) {
                    $types[$type] = 0;
                }
                $types[$type] += $stravaActivity['moving_time'];
                return $types;
            },
            []
        );

        $data = [];

        $total = array_sum($types);

        foreach ($types as $type => $duration) {
            $data[] = [
                'labels' => $type,
                'data' => $duration / $total
            ];
        }
        return $data;
    }

}
