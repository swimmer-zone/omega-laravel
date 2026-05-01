<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhiskyDistillery extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'marker_offset',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }
}
