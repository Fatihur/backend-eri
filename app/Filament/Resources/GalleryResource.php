<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galeri';
    protected static ?string $modelLabel = 'Galeri';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('material_id')->label('Materi')->relationship('material', 'title')->required()->searchable(),
            Forms\Components\FileUpload::make('image_path')->label('Gambar')->image()->directory('galleries')->required(),
            Forms\Components\TextInput::make('caption')->label('Caption')->maxLength(255),
            Forms\Components\TextInput::make('order')->label('Urutan')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('Gambar'),
                Tables\Columns\TextColumn::make('caption')->label('Caption')->searchable(),
                Tables\Columns\TextColumn::make('material.title')->label('Materi')->sortable(),
                Tables\Columns\TextColumn::make('order')->label('Urutan')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([Tables\Filters\SelectFilter::make('material_id')->label('Materi')->relationship('material', 'title')])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
