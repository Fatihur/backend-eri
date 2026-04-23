<?php

namespace App\Filament\Resources\ReflectionResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class OptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'options';
    protected static ?string $title = 'Pilihan Refleksi';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('label')->label('Label')->required()->maxLength(255),
            Forms\Components\FileUpload::make('image')->label('Gambar')->image()->directory('reflection-options'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('label')->label('Label'),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\DeleteBulkAction::make()]);
    }
}
