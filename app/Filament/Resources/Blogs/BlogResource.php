<?php

namespace App\Filament\Resources\Blogs;

use App\Filament\Resources\Blogs\Pages\CreateBlog;
use App\Filament\Resources\Blogs\Pages\EditBlog;
use App\Filament\Resources\Blogs\Pages\ListBlogs;
use App\Filament\Resources\Blogs\Tables\BlogsTable;
use App\Models\Blog;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
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

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Blog';
    protected static ?string $pluralModelLabel = 'Blogs';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Newspaper;
    protected static string | UnitEnum | null $navigationGroup = 'Blogs';

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

                Select::make('blog_type')
                    ->options([
                        'travel' => 'Travel',
                        'diy' => 'DIY',
                        'tutorial' => 'Tutorial',
                        'archive' => 'Archive',
                    ])
                    ->required()
                    ->default('blog'),

                TextInput::make('subtitle')
                    ->maxLength(255)
                    ->columnSpanFull(),

                MarkdownEditor::make('body')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('panorama')
                    ->label('Panorama')
                    ->image()
                    ->disk('public')
                    ->directory('travels/panoramas')
                    ->openable()
                    ->downloadable(),

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

                TextColumn::make('blog_type')
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
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
