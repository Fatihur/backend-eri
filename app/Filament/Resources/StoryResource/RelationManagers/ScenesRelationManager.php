<?php

namespace App\Filament\Resources\StoryResource\RelationManagers;

use App\Filament\Forms\Components\PanoramaHotspotPicker;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ScenesRelationManager extends RelationManager
{
    protected static string $relationship = 'scenes';
    protected static ?string $title = 'Scene Panorama 360°';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('title')->label('Nama Scene')->required()->maxLength(255),
            Forms\Components\TextInput::make('order')->label('Urutan')->numeric()->default(0),
            Forms\Components\FileUpload::make('panorama_image')
                ->label('Gambar Panorama (equirectangular)')
                ->image()
                ->directory('panoramas')
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('initial_yaw')->label('Yaw Awal (°)')->numeric()->default(0),
            Forms\Components\TextInput::make('initial_pitch')->label('Pitch Awal (°)')->numeric()->default(0),

            PanoramaHotspotPicker::make('hotspots')
                ->label('Hotspot Panah (klik pada panorama untuk menambah)')
                ->columnSpanFull(),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('panorama_image')->label('Panorama'),
                Tables\Columns\TextColumn::make('title')->label('Nama'),
                Tables\Columns\TextColumn::make('order')->label('Urutan')->sortable(),
                Tables\Columns\TextColumn::make('hotspots_count')->label('Hotspot')->counts('hotspots'),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\DeleteBulkAction::make()]);
    }
}
