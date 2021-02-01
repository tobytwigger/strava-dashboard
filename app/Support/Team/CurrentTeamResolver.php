<?php

namespace App\Support\Team;

use App\Models\Team;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CurrentTeamResolver
{

    public function getSessionKey()
    {
        return static::class . '.teamid';
    }

    public function currentId(): int
    {
        if($this->hasSessionTeam()) {
            return $this->getSessionTeam();
        }
        if($this->hasBoundTeam()) {
            return $this->getBoundTeam();
        }
        if($this->hasAuthenticatedTeam()) {
            return $this->getAuthenticatedTeam();
        }
        throw new \Exception('Team could not be found');
    }

    public function currentTeam(): Team
    {
        return Team::findOrFail($this->currentId());
    }

    public function hasCurrentId(): bool
    {
        return $this->hasSessionTeam() || $this->hasBoundTeam() || $this->hasAuthenticatedTeam();
    }

    private function hasSessionTeam(): bool
    {
        return Session::has($this->getSessionKey());
    }

    private function hasBoundTeam(): bool
    {
        return app()->has('current-team.id');
    }

    private function hasAuthenticatedTeam(): bool
    {
        return Auth::check();
    }

    private function getSessionTeam(): int
    {
        return (int) Session::get($this->getSessionKey());
    }

    private function getBoundTeam(): int
    {
        return (int) app()->make('current-team.id');
    }

    private function getAuthenticatedTeam(): int
    {
        return (int) Auth::user()->currentTeam->id;
    }


}
