<?php

namespace App\Repositories;

use App\DTO\TimesheetInput;
use App\Models\Timesheet;
use Illuminate\Database\Eloquent\Collection;

class TimesheetRepository
{

    public function index(): Collection
    {
        return Timesheet::all();
    }

    public function store(TimesheetInput $timesheetData): Timesheet
    {
        return Timesheet::create([
            'user_id' => $timesheetData->userId,
            'project_id' => $timesheetData->projectId,
            'task_name' => $timesheetData->taskName,
            'date' => $timesheetData->date,
            'hours' => $timesheetData->hours,
        ]);
    }

    public function show($id): Timesheet
    {
        return Timesheet::findOrFail($id);
    }

    public function update(array $timesheetData, int $id): Timesheet
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->update($timesheetData);

        return $timesheet;
    }

    public function destroy(int $id): void
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->delete();
    }
}
