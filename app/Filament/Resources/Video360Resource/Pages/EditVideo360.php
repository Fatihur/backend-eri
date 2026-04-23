<?php

namespace App\Filament\Resources\Video360Resource\Pages;

use App\Filament\Resources\Video360Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideo360 extends EditRecord
{
    protected static string $resource = Video360Resource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
