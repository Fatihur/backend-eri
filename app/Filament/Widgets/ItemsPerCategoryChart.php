<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class ItemsPerCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Item per Kategori';

    protected function getData(): array
    {
        $categories = Category::orderBy('order')->withCount('items')->get();

        return [
            'datasets' => [[
                'label' => 'Jumlah Item',
                'data' => $categories->pluck('items_count')->all(),
                'backgroundColor' => ['#2E7D32', '#86A35F', '#D8B15F', '#8B5E3C', '#1F2937', '#F6F3EC'],
            ]],
            'labels' => $categories->pluck('name')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
