<?php

namespace App\Filament\Resources\Video360Resource\Pages;

use App\Filament\Resources\Video360Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideo360s extends ListRecords
{
    protected static string $resource = Video360Resource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
