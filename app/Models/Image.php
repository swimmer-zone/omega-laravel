<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'gallery_id',
        'path',
        'alt',
        'caption',
        'width',
        'height',
        'sort_order',
    ];

    protected $appends = ['url'];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }

    protected static function booted(): void
    {
        static::saved(function (Image $image) {
            $image->resizeStoredImage();
        });
    }

    public function resizeStoredImage(): void
    {
        if (! $this->path) {
            return;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($this->path)) {
            return;
        }

        $manager = new ImageManager(new Driver());
        $fullPath = $disk->path($this->path);

        $img = $manager->read($fullPath);

        if ($img->width() > 640) {
            $img->scaleDown(width: 640)->save($fullPath, quality: 85);
        }

        $this->forceFill([
            'width' => $img->width(),
            'height' => $img->height(),
        ])->saveQuietly();
    }
}
