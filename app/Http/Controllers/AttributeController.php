<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Services\AttributeService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
    public $attrSvc;

    public function __construct(AttributeService $attrSvc)
    {
        $this->attrSvc = $attrSvc;
    }
    public function index()
    {
        $attributes = $this->attrSvc->index();
        return response()->json($attributes);
    }

    public function store(StoreAttributeRequest $request)
    {
        $attribute = $this->attrSvc->store($request->all());
        return response()->json($attribute);
    }

    public function update(UpdateAttributeRequest $request, int $id)
    {
        try {
            $attribute = $this->attrSvc->update($request->all(), $id);
            return response()->json($attribute);
        } catch (ModelNotFoundException $e) {
            Log::error('Model Not Found Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Attribute not found'], 404);
        } catch (Exception $e) {
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the attribute'], 500);
        }
    }
}
