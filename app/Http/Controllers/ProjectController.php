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

    public function index()
    {
        $project = $this->projectSvc->index();
        return response()->json($project);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectSvc->store($request->all());
        return response()->json($project);
    }

    public function show($id)
    {
        try {
            $project = $this->projectSvc->show($id);
            return response()->json($project);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Project not found'], 404);
        }
    }

    public function update(UpdateProjectRequest $request, int $id)
    {
        try {
            $project = $this->projectSvc->update($request->all(), $id);
            return response()->json($project);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Project not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the project'], 500);
        }
    }
  
    public function destroy(Request $request)
    {
        try {
            $this->projectSvc->destroy($request->id);
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
