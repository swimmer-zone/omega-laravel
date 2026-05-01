<?php

namespace App\Filament\Resources\VisitedCountries\Pages;

use App\Filament\Resources\VisitedCountries\VisitedCountryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVisitedCountries extends ListRecords
{
    protected static string $resource = VisitedCountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
