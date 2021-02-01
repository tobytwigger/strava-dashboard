<?php

namespace App\Console\Commands;

use App\Models\StravaActivity;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheActivityCutOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:activity-cutoff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache the activity cut off date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(Team::all() as $team) {
            $activities = StravaActivity::where('team_id', $team->id)
                ->orderBy('id', 'asc')
                ->withoutGlobalScopes()
                ->get();

            $cumulativeDistance = 0.0;
            $startDistance = $team->start_at;

            $id = $activities->skipUntil(function ($activity) use ($startDistance, &$cumulativeDistance) {
                $cumulativeDistance += $activity->distance;
                return $cumulativeDistance >= $startDistance;
            })->first()->id;

            Cache::put(StravaActivity::class . '.smallestId', $id);
        }
        return 0;

    }
}
