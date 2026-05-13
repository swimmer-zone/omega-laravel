<?php

namespace App\Filament\Widgets;

use App\Models\WhiskyTasting;
use Filament\Widgets\ChartWidget;

class WhiskyChart extends ChartWidget
{
    protected ?string $heading = 'Whisky Ratings';

    protected function getData(): array
    {
        $ratings = WhiskyTasting::query()
            ->selectRaw('rating, COUNT(*) as total')
            ->whereNotNull('rating')
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('total', 'rating');

        return [
            'labels' => $ratings->keys()->map(fn ($rating) => "{$rating} stars")->toArray(),
            'datasets' => [
                [
                    'label' => 'Ratings',
                    'data' => $ratings->values()->toArray(),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
