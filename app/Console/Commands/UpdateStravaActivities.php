<?php

namespace App\Console\Commands;

use App\Models\StravaActivity;
use App\Support\Strava\Strava;
use Illuminate\Console\Command;

class UpdateStravaActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'strava:sync-club {teamId} {clubId=844239}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronise a clubs activities';

    /**
     * Create a new command instance.
     *
     * @param Strava $strava
     */
    public function __construct(protected Strava $strava)
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
        $clubId = (int) $this->argument('clubId');
        $teamId = (int) $this->argument('teamId');
        $activities = $this->strava->client($teamId)->getNewClubActivities($clubId);

        foreach ($activities as $activity) {
            $dbActivity = StravaActivity::makeFromStravaActivity($activity);
            $dbActivity->save();
        }

        $this->info('Syncronisation complete.');
        return 0;
    }
}
