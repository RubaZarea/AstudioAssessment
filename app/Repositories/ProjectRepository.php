<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{

    public function index(): Collection
    {
        return Project::with('attributes')->get();
    }

    public function store(array $projectData, bool $setAttrValues = false): Project
    {
        $project = Project::create($projectData);
        if ($setAttrValues) {
            foreach ($projectData['attributes'] as $attr) {
                $isValid = $this->isValidValueType($attr);
                if (!$isValid) continue;

                AttributeValue::create([
                    'attribute_id' => $attr['id'],
                    'entity_id' => $project->id,
                    'value' => $attr['value']
                ]);
            }
        }
        return Project::with('attributes')->find($project->id);
    }

    public function show($id): Project
    {
        return Project::with('attributes')->findOrFail($id);
    }

    public function update(array $projectData, int $id, bool $setAttrValues = false): Project
    {
        $project = Project::findOrFail($id);
        $project->update($projectData);

        if ($setAttrValues) {
            foreach ($projectData['attributes'] as $attr) {
                $isValid = $this->isValidValueType($attr);
                if (!$isValid) continue;

                AttributeValue::updateOrCreate(
                    [
                        'attribute_id' => $attr['id'],
                        'entity_id' => $project->id
                    ],
                    [
                        'value' => $attr['value']
                    ]
                );
            }
        }
        return Project::with('attributes')->find($project->id);;
    }

    public function destroy(int $id): void
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }

    public function isValidValueType(array $attributes): bool
    {
        $attribute = Attribute::find($attributes['id']);
        if (!$attribute) {
            return false;
        }

        //Check if the entered values's type matches the attribute's type
        return match ($attribute->type) {
            'number' => is_numeric($attributes['value']),
            //If the string is not a valid date, strtotime() returns false.
            'date' => strtotime($attributes['value']) !== false,
            'select', 'text' => is_string($attributes['value']),
            default => false,
        };
    }
}
