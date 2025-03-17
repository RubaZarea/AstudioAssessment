<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:projects,name',
            'status' => 'required|in:' . implode(',', Project::getStatusValues()),
            'attributes' => 'sometimes|array', // The attributes array is optional
            'attributes.*.id' => 'required_with:attributes|exists:attributes,id', // id is required if attributes exist
            'attributes.*.value' => 'required_with:attributes',
        ];
    }
}
