<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{

    protected $fillable = [
        'value',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'entity_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
