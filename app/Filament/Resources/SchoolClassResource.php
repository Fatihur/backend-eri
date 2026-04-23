<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolClassResource\Pages;
use App\Models\SchoolClass;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolClassResource extends Resource
{
    protected static ?string $model = SchoolClass::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Kelas';
    protected static ?string $modelLabel = 'Kelas';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')->label('Nama Kelas')->required()->maxLength(255),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
            Forms\Components\TextInput::make('icon')->label('Ikon')->maxLength(255),
            Forms\Components\ColorPicker::make('color')->label('Warna'),
            Forms\Components\TextInput::make('order')->label('Urutan')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\ColorColumn::make('color')->label('Warna'),
                Tables\Columns\TextColumn::make('categories_count')->label('Kategori')->counts('categories'),
                Tables\Columns\TextColumn::make('order')->label('Urutan')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchoolClasses::route('/'),
            'create' => Pages\CreateSchoolClass::route('/create'),
            'edit' => Pages\EditSchoolClass::route('/{record}/edit'),
        ];
    }
}
