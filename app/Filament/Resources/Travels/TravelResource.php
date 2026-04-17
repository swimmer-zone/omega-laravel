<?php

namespace App\Filament\Resources\Travels;

use App\Filament\Resources\Travels\Pages\CreateTravel;
use App\Filament\Resources\Travels\Pages\EditTravel;
use App\Filament\Resources\Travels\Pages\ListTravels;
use App\Models\Travel;
use App\Filament\Resources\Travels\Tables\TravelsTable;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TravelResource extends Resource
{
    protected static ?string $model = Travel::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('subtitle')
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),

                MarkdownEditor::make('body')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->default(false),

                DateTimePicker::make('published_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return TravelsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTravels::route('/'),
            'create' => CreateTravel::route('/create'),
            'edit' => EditTravel::route('/{record}/edit'),
        ];
    }
}
