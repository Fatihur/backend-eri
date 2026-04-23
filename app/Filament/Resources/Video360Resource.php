<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Video360Resource\Pages;
use App\Models\Video360;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class Video360Resource extends Resource
{
    protected static ?string $model = Video360::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationLabel = 'Video 360°';
    protected static ?string $modelLabel = 'Video 360°';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('material_id')->label('Materi')->relationship('material', 'title')->required()->searchable(),
            Forms\Components\TextInput::make('title')->label('Judul')->required()->maxLength(255),
            Forms\Components\FileUpload::make('file_path')->label('File Video/Image 360')->acceptedFileTypes(['video/mp4', 'video/webm', 'image/jpeg', 'image/png'])->directory('videos-360')->required(),
            Forms\Components\FileUpload::make('thumbnail')->label('Thumbnail')->image()->directory('videos-360/thumbnails'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label('Thumb'),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('material.title')->label('Materi')->sortable(),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideo360s::route('/'),
            'create' => Pages\CreateVideo360::route('/create'),
            'edit' => Pages\EditVideo360::route('/{record}/edit'),
        ];
    }
}
