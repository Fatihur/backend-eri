<?php

namespace App\Filament\Resources\StoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ScenesRelationManager extends RelationManager
{
    protected static string $relationship = 'scenes';
    protected static ?string $title = 'Scene Cerita';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('order')->label('Urutan')->numeric()->required()->default(0),
            Forms\Components\Textarea::make('text')->label('Teks Cerita')->rows(4)->columnSpanFull(),
            Forms\Components\FileUpload::make('image')->label('Gambar Scene')->image()->directory('story-scenes'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')->label('Urutan')->sortable(),
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('text')->label('Teks')->limit(50),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
