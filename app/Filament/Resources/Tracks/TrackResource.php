<?php

namespace App\Filament\Resources\Tracks;

use App\Filament\Resources\Tracks\Pages\CreateTrack;
use App\Filament\Resources\Tracks\Pages\EditTrack;
use App\Filament\Resources\Tracks\Pages\ListTracks;
use App\Filament\Resources\Tracks\Schemas\TrackForm;
use App\Filament\Resources\Tracks\Tables\TracksTable;
use App\Models\Track;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Str;
use UnitEnum;

class TrackResource extends Resource
{
    protected static ?string $model = Track::class;
    protected static ?string $recordTitleAttribute = 'Track';
    protected static ?string $modelLabel = 'Track';
    protected static ?string $pluralModelLabel = 'Tracks';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::MusicalNote;
    protected static string | UnitEnum | null $navigationGroup = 'Music';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Track')
                ->schema([
                    Select::make('section_id')
                        ->relationship('section', 'title')
                        ->getOptionLabelFromRecordUsing(
                            fn ($record) => $record->title
                        )
                        ->searchable()
                        ->preload()
                        ->required(),

                    TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                        ->maxLength(255),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    FileUpload::make('file')
                        ->label('MP3 file')
                        ->disk('public')
                        ->directory('tracks')
                        ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                        ->maxSize(204800) // 200MB
                        ->required(),
                ])
                ->columns(1),

            Section::make('MP3 metadata')
                ->schema([
                    TextInput::make('artist')
                        ->readOnly()
                        ->dehydrated(false),

                    TextInput::make('album')
                        ->readOnly()
                        ->dehydrated(false),

                    TextInput::make('genre')
                        ->readOnly()
                        ->dehydrated(false),

                    TextInput::make('year')
                        ->readOnly()
                        ->dehydrated(false),

                    TextInput::make('track_number')
                        ->label('Track #')
                        ->readOnly()
                        ->dehydrated(false),

                    TextInput::make('duration')
                        ->label('Duration (seconds)')
                        ->numeric()
                        ->required()
                        ->default(1),

                    TextInput::make('bpm')
                        ->readOnly()
                        ->dehydrated(false),

                    Textarea::make('comment')
                        ->readOnly()
                        ->dehydrated(false)
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(1)
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('slug')
                    ->searchable(),

                TextColumn::make('duration')
                    ->formatStateUsing(fn ($state) => gmdate('i:s', $state)),

                TextColumn::make('bpm'),
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
            'index' => ListTracks::route('/'),
            'create' => CreateTrack::route('/create'),
            'edit' => EditTrack::route('/{record}/edit'),
        ];
    }
}
