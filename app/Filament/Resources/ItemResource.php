<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Item Budaya';
    protected static ?string $modelLabel = 'Item';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Item')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Info')->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Item')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('items/thumbnails'),
                        Forms\Components\Toggle::make('is_new')
                            ->label('Tandai sebagai Baru')
                            ->default(false),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi'),
                    ])->columns(2),

                    Tab::make('Konten')->schema([
                        Forms\Components\RichEditor::make('history_text')
                            ->label('Teks Sejarah')
                            ->columnSpanFull()
                            ->extraInputAttributes(['style' => 'min-height: 360px;']),
                        Forms\Components\FileUpload::make('video_url')
                            ->label('Video')
                            ->columnSpanFull()
                            ->directory('items/videos')
                            ->maxSize(102400)
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->helperText('Upload file video (MP4, WebM, atau MOV). Maksimal 100MB.'),
                    ])->columns(2),

                    Tab::make('Aset 3D')->schema([
                        Forms\Components\FileUpload::make('glb_path')
                            ->label('File GLB')
                            ->directory('items/3d')
                            ->maxSize(25600)
                            ->acceptedFileTypes(['model/gltf-binary', 'application/octet-stream', '.glb'])
                            ->helperText('Upload file model 3D format GLB. Maksimal 25MB.'),
                        Forms\Components\FileUpload::make('glb_thumbnail')
                            ->label('Thumbnail 3D')
                            ->image()
                            ->directory('items/3d/thumbnails')
                            ->helperText('Gambar preview model 3D (opsional).'),
                    ])->columns(2),
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
                Tables\Columns\IconColumn::make('is_new')->label('Baru')->boolean(),
                Tables\Columns\IconColumn::make('glb_path')
                    ->label('3D')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->glb_path)),
                Tables\Columns\IconColumn::make('video_url')
                    ->label('Video')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !empty($record->video_url)),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publish')
                    ->dateTime('d M Y')
                    ->toggleable(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
