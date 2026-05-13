<?php

namespace App\Filament\Widgets;

use App\Models\Section;
use App\Models\Social;
use App\Models\Track;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MusicStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Home';

    protected function getStats(): array
    {
        return [
            Stat::make('Number of tracks', Track::count()),
            Stat::make('Number of music sections', Section::count()),
            Stat::make('Number of social media', Social::count()),
        ];
    }
}
