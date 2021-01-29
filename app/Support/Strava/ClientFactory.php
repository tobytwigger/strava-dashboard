<?php

namespace App\Support\Strava;

use App\Models\StravaToken;
use App\Models\Team;
use App\Support\Strava\Client\StravaClient;

class ClientFactory
{

    public function __construct()
    {
    }

    public function create(int $teamId): StravaClient
    {
        return new StravaClient(
            $this->getAuthToken($teamId),
            $teamId
        );
    }

    private function getAuthToken(int $teamId): string
    {
        $token = Team::findOrFail($teamId)->stravaTokens()->firstOrFail();
        if($token->expired()) {
            $token = $this->refreshToken($token);
        }
        return $token->access_token;
    }

    private function refreshToken(StravaToken $stravaToken): StravaToken
    {
        $newToken = $this->strava()->refreshToken(
            config('strava.client_id'),
            config('strava.client_secret'),
            $stravaToken->refresh_token
        );

        $stravaToken->updateFromStravaToken($newToken);
        $stravaToken->save();

        return $stravaToken;
    }

    private function strava(): Strava
    {
        return app(Strava::class);
    }

}
