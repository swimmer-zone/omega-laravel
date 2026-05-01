<?php

namespace App\Filament\Resources\WhiskyTastings;

use App\Filament\Resources\WhiskyTastings\Pages\CreateWhiskyTasting;
use App\Filament\Resources\WhiskyTastings\Pages\EditWhiskyTasting;
use App\Filament\Resources\WhiskyTastings\Pages\ListWhiskyTastings;
use App\Filament\Resources\WhiskyTastings\Schemas\WhiskyTastingForm;
use App\Filament\Resources\WhiskyTastings\Tables\WhiskyTastingsTable;
use App\Models\WhiskyTasting;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class WhiskyTastingResource extends Resource
{
    protected static ?string $model = WhiskyTasting::class;
    protected static ?string $recordTitleAttribute = 'brand';
    protected static ?string $modelLabel = 'Tasting';
    protected static ?string $pluralModelLabel = 'Tastings';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Beaker;
    protected static string | UnitEnum | null $navigationGroup = 'Whisky';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('The Whisky')
                ->schema([
                    TextInput::make('brand')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('name')
                        ->maxLength(255),

                    Select::make('whisky_country_id')
                        ->label('Country')
                        ->relationship('country', 'name')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->name
                        )
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('whisky_region_id')
                        ->label('Region')
                        ->relationship('region', 'name')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->name
                        )
                        ->preload()
                        ->searchable(),

                    TextInput::make('strength')
                        ->required()
                        ->numeric()
                        ->default(40)
                        ->minValue(40)
                        ->maxLength(4),

                    TextInput::make('age')
                        ->numeric()
                        ->maxLength(2),

                    Select::make('whisky_type_id')
                        ->label('Type')
                        ->relationship('type', 'name')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->name
                        )
                        ->preload()
                        ->searchable(),

                    Select::make('whisky_color_id')
                        ->label('Color')
                        ->relationship('color', 'name')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->name
                        )
                        ->required()
                        ->preload(),

                    Select::make('whisky_cask_type_id')
                        ->label('Cask Type')
                        ->relationship('caskType', 'name')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->name
                        )
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->preload()
                        ->searchable(),

                    Select::make('whisky_distillery_id')
                        ->label('Distillery')
                        ->relationship('distillery', 'name')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->name
                        )
                        ->preload(),
                ])
                ->columns(2),

            Section::make('My Tasting')
                ->schema([
                    DateTimePicker::make('date_of_tasting')
                        ->label('Date of Tasting'),

                    TextInput::make('location')
                        ->label('Tasting Location')
                        ->maxLength(255),

                    Select::make('flavours')
                        ->label('Flavours')
                        ->multiple()
                        ->relationship('flavours', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->columnSpanFull(),

                    Select::make('whisky_finish_id')
                        ->label('Finish')
                        ->relationship('finish', 'name')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->name
                        )
                        ->preload()
                        ->required(),

                    TextInput::make('glance')
                        ->numeric()
                        ->step(10)
                        ->default(30)
                        ->minValue(10),

                    TextInput::make('rating')
                        ->numeric()
                        ->required()
                        ->default(2.5)
                        ->minValue(1),

                    Toggle::make('would_buy')
                        ->label('Would Buy Again')
                        ->default(false),

                    TextInput::make('url')
                        ->label('Where to Buy')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand')
                    ->searchable(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('rating')
                    ->searchable(),
            ])
            ->defaultSort('id', 'desc')
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
            'index' => ListWhiskyTastings::route('/'),
            'create' => CreateWhiskyTasting::route('/create'),
            'edit' => EditWhiskyTasting::route('/{record}/edit'),
        ];
    }
}
