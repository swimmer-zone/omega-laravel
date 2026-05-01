<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitedCity extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'annotation',
        'link',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'annotation' => 'array',
        ];
    }
}
