<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function show(string $slug)
    {
        $gallery = Gallery::query()
            ->with('travel')
            ->where('slug', $slug)
            ->firstOrFail();

        $images = array_map(function (string $path): array {
            return [
                'src' => Storage::disk('public')->url($path),
                'alt' => '',
                'caption' => '',
            ];
        }, $gallery->images ?? []);

        return response()->json([
            'id' => $gallery->id,
            'title' => $gallery->title,
            'slug' => $gallery->slug,
            'description' => $gallery->description,
            'travel' => [
                'id' => $gallery->travel->id,
                'title' => $gallery->travel->title,
                'slug' => $gallery->travel->slug,
            ],
            'images' => $images,
        ]);
    }
}
