<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Material;
use App\Models\SchoolClass;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kelas', SchoolClass::count())->icon('heroicon-o-academic-cap')->color('primary'),
            Stat::make('Total Kategori', Category::count())->icon('heroicon-o-tag')->color('success'),
            Stat::make('Total Materi', Material::count())->icon('heroicon-o-book-open')->color('warning'),
        ];
    }
}
