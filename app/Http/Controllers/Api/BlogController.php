<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    private function indexByType(string $type)
    {
        return Blog::query()
            ->where('blog_type', $type)
            ->where('is_published', true)
            ->with('galleries')
            ->orderByDesc('published_at')
            ->get()
            ->map(function (Blog $blog) {
                return [
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'published_at' => $blog->published_at,
                    'panorama' => $blog->panorama
                        ? Storage::disk('public')->url($blog->panorama)
                        : null,
                    'image_count' => $blog->galleries
                        ->sum(fn ($gallery) => count($gallery->images ?? [])),
                ];
            });
    }

    private function showByType(string $type, string $slug)
    {
        $blog = Blog::query()
            ->with('galleries')
            ->where('blog_type', $type)
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json([
            'id' => $blog->id,
            'title' => $blog->title,
            'subtitle' => $blog->subtitle,
            'slug' => $blog->slug,
            'blog_type' => $blog->blog_type,
            'body' => $blog->body,
            'published_at' => $blog->published_at,
            'panorama' => $blog->panorama_image
                ? Storage::disk('public')->url($blog->panorama)
                : null,
            'galleries' => $blog->galleries->map(fn ($gallery) => [
                'id' => $gallery->id,
                'title' => $gallery->title,
                'slug' => $gallery->slug,
                'description' => $gallery->description,
                'images' => collect($gallery->images ?? [])
                    ->map(fn ($path) => Storage::disk('public')->url($path))
                    ->values(),
            ]),
        ]);
    }

    public function travels()
    {
        return $this->indexByType('travel');
    }

    public function travel(string $slug)
    {
        return $this->showByType('travel', $slug);
    }

    public function diy()
    {
        return $this->indexByType('diy');
    }

    public function diyShow(string $slug)
    {
        return $this->showByType('diy', $slug);
    }

    public function tutorials()
    {
        return $this->indexByType('tutorial');
    }

    public function tutorialShow(string $slug)
    {
        return $this->showByType('tutorial', $slug);
    }

    public function archive()
    {
        return $this->indexByType('archive');
    }

    public function archiveShow(string $slug)
    {
        return $this->showByType('archive', $slug);
    }
}
