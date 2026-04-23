<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Kategori';
    protected static ?string $modelLabel = 'Kategori';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('class_id')->label('Kelas')->relationship('schoolClass', 'name')->required()->searchable(),
            Forms\Components\TextInput::make('name')->label('Nama Kategori')->required()->maxLength(255),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
            Forms\Components\FileUpload::make('thumbnail')->label('Thumbnail')->image()->directory('categories'),
            Forms\Components\TextInput::make('order')->label('Urutan')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label('Thumb'),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('schoolClass.name')->label('Kelas')->sortable(),
                Tables\Columns\TextColumn::make('materials_count')->label('Materi')->counts('materials'),
                Tables\Columns\TextColumn::make('order')->label('Urutan')->sortable(),
            ])
            ->defaultSort('order')
            ->filters([Tables\Filters\SelectFilter::make('class_id')->label('Kelas')->relationship('schoolClass', 'name')])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
