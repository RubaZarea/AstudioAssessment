<?php

namespace App\Repositories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;

class AttributeRepository 
{
    
    public function index(): Collection
    {
        return Attribute::all();
    }

    public function store(array $attrData): Attribute
    {
        return Attribute::create($attrData);
    }

    public function update(array $attrData, $id): Attribute
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update($attrData);
        return $attribute;
    }

}
