<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MusicStats;
use App\Filament\Widgets\MusicStatsOverview;
use App\Filament\Widgets\PlaysPerDayChart;
use App\Filament\Widgets\PopularTracksTable;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TravelStats;
use App\Filament\Widgets\WhiskyChart;
use App\Filament\Widgets\WhiskyStats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Ω Dashboard';

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 4,
        ];
    }

    public function getWidgets(): array
    {
        return [
            MusicStatsOverview::class,
            PlaysPerDayChart::class,
            PopularTracksTable::class,
            MusicStats::class,
            StatsOverview::class,
            TravelStats::class,
            WhiskyChart::class,
            WhiskyStats::class,
        ];
    }
}
