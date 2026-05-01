<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhiskyTastingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'name' => $this->name,
            'age' => $this->age,
            'strength' => $this->strength,
            'rating' => $this->rating,
            'would_buy' => $this->would_buy,
            'date_of_tasting' => $this->date_of_tasting,
            'location' => $this->location,
            'notes' => $this->notes,
            'url' => $this->url,
            'glance' => $this->glance,

            'country' => $this->country?->name,
            'region' => $this->region?->name,

            'color' => $this->color ? [
                'name' => $this->color->name,
                'color' => $this->color->color,
            ] : null,

            'distillery' => $this->distillery?->name,
            'type' => $this->type?->name,
            'cask_type' => $this->caskType?->name,
            'finish' => $this->finish?->name,

            'flavours' => $this->flavours
                ->pluck('name')
                ->values(),
        ];
    }
}
