<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    private $projectSvc;

    public function __construct(ProjectService $projectSvc)
    {
        $this->projectSvc = $projectSvc;
    }

    public function index(Request $request)
    {
        $filters = $request->has('filters') ? $request->filters : [];
        $project = $this->projectSvc->index($filters);

        return response()->json($project);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectSvc->store($request->all());
        return response()->json($project);
    }

    public function show(int $id)
    {
        try {
            $project = $this->projectSvc->show($id);
            return response()->json($project);
        } catch (ModelNotFoundException $e) {
            Log::error('Model Not Found Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Project not found'], 404);
        }
    }

    public function update(UpdateProjectRequest $request, int $id)
    {
        try {
            $project = $this->projectSvc->update($request->all(), $id);
            return response()->json($project);
        } catch (ModelNotFoundException $e) {
            Log::error('Model Not Found Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Project not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the project'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->projectSvc->destroy($id);
            return response()->json(['message' => 'Project deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('ModelNotFoundException: ' . $e->getMessage());
            return response()->json(['error' => 'Project not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the project'], 500);
        }
    }
}
