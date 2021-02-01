<?php

namespace App\Models;

use App\Support\Team\CurrentTeamResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubSyncronisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'record_count'
    ];

    public static function firstForCurrentTeam(): static
    {
        return static::query()->where('team_id', app(CurrentTeamResolver::class)->currentId())
            ->orderBy('created_at', 'ASC')
            ->firstOrFail();
    }

    public function stravaActivities(){
        return $this->hasMany(StravaActivity::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
