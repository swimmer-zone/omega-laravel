<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhiskyType extends Model
{
    protected $fillable = [
        'whisky_type_group_id',
        'name',
    ];

    public function whisky_type_group()
    {
        return $this->belongsTo(WhiskyTypeGroup::class);
    }
}
