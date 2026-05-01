<?php

namespace App\Filament\Resources\VisitedCountries;

use App\Filament\Resources\VisitedCountries\Pages\CreateVisitedCountry;
use App\Filament\Resources\VisitedCountries\Pages\EditVisitedCountry;
use App\Filament\Resources\VisitedCountries\Pages\ListVisitedCountries;
use App\Filament\Resources\VisitedCountries\Schemas\VisitedCountryForm;
use App\Filament\Resources\VisitedCountries\Tables\VisitedCountriesTable;
use App\Models\VisitedCountry;
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

class VisitedCountryResource extends Resource
{
    protected static ?string $model = VisitedCountry::class;
    protected static ?string $recordTitleAttribute = 'value';
    protected static ?string $modelLabel = 'Visited Country';
    protected static ?string $pluralModelLabel = 'Visited Countries';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::GlobeEuropeAfrica;
    protected static string | UnitEnum | null $navigationGroup = 'Travels';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
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
            'index' => ListVisitedCountries::route('/'),
            'create' => CreateVisitedCountry::route('/create'),
            'edit' => EditVisitedCountry::route('/{record}/edit'),
        ];
    }
}
