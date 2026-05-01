<?php

namespace App\Filament\Resources\Homes;

use App\Filament\Resources\Homes\Pages\CreateHome;
use App\Filament\Resources\Homes\Pages\EditHome;
use App\Filament\Resources\Homes\Pages\ListHomes;
use App\Filament\Resources\Homes\Schemas\HomeForm;
use App\Filament\Resources\Homes\Tables\HomesTable;
use App\Models\Home;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomeResource extends Resource
{
    protected static ?string $model = Home::class;
    protected static ?string $recordTitleAttribute = 'Home';
    protected static ?string $modelLabel = 'Home';
    protected static ?string $pluralModelLabel = 'Home';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Home;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')->limit(80)->wrap(),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomes::route('/'),
            'edit' => EditHome::route('/{record}/edit'),
        ];
    }
}
