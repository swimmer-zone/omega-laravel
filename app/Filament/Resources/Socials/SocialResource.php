<?php

namespace App\Filament\Resources\Socials;

use App\Filament\Resources\Socials\Pages\CreateSocial;
use App\Filament\Resources\Socials\Pages\EditSocial;
use App\Filament\Resources\Socials\Pages\ListSocials;
use App\Filament\Resources\Socials\Schemas\SocialForm;
use App\Filament\Resources\Socials\Tables\SocialsTable;
use App\Models\Social;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;
    protected static ?string $recordTitleAttribute = 'Social';
    protected static ?string $modelLabel = 'Social';
    protected static ?string $pluralModelLabel = 'Socials';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::ChatBubbleLeft;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required(),

            TextInput::make('url')
                ->required(),

            FileUpload::make('icon')
                ->label('Icon')
                ->disk('public')
                ->directory('social')
                ->acceptedFileTypes(['image/svg+xml'])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('url')
                    ->searchable(),
            ])
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
            'index' => ListSocials::route('/'),
            'create' => CreateSocial::route('/create'),
            'edit' => EditSocial::route('/{record}/edit'),
        ];
    }
}
