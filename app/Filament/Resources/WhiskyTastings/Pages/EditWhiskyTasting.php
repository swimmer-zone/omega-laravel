<?php

namespace App\Filament\Resources\WhiskyTastings\Pages;

use App\Filament\Resources\WhiskyTastings\WhiskyTastingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWhiskyTasting extends EditRecord
{
    protected static string $resource = WhiskyTastingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
