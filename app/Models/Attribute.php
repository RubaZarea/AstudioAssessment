<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $fillable = [
        'name',
        'type',
    ];

    const TEXT_TYPE = 'text';
    const DATE_TYPE = 'date';
    const NUMBER_TYPE = 'number';
    const SELECT_TYPE = 'select';

    public static function getAttributeTypes(): array
    {
        return [
            self::TEXT_TYPE,
            self::DATE_TYPE,
            self::NUMBER_TYPE,
            self::SELECT_TYPE
        ];
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
