<?php

namespace App\Filament\Resources\VisitedCities;

use App\Filament\Resources\VisitedCities\Pages\CreateVisitedCity;
use App\Filament\Resources\VisitedCities\Pages\EditVisitedCity;
use App\Filament\Resources\VisitedCities\Pages\ListVisitedCities;
use App\Filament\Resources\VisitedCities\Schemas\VisitedCityForm;
use App\Filament\Resources\VisitedCities\Tables\VisitedCitiesTable;
use App\Models\VisitedCity;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class VisitedCityResource extends Resource
{
    protected static ?string $model = VisitedCity::class;
    protected static ?string $recordTitleAttribute = 'value';
    protected static ?string $modelLabel = 'Visited City';
    protected static ?string $pluralModelLabel = 'Visited Cities';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::GlobeEuropeAfrica;
    protected static string | UnitEnum | null $navigationGroup = 'Travels';

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

            Repeater::make('values')
                ->schema([
                    TextInput::make('value')
                        ->numeric()
                        ->required(),
                ])
                ->default([])
                ->mutateDehydratedStateUsing(function (?array $state): array {
                    return collect($state ?? [])
                        ->pluck('value')
                        ->map(fn ($value) => is_numeric($value) ? (float) $value : null)
                        ->filter(fn ($value) => $value !== null)
                        ->values()
                        ->all();
                })
                ->afterStateHydrated(function (Repeater $component, ?array $state): void {
                    $component->state(
                        collect($state ?? [])
                            ->map(fn ($value) => ['value' => $value])
                            ->all()
                    );
                }),
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
            'index' => ListVisitedCities::route('/'),
            'create' => CreateVisitedCity::route('/create'),
            'edit' => EditVisitedCity::route('/{record}/edit'),
        ];
    }
}
