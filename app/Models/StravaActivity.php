<?php

namespace App\Models;

use App\Support\Team\CurrentTeamResolver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StravaActivity extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('valid-time', function (Builder $builder) {
            $id = Cache::remember(StravaActivity::class . '.smallestId', 7200, function() {
                $activities = StravaActivity::where('team_id', app(CurrentTeamResolver::class)->currentId())
                    ->orderBy('id', 'asc')
                    ->withoutGlobalScopes()
                    ->get();

                $cumulativeDistance = 0.0;
                $startDistance = app(CurrentTeamResolver::class)->currentTeam()->start_at;

                return $activities->skipUntil(function ($activity) use ($startDistance, &$cumulativeDistance) {
                    $cumulativeDistance += $activity->distance;
                    return $cumulativeDistance >= $startDistance;
                })->first()->id;
            });

            $builder->where('id', '>', 5);
        });
        static::addGlobalScope('current-team', function (Builder $builder) {
            $builder->where('team_id', app(CurrentTeamResolver::class)->currentId());
        });
    }

    protected $fillable = [
        'team_id',
        'name',
        'distance',
        'elevation_gain',
        'moving_time',
        'elapsed_time',
        'type',
        'ignored'
    ];

    protected $casts = [
        'name' => 'string',
        'distance' => 'float',
        'elevation_gain' => 'float',
        'moving_time' => 'integer',
        'elapsed_time' => 'integer',
        'type' => 'string',
        'team_id' => 'integer',
        'ignored' => 'boolean',
    ];

    public static function makeFromStravaActivity(\App\Support\Strava\Client\Models\StravaActivity $stravaActivity)
    {
        $instance = new StravaActivity();

        $instance->name = $stravaActivity->getName();
        $instance->distance = $stravaActivity->getDistance();
        $instance->elevation_gain = $stravaActivity->getElevationGain();
        $instance->moving_time = $stravaActivity->getMovingTime();
        $instance->elapsed_time = $stravaActivity->getElapsedTime();
        $instance->type = $stravaActivity->getType();
        $instance->team_id = $stravaActivity->getTeamId();

        return $instance;
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

}
