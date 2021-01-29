<?php

namespace App\Support\Strava\Client;

use App\Support\Strava\Client\Models\StravaActivity;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class StravaClient
{

    protected ?Client $client = null;

    public function __construct(private string $authToken, private int $teamId)
    {
    }

    protected function client(): Client
    {
        if($this->client === null) {
            $this->client = new Client([
                'base_uri' => 'https://www.strava.com/api/v3/',
            ]);
        }
        return $this->client;
    }

    protected function request(string $method, string $uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->client()->request($method, $uri, array_merge([
            'headers' => array_merge([
                'Authorization' => sprintf('Bearer %s', $this->authToken)
            ], $options['headers'] ?? [])
        ], $options));
    }

    public function getClubActivityPage(int $clubId, int $page)
    {
        $response = $this->request('GET', sprintf('clubs/%s/activities', $clubId), [
            'query' =>  [
                'page' => $page,
                'per_page' => 100
            ]
        ]);

        $content = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return array_map(function(array $parameters) {
            return StravaActivity::make(
                $this->teamId,
                $parameters['name'] ?? null,
                $parameters['distance'] ?? 0.0,
                $parameters['total_elevation_gain'] ?? 0.0,
                $parameters['moving_time'] ?? 0,
                $parameters['elapsed_time'] ?? 0,
                $parameters['type'] ?? 'Other'
            );
        }, $content);
    }

    /**
     *
     * @param int $clubId
     * @return array|StravaActivity[]
     */
    public function getNewClubActivities(int $clubId): array
    {
        $activities = [];
        $pageCacheKey = sprintf('strava.club-activities.sync.%s', $clubId);
        $page = Cache::get($pageCacheKey, 1);
        do {
            $activityPage = $this->getClubActivityPage($clubId, $page);
            $activityCount = count($activityPage);
            if($activityCount > 0) {
                array_push($activities, ...$activityPage);
                $page++;
                Cache::put($pageCacheKey, $page);
            }
        } while (count($activityPage) > 0);

        return $activities;

    }

}
