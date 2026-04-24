<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\PanoramaScene;
use App\Models\Story;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kategori', Category::count())->icon('heroicon-o-tag')->color('success'),
            Stat::make('Total Cerita', Story::count())->icon('heroicon-o-book-open')->color('primary'),
            Stat::make('Total Scene 360°', PanoramaScene::count())->icon('heroicon-o-globe-alt')->color('warning'),
        ];
    }
}
