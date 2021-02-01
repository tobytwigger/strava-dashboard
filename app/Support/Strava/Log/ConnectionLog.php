<?php

namespace App\Support\Strava\Log;

use App\Models\StravaConnectionLog;
use App\Support\Team\CurrentTeamResolver;

class ConnectionLog
{

    public function log(string $type, string $message, int $teamId = null)
    {
        if($teamId === null) {
            $teamId = app(CurrentTeamResolver::class)->currentId();
        }

        StravaConnectionLog::create([
            'type' => $type,
            'log' => $message,
            'team_id' => $teamId
        ]);
    }

    public function success(string $log, int $teamId = null)
    {
        $this->log(StravaConnectionLog::SUCCESS, $log, $teamId);
    }

    public function debug(string $log, int $teamId = null)
    {
        $this->log(StravaConnectionLog::DEBUG, $log, $teamId);
    }

    public function info(string $log, int $teamId = null)
    {
        $this->log(StravaConnectionLog::INFO, $log, $teamId);
    }

    public function warning(string $log, int $teamId = null)
    {
        $this->log(StravaConnectionLog::WARNING, $log, $teamId);
    }

    public function error(string $log, int $teamId = null)
    {
        $this->log(StravaConnectionLog::ERROR, $log, $teamId);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if(in_array($name, [
            StravaConnectionLog::WARNING,
            StravaConnectionLog::INFO,
            StravaConnectionLog::ERROR,
            StravaConnectionLog::DEBUG,
            StravaConnectionLog::SUCCESS
        ])) {
            $instance = app(static::class);

            return $instance->{$name}(...$arguments);
        }
        throw new \InvalidArgumentException(sprintf('Method %s not found in ConnectionLog', $name));
    }


}
