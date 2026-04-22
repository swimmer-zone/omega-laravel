<?php

namespace App\Models;

use getid3_lib;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Str;

class Track extends Model
{
    protected $fillable = [
        'section_id',
        'title',
        'slug',
        'artist',
        'album',
        'genre',
        'year',
        'comment',
        'file',
        'track_number',
        'duration',
        'bpm',
        'is_published',
        'published_at',
    ];

    protected static function booted(): void
    {
        static::saved(function (Track $track): void {
            if (! $track->wasChanged('file')) {
                return;
            }

            $track->extractMetadataAndUpdateFields();
        });
    }

    protected $appends = ['url'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file);
    }

    public function extractMetadataAndUpdateFields(): void
    {
        if (! $this->file) {
            return;
        }

        $path = Storage::disk('public')->path($this->file);

        if (! file_exists($path)) {
            return;
        }

        $analyzer = new getID3();
        $info = $analyzer->analyze($path);

        getid3_lib::CopyTagsToComments($info);

        $tags = $info['comments'] ?? [];

        $newTitle = $this->firstTagValue($tags, ['title']) ?: $this->title;

        $this->forceFill([
            'title' => $newTitle,
            'slug' => $newTitle ? Str::slug($newTitle) : $this->slug,
            'track_number' => $this->firstTagValue($tags, ['track_number', 'track']),
            'bpm' => $this->firstTagValue($tags, ['bpm', 'tempo', 'tbpm']),
            'artist' => $this->firstTagValue($tags, ['artist']),
            'album' => $this->firstTagValue($tags, ['album']),
            'year' => $this->firstTagValue($tags, ['year', 'date']),
            'genre' => $this->firstTagValue($tags, ['genre']),
            'comment' => $this->firstTagValue($tags, ['comment', 'comments']),
        ])->saveQuietly();
    }

    protected function firstTagValue(array $tags, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (! array_key_exists($key, $tags)) {
                continue;
            }

            $value = $tags[$key];

            if (is_array($value)) {
                $value = $value[0] ?? null;
            }

            if ($value !== null && $value !== '') {
                return trim((string) $value);
            }
        }

        return null;
    }

    protected function makeUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->whereKeyNot($this->id)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
