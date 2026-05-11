<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    protected $fillable = [
        'blog_type',
        'title',
        'subtitle',
        'slug',
        'body',
        'panorama',
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
