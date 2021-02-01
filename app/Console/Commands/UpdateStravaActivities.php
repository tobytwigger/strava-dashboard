<?php

namespace App\Console\Commands;

use App\Models\ClubSyncronisation;
use App\Models\StravaActivity;
use App\Models\Team;
use App\Support\Strava\Log\ConnectionLog;
use App\Support\Strava\Strava;
use Illuminate\Console\Command;

class UpdateStravaActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'strava:sync-club {teamId}';

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
        try {
            $team = $this->getTeam();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        app()->bind('current-team.id', fn(): string => (string) $team->id);

        StravaActivity::where('team_id', $team->id)->delete();

        $sync = ClubSyncronisation::create([
            'record_count' => 0,
            'team_id' => $team->id
        ]);

        $activities = $this->strava->client($team->id)->getClubActivities((int) $team->club_id);

        foreach ($activities as $activity) {
            $dbActivity = StravaActivity::makeFromStravaActivity($activity);
            $dbActivity->save();
        }

        $sync->record_count = $team->stravaActivities()->count();
        $sync->save();

        app(ConnectionLog::class)->success('Syncronised Strava activities');

        $this->info('Syncronisation complete.');
        return 0;
    }

    private function getTeam(): Team
    {
        $teamId = (int) $this->argument('teamId');

        $team = Team::findOrFail($teamId);

        if($team->club_id === null) {
            throw new \Exception('This team has not been connected to a club.');
        }

        return $team;
    }
}
