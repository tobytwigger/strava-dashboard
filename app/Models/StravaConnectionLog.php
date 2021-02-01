<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StravaConnectionLog extends Model
{
    use HasFactory;

    /**
     * Represents a successful connection
     *
     * @var string
     */
    const SUCCESS = 'success';

    /**
     * Information that can be used for debugging
     *
     * @var string
     */
    const DEBUG = 'debug';

    /**
     * Information that indicates action may need to be taken
     *
     * @var string
     */
    const WARNING = 'warning';

    /**
     * Information that needs no action
     *
     * @var string
     */
    const INFO = 'info';

    /**
     * Information that indicates something went wrong
     *
     * @var string
     */
    const ERROR = 'error';

    protected $fillable = [
        'type',
        'log',
        'team_id'
    ];

}
