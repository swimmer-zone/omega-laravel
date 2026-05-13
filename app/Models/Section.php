<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }
}
