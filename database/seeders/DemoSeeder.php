<?php

namespace Database\Seeders;

use App\Models\ClubSyncronisation;
use App\Models\StravaActivity;
use App\Models\StravaConnectionLog;
use App\Models\StravaToken;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $team = $this->generateTeam();


        StravaToken::factory()->create(['team_id' => $team->id]);

        StravaConnectionLog::factory()->create(['type' => StravaConnectionLog::ERROR, 'log' => 'Not connected to Strava', 'team_id' => $team->id]);
        StravaConnectionLog::factory()->create(['type' => StravaConnectionLog::SUCCESS, 'log' => 'Connection to Strava successful', 'team_id' => $team->id]);
        StravaConnectionLog::factory()->count(7)->create(['type' => StravaConnectionLog::DEBUG, 'team_id' => $team->id]);
        StravaConnectionLog::factory()->create(['type' => StravaConnectionLog::INFO, 'log' => 'Syncronisation starting', 'team_id' => $team->id]);
        StravaConnectionLog::factory()->create(['type' => StravaConnectionLog::SUCCESS, 'log' => 'Syncronisation complete', 'team_id' => $team->id]);

        ClubSyncronisation::factory()->count(5)->create(['team_id' => $team->id]);

        StravaActivity::factory()->count(2000)->create(['team_id' => $team->id]);
    }

    private function generateTeam()
    {
        $teamSlugPostfix = null;
        $slugUsed = true;

        while($slugUsed) {
            $slugUsed = Team::where(['slug' => sprintf('demo%s', (string) $teamSlugPostfix ?? '')])->count() > 0;
            if($slugUsed) {
                if($teamSlugPostfix === null) {
                    $teamSlugPostfix = 1;
                } else {
                    $teamSlugPostfix = $teamSlugPostfix + 1;
                }
            }
        }

        return Team::factory()->create([
            'slug' => sprintf('demo%s', (string) $teamSlugPostfix ?? ''),
            'user_id' => $this->generateUser()->id
        ]);
    }

    private function generateUser()
    {
        $userSlugPostfix = null;
        $slugUsed = true;

        while($slugUsed) {
            $slugUsed = User::where(['email' => sprintf('example%s@strava.test', (string) $userSlugPostfix ?? '')])->count() > 0;
            if($slugUsed) {
                if($userSlugPostfix === null) {
                    $userSlugPostfix = 1;
                } else {
                    $userSlugPostfix = $userSlugPostfix + 1;
                }
            }
        }

        return User::factory()->create([
            'email' => sprintf('example%s@strava.test', (string) $userSlugPostfix ?? ''),
            'password' => Hash::make('secret')
        ]);
    }


}
