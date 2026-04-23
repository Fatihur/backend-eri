<?php

namespace App\Filament\Widgets;

use App\Models\Material;
use App\Models\SchoolClass;
use Filament\Widgets\ChartWidget;

class MaterialsPerClassChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Materi per Kelas';

    protected function getData(): array
    {
        $classes = SchoolClass::orderBy('order')->get();
        $labels = [];
        $data = [];

        foreach ($classes as $class) {
            $labels[] = $class->name;
            $data[] = Material::whereHas('category', fn ($q) => $q->where('class_id', $class->id))->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Materi',
                    'data' => $data,
                    'backgroundColor' => ['#4F46E5', '#7C3AED', '#2563EB', '#0891B2', '#059669', '#D97706'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
