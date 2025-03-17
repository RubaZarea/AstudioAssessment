<?php

namespace App\Services;

use App\DTO\TimesheetInput;
use App\Models\Timesheet;
use App\Repositories\TimesheetRepository;
use Illuminate\Database\Eloquent\Collection;

class TimesheetService
{
    private $timesheetRepo;

    public function __construct(TimesheetRepository $timesheetRepo)
    {
        $this->timesheetRepo = $timesheetRepo;
    }

    public function index(): Collection
    {
        return $this->timesheetRepo->index();
    }

    public function store(TimesheetInput $timesheetData): Timesheet
    {
        return $this->timesheetRepo->store($timesheetData);
    }

    public function show(int $id): Timesheet
    {
        return $this->timesheetRepo->show($id);
    }

    public function update(array $timesheetData, int $id): Timesheet
    {
        return $this->timesheetRepo->update($timesheetData, $id);
    }

    public function destroy(int $id): void
    {
        $this->timesheetRepo->destroy($id);
    }
}