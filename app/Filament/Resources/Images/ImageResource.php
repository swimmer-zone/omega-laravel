<?php

namespace App\Filament\Resources\Images;

use App\Filament\Resources\Images\Pages\CreateImage;
use App\Filament\Resources\Images\Pages\EditImage;
use App\Filament\Resources\Images\Pages\ListImages;
use App\Filament\Resources\Images\Schemas\ImageForm;
use App\Filament\Resources\Images\Tables\ImagesTable;
use App\Models\Image;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Image';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('gallery_id')
                ->relationship(
                    name: 'gallery',
                    titleAttribute: 'title',
                    modifyQueryUsing: fn ($query) => $query->with('travels')->orderBy('title')
                )
                ->getOptionLabelFromRecordUsing(
                    fn (Gallery $record): string => "{$record->title} ({$record->travel?->title})"
                )
                ->searchable()
                ->preload()
                ->required(),

            FileUpload::make('path')
                ->disk('public')
                ->directory('galleries')
                ->image()
                ->imageResizeMode('contain')
                ->imageResizeTargetWidth('640')
                ->openable()
                ->downloadable()
                ->required(),

            TextInput::make('alt')
                ->maxLength(255),

            TextInput::make('caption')
                ->maxLength(255),

            TextInput::make('sort_order')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ImagesTable::configure($table);
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
            'index' => ListImages::route('/'),
            'create' => CreateImage::route('/create'),
            'edit' => EditImage::route('/{record}/edit'),
        ];
    }
}
