<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{

    public function index(array $filters = []): Collection
    {
        $query = Project::query();
        if (!empty($filters)) {
            $query = $this->filterProjects($filters, $query);
        }
        return $query->with('attributes')->get();
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
            Attribute::NUMBER_TYPE => is_numeric($attributes['value']),
            //If the string is not a valid date, strtotime() returns false.
            Attribute::DATE_TYPE => strtotime($attributes['value']) !== false,
            Attribute::SELECT_TYPE, Attribute::TEXT_TYPE => is_string($attributes['value']),
            default => false,
        };
    }

    public function filterProjects(array $filters, Builder $query): Builder
    {
        foreach ($filters as $key => $value) {
            if (in_array($key, ['name', 'status'])) {
                $query->where($key, 'LIKE', "%{$value}%");
            } else {
                $query->whereHas('attributes', function ($q) use ($key, $value) {
                    $q->whereHas('attribute', function ($attrQuery) use ($key) {
                        $attrQuery->where('name', $key);
                    })->where('value', 'LIKE', "%{$value}%");
                });
            }
        }

        return $query;
    }
}
