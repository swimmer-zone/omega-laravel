<?php

namespace App\Filament\Resources\WhiskyDistilleries\Pages;

use App\Filament\Resources\WhiskyDistilleries\WhiskyDistilleryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWhiskyDistillery extends EditRecord
{
    protected static string $resource = WhiskyDistilleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
