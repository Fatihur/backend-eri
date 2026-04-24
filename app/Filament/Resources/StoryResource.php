<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryResource\Pages;
use App\Filament\Resources\StoryResource\RelationManagers\ScenesRelationManager;
use App\Models\Story;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Cerita';
    protected static ?string $modelLabel = 'Cerita';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Story')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Info')->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Cerita')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('stories/thumbnails'),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('Estimasi Durasi (menit)')
                            ->numeric()
                            ->minValue(1),
                        Forms\Components\Toggle::make('is_new')->label('Tandai sebagai Baru')->default(false),
                        Forms\Components\DateTimePicker::make('published_at')->label('Tanggal Publikasi'),
                    ])->columns(2),

                    Tab::make('Sinopsis')->schema([
                        Forms\Components\Textarea::make('synopsis')
                            ->label('Sinopsis')
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                    Tab::make('Pembelajaran')->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('Konten Storytelling')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('audio_url')
                            ->label('Audio Narasi')
                            ->directory('stories/audio')
                            ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg']),
                        Forms\Components\FileUpload::make('subtitle_vtt')
                            ->label('Subtitle (WebVTT)')
                            ->directory('stories/subtitles')
                            ->acceptedFileTypes(['text/vtt', 'text/plain']),
                        Forms\Components\FileUpload::make('sign_language_video')
                            ->label('Video Bahasa Isyarat')
                            ->directory('stories/sign-language')
                            ->acceptedFileTypes(['video/mp4', 'video/webm']),
                    ])->columns(2),

                    Tab::make('Sumber')->schema([
                        Forms\Components\RichEditor::make('sources')
                            ->label('Sumber & Referensi')
                            ->columnSpanFull(),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label('Thumb'),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->sortable(),
                Tables\Columns\TextColumn::make('duration_minutes')->label('Durasi')->suffix(' mnt'),
                Tables\Columns\IconColumn::make('is_new')->label('Baru')->boolean(),
                Tables\Columns\TextColumn::make('scenes_count')->label('Scenes')->counts('scenes'),
                Tables\Columns\TextColumn::make('published_at')->label('Publish')->dateTime('d M Y')->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_new')->label('Baru'),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array
    {
        return [ScenesRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStories::route('/'),
            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }
}
