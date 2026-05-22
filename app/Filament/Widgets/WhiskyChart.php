<?php

namespace App\Filament\Widgets;

use App\Models\WhiskyTasting;
use Filament\Widgets\ChartWidget;

class WhiskyChart extends ChartWidget
{
    protected ?string $heading = 'Whisky Ratings';

    protected int | string | array $columnSpan = 'full';

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

                    'backgroundColor' => [
                         '#E7E6FB',
                         '#D8D6FA',
                         '#C2BFF8',
                         '#ACA9F5',
                         '#948FF2',
                         '#7B77EF',
                         '#6360EC', // base
                         '#504DE0',
                         '#3D39D4',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
