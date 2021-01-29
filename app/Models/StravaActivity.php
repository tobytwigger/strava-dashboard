<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StravaActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'distance',
        'elevation_gain',
        'moving_time',
        'elapsed_time',
        'type',
        'team_id'
    ];

    protected $casts = [
        'name' => 'string',
        'distance' => 'float',
        'elevation_gain' => 'float',
        'moving_time' => 'integer',
        'elapsed_time' => 'integer',
        'type' => 'string',
        'team_id' => 'integer'
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
