<?php

namespace App\Filament\Resources\Galleries;

use App\Filament\Resources\Galleries\Pages\CreateGallery;
use App\Filament\Resources\Galleries\Pages\EditGallery;
use App\Filament\Resources\Galleries\Pages\ListGalleries;
use App\Filament\Resources\Galleries\Schemas\GalleryForm;
use App\Filament\Resources\Galleries\Tables\GalleriesTable;
use App\Models\Gallery;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Table;
use Str;
use UnitEnum;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;
    protected static ?string $recordTitleAttribute = 'Gallery';
    protected static ?string $modelLabel = 'Gallery';
    protected static ?string $pluralModelLabel = 'Galleries';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Photo;
    protected static string | UnitEnum | null $navigationGroup = 'Travels';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('travel_id')
                ->relationship('travel', 'title')
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => $record->title
                )
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            FileUpload::make('images')
                ->label('Gallery images')
                ->multiple()
                ->image()
                ->disk('public')
                ->directory('galleries')
                ->reorderable()
                ->appendFiles()
                ->panelLayout('grid')
                ->openable()
                ->downloadable()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('travel.title')
                    ->label('Travel')
                    ->searchable(),

                TextColumn::make('slug')
                    ->searchable(),

                TextColumn::make('images_count')
                    ->label('Images')
                    ->state(fn (Gallery $record) => count($record->images ?? [])),
            ])
            ->filters([BaseFilter::make('travel.title')])
            ->defaultSort('id')
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
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }
}
