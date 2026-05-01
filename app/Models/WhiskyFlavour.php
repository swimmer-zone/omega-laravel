<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhiskyFlavour extends Model
{
    protected $fillable = [
        'name',
    ];

    public function whisky_tastings()
    {
        return $this->belongsToMany(
            WhiskyTasting::class,
            'whisky_flavour_whisky_tasting'
        );
    }
}
