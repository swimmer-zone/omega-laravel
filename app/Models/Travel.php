<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    protected $table = 'travels';

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'body',
        'is_published',
        'published_at',
    ];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
