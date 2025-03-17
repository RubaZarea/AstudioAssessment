<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     use HasFactory;

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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function attributes()
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }
}
