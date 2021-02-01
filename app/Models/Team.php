<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
        'club_id' => 'integer',
        'start_at' => 'float'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'personal_team',
        'slug',
        'club_id',
        'start_at'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function stravaTokens()
    {
        return $this->hasMany(StravaToken::class);
    }

    public function hasStravaToken()
    {
        return $this->stravaTokens()->count() > 0;
    }

    public function stravaActivities()
    {
        return $this->hasMany(StravaActivity::class);
    }

    public function clubSyncronisations()
    {
        return $this->hasMany(ClubSyncronisation::class);
    }
}
