<?php

namespace App\Filament\Resources\VisitedCities\Pages;

use App\Filament\Resources\VisitedCities\VisitedCityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVisitedCity extends EditRecord
{
    protected static string $resource = VisitedCityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
