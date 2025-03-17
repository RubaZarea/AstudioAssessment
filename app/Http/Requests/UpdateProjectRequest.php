<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'id' => 'required|exists:projects,id',
            'name' => 'string|max:255|unique:projects,name,' . $this->input('id'),
            'status' => 'required|in:' . implode(',', Project::getStatusValues()),
            'attributes' => 'sometimes|array',
            'attributes.*.id' => 'required_with:attributes|exists:attributes,id',
            'attributes.*.value' => 'required_with:attributes',
        ];
    }
}
