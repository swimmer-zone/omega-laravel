<?php

namespace App\Filament\Widgets;

use App\Models\TrackPlay;
use Filament\Widgets\ChartWidget;

class PlaysPerDayChart extends ChartWidget
{
    protected ?string $heading = 'Plays per day';

    protected function getData(): array
    {
        $plays = TrackPlay::query()
            ->where('counted', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];

        foreach (range(29, 0) as $daysAgo) {
            $date = now()->subDays($daysAgo)->toDateString();

            $labels[] = $date;
            $data[] = $plays[$date] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Plays',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
