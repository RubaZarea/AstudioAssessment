<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{

    public function index(): Collection
    {
        return Project::with('attributes')->get();
    }

    public function store(array $projectData): Project
    {
        return Project::create($projectData);
    }

    public function show($id): Project
    {
        return Project::with('attributes')->findOrFail($id);
    }

    public function update(array $projectData, $id): Project
    {
        $project = Project::findOrFail($id);
        $project->update($projectData);

        return $project;
    }
    
    public function destroy(int $id): void
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }
}
