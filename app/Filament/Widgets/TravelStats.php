<?php

namespace App\Filament\Widgets;

use App\Models\Gallery;
use App\Models\Blog;
use App\Models\VisitedCity;
use App\Models\VisitedCountry;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TravelStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Travels';

    protected function getStats(): array
    {
        return [
            Stat::make('Blogs', Blog::count()),
            Stat::make('Galleries', Gallery::count()),
            Stat::make('Countries', VisitedCountry::count()),
            Stat::make('Cities', VisitedCity::count()),
        ];
    }
}
