<?php

namespace App\Http\Controllers;

use App\DTO\UserInput;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userSvc;

    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function index()
    {
        $user = $this->userSvc->index();
        return response()->json($user);
    }

    public function store(RegisterRequest $request)
    {
        $userData = UserInput::fromRequest($request);
        $user = $this->userSvc->store($userData);
        return response()->json($user);
    }

    public function show(int $id)
    {
        try {
            $user = $this->userSvc->show($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            Log::error('Model Not Found Exception: ' . $e->getMessage());
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $user = $this->userSvc->update($request->all(), $id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            Log::error('Model Not Found Exception: ' . $e->getMessage());
            return response()->json(['error' => 'User not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the user'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userSvc->destroy($id);
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('ModelNotFoundException: ' . $e->getMessage());
            return response()->json(['error' => 'User not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the user'], 500);
        }
    }
}
