<?php

namespace App\Http\Controllers;

use App\DTO\TimesheetInput;
use App\Http\Requests\StoreTimesheetRequest;
use App\Http\Requests\UpdateTimesheetRequest;
use App\Services\TimesheetService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class TimesheetController extends Controller
{
    private $timesheetSvc;

    public function __construct(TimesheetService $timesheetSvc)
    {
        $this->timesheetSvc = $timesheetSvc;
    }

    public function index()
    {
        $timesheet = $this->timesheetSvc->index();
        return response()->json($timesheet);
    }

    public function store(StoreTimesheetRequest $request)
    {
        $timesheetData = TimesheetInput::fromRequest($request);
        $timesheet = $this->timesheetSvc->store($timesheetData);
        return response()->json($timesheet);
    }

    public function show(int $id)
    {
        try {
            $timesheet = $this->timesheetSvc->show($id);
            return response()->json($timesheet);
        } catch (ModelNotFoundException $e) {
            Log::error('Model Not Found Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Timesheet not found'], 404);
        }
    }

    public function update(UpdateTimesheetRequest $request, int $id)
    {
        try {
            $timesheet = $this->timesheetSvc->update($request->all(), $id);
            return response()->json($timesheet);
        } catch (ModelNotFoundException $e) {
            Log::error('Model Not Found Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Timesheet not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the timesheet'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->timesheetSvc->destroy($id);
            return response()->json(['message' => 'Timesheet deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('ModelNotFoundException: ' . $e->getMessage());
            return response()->json(['error' => 'Timesheet not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the timesheet'], 500);
        }
    }
}
