<?php

namespace App\Filament\Resources\VisitedCountries\Pages;

use App\Filament\Resources\VisitedCountries\VisitedCountryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVisitedCountry extends EditRecord
{
    protected static string $resource = VisitedCountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
