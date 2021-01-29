<?php

namespace App\Support\Strava;

use App\Support\Strava\Authentication\StravaToken;
use App\Support\Strava\Client\StravaClient;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class Strava
{

    public function __construct(protected Client $client, protected ClientFactory $clientFactory)
    {
    }

    public function redirectUrl(
        int $clientId,
        string $redirectUrl,
        string $state
    ): string
    {

        $params = [
            'client_id' => $clientId,
            'redirect_uri' => $redirectUrl,
            'response_type' => 'code',
            'approval_prompt' => 'auto',
            'scope' => 'activity:read,read',
            'state  ' => $state
        ];

        return sprintf('https://www.strava.com/oauth/authorize?%s', http_build_query($params));
    }

    public function exchangeCode(
        string $clientId,
        string $clientSecret,
        string $code
    ): StravaToken
    {
        $response = $this->client->request('post', 'https://www.strava.com/oauth/token', [
            'query' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code'
            ]
        ]);

        $credentials = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return StravaToken::create(
            new Carbon((int) $credentials['expires_at']),
            (int)$credentials['expires_in'],
            (string)$credentials['refresh_token'],
            (string)$credentials['access_token'],
        );

    }

    public function refreshToken(
        string $clientId,
        string $clientSecret,
        string $refreshToken
    ): StravaToken
    {
        $response = $this->client->request('post', 'https://www.strava.com/oauth/token', [
            'query' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'refresh_token' => $refreshToken,
                'grant_type' => 'refresh_token'
            ]
        ]);

        $credentials = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return StravaToken::create(
            new Carbon((int) $credentials['expires_at']),
            (int)$credentials['expires_in'],
            (string)$credentials['refresh_token'],
            (string)$credentials['access_token'],
        );
    }

    public function client(int $teamId = null): StravaClient
    {
        if($teamId === null) {
            if(!Auth::check()) {
                throw new AuthenticationException();
            }
            $teamId = Auth::user()->currentTeam->id;
        }
        return $this->clientFactory->create($teamId);
    }

}
