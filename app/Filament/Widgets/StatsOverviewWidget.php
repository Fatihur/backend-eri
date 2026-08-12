<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Item;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $item3dCount = Item::whereNotNull('glb_path')->count();

        return [
            Stat::make('Total Kategori', Category::count())
                ->icon('heroicon-o-tag')
                ->color('success'),
            Stat::make('Total Item', Item::count())
                ->icon('heroicon-o-book-open')
                ->color('primary'),
            Stat::make('Total Item 3D', $item3dCount)
                ->icon('heroicon-o-cube')
                ->color('warning'),
        ];
    }
}
