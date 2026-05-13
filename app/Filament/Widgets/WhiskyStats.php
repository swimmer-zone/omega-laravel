<?php

namespace App\Filament\Widgets;

use App\Models\WhiskyCaskType;
use App\Models\WhiskyColor;
use App\Models\WhiskyCountry;
use App\Models\WhiskyDistillery;
use App\Models\WhiskyFinish;
use App\Models\WhiskyFlavour;
use App\Models\WhiskyRegion;
use App\Models\WhiskyTasting;
use App\Models\WhiskyType;
use App\Models\WhiskyTypeGroup;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WhiskyStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Whisky';

    protected function getStats(): array
    {
        return [
            Stat::make('Number of tastings', WhiskyTasting::count()),
            Stat::make('Number of cask types', WhiskyCaskType::count()),
            Stat::make('Number of colors', WhiskyColor::count()),
            Stat::make('Number of countries', WhiskyCountry::count()),
            Stat::make('Number of distilleries', WhiskyDistillery::count()),
            Stat::make('Number of finishes', WhiskyFinish::count()),
            Stat::make('Number of flavours', WhiskyFlavour::count()),
            Stat::make('Number of Scottish regions', WhiskyRegion::count()),
            Stat::make('Number of whisky types', WhiskyType::count()),
        ];
    }
}
