<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    private $projectRepo;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function index(array $filters = []): Collection
    {
        return $this->projectRepo->index($filters);
    }

    public function store(array $projectData): Project
    {
        $setAttrValues = array_key_exists('attributes', $projectData) ? true : false;
        return $this->projectRepo->store($projectData, $setAttrValues);
    }

    public function show(int $id): Project
    {
        return $this->projectRepo->show($id);
    }

    public function update(array $projectData, int $id): Project
    {
        $setAttrValues = array_key_exists('attributes', $projectData) ? true : false;
        return $this->projectRepo->update($projectData, $id, $setAttrValues);
    }

     public function destroy(int $id): void
    {
        $this->projectRepo->destroy($id);
    }
}
