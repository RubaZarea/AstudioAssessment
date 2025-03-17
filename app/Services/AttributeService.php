<?php

namespace App\Services;

use App\Models\Attribute;
use App\Repositories\AttributeRepository;
use Illuminate\Database\Eloquent\Collection;

class AttributeService
{
    private $attrRepo;

    public function __construct(AttributeRepository $attributeRepo)
    {
        $this->attrRepo = $attributeRepo;
    }

    public function index(): Collection
    {
        return $this->attrRepo->index();
    }

    public function store(array $attrData): Attribute
    {
        return $this->attrRepo->store($attrData);
    }

    public function update(array $attrData, int $id): Attribute
    {
        return $this->attrRepo->update($attrData, $id);
    }
}
