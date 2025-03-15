<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    const STATUS_NOT_STARTED = 'NotStarted';
    const STATUS_IN_PROGRESS = 'InProgress';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_CANCELED = 'Canceled';


    public static function getStatusValues(): array
    {
        return [
            self::STATUS_NOT_STARTED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELED,
        ];
    }
}
