<?php

namespace App\Filament\Resources\Travels;

use App\Filament\Resources\Travels\Pages\CreateTravel;
use App\Filament\Resources\Travels\Pages\EditTravel;
use App\Filament\Resources\Travels\Pages\ListTravels;
use App\Filament\Resources\Travels\Tables\TravelsTable;
use App\Models\Travel;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Str;
use UnitEnum;

class TravelResource extends Resource
{
    protected static ?string $model = Travel::class;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Blog';
    protected static ?string $pluralModelLabel = 'Blogs';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Newspaper;
    protected static string | UnitEnum | null $navigationGroup = 'Travels';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('subtitle')
                    ->maxLength(255)
                    ->columnSpanFull(),

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
        return $table
            ->columns([
                TextColumn::make('title'),

                TextColumn::make('slug')
                    ->searchable(),

                TextColumn::make('published_at')
                    ->searchable(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
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
