<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    protected $fillable = [
        'travel_id',
        'title',
        'slug',
        'description',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(function (Gallery $gallery): void {
            if (! $gallery->wasChanged('images')) {
                return;
            }

            $gallery->resizeImages();
        });
    }

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class)->orderBy('sort_order');
    }

    public function resizeImages(): void
    {
        $paths = $this->images ?? [];

        if ($paths === []) {
            return;
        }

        $disk = Storage::disk('public');
        $manager = new ImageManager(new Driver());

        foreach ($paths as $path) {
            if (! is_string($path) || $path === '') {
                continue;
            }

            if (! $disk->exists($path)) {
                continue;
            }

            $fullPath = $disk->path($path);
            $image = $manager->read($fullPath);

            if ($image->width() <= 640) {
                continue;
            }

            $image
                ->scaleDown(width: 640)
                ->save($fullPath, quality: 85);
        }
    }

    public function getAdminLabelAttribute(): string
    {
        return "{$this->title} ({$this->travel?->title})";
    }

    public function getImageUrlsAttribute(): array
    {
        $images = $this->images ?? [];

        return array_map(function (string $path): string {
            return Storage::disk('public')->url($path);
        }, $images);
    }
}
