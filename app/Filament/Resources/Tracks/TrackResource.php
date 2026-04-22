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
                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            FileUpload::make('file')
                ->label('MP3 file')
                ->disk('public')
                ->directory('tracks')
                ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                ->maxSize(204800) // 200MB
                ->required(),

            Placeholder::make('audio_preview')
                ->content(fn ($get) => view('filament.audio-preview', [
                    'file' => $get('file'),
                ]))
                ->visible(fn ($get) => $get('file')),

            TextInput::make('duration')
                ->numeric()
                ->label('Duration (seconds)')
                ->required(),

            TextInput::make('bpm')
                ->numeric()
                ->label('BPM')
                ->nullable(),
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

                TextColumn::make('duration'),

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
