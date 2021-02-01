<?php

namespace App\Models;

use App\Support\Team\CurrentTeamResolver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StravaToken extends Model
{
    use HasFactory;

    protected $casts = [
        'expires_at' => 'datetime',
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted'
    ];

    protected $hidden = [
        'access_token',
        'refresh_token'
    ];

    protected $fillable = [];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('disabled', false);
        });
    }

    public static function makeFromStravaToken(\App\Support\Strava\Authentication\StravaToken $token)
    {
        $instance = new StravaToken();

        $instance->access_token = $token->getAccessToken();
        $instance->refresh_token = $token->getRefreshToken();
        $instance->expires_at = $token->getExpiresAt();
        $instance->team_id = app(CurrentTeamResolver::class)->currentId();
        $instance->disabled = false;

        return $instance;
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function expired()
    {
        return $this->expires_at->subMinutes(2)->isPast();
    }

    public function updateFromStravaToken(\App\Support\Strava\Authentication\StravaToken $newToken)
    {
        $instance = new StravaToken();

        $instance->access_token = $newToken->getAccessToken();
        $instance->refresh_token = $newToken->getRefreshToken();
        $instance->expires_at = $newToken->getExpiresAt();

        return $instance;
    }

}
