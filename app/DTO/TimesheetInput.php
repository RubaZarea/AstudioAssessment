<?php

namespace App\DTO;

use Illuminate\Http\Request;

class TimesheetInput
{
    public $userId;
    public $projectId;
    public $taskName;
    public $date;
    public $hours;

    public static function fromRequest(Request $request)
    {
        $inputs = new self();
        $inputs->userId = $request->user_id;
        $inputs->projectId = $request->project_id;
        $inputs->taskName = $request->task_name;
        $inputs->date = $request->date;
        $inputs->hours = $request->hours;

        return $inputs;
    }
}