<?php

namespace Tests\Feature;

use App\Filament\Widgets\ItemsPerCategoryChart;
use App\Filament\Widgets\StatsOverviewWidget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardWidgetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_stats_and_chart_widgets_render(): void
    {
        Livewire::test(StatsOverviewWidget::class)
            ->assertSee('Total Kategori')
            ->assertSee('Total Item')
            ->assertSee('Total Item 3D');

        Livewire::test(ItemsPerCategoryChart::class)
            ->assertSee('Distribusi Item per Kategori');
    }

    public function test_3d_stat_label_present_in_render_output(): void
    {
        Livewire::test(StatsOverviewWidget::class)
            ->assertSee('Total Item 3D');
    }
}
