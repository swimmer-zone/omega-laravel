<?php

namespace App\Filament\Resources\WhiskyDistilleries;

use App\Filament\Resources\WhiskyDistilleries\Pages\CreateWhiskyDistillery;
use App\Filament\Resources\WhiskyDistilleries\Pages\EditWhiskyDistillery;
use App\Filament\Resources\WhiskyDistilleries\Pages\ListWhiskyDistilleries;
use App\Filament\Resources\WhiskyDistilleries\Schemas\WhiskyDistilleryForm;
use App\Filament\Resources\WhiskyDistilleries\Tables\WhiskyDistilleriesTable;
use App\Models\WhiskyDistillery;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class WhiskyDistilleryResource extends Resource
{
    protected static ?string $model = WhiskyDistillery::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Distillery';
    protected static ?string $pluralModelLabel = 'Distilleries';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::MapPin;
    protected static string | UnitEnum | null $navigationGroup = 'Whisky';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            TextInput::make('latitude')
                ->required()
                ->numeric()
                ->default(0)
                ->maxLength(255),

            TextInput::make('longitude')
                ->required()
                ->numeric()
                ->default(0)
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('latitude'),

                TextColumn::make('longitude'),
            ])
            ->defaultSort('name')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhiskyDistilleries::route('/'),
            'create' => CreateWhiskyDistillery::route('/create'),
            'edit' => EditWhiskyDistillery::route('/{record}/edit'),
        ];
    }
}
