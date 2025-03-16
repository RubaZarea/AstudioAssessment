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

    public function index(): Collection
    {
        return $this->projectRepo->index();
    }

    public function store(array $projectData): Project
    {
        return $this->projectRepo->store($projectData);
    }

    public function show(int $id): Project
    {
        return $this->projectRepo->show($id);
    }

    public function update(array $projectData, int $id)
    {
        return $this->projectRepo->update($projectData, $id);
    }

     public function destroy(int $id): void
    {
        $this->projectRepo->destroy($id);
    }
}
