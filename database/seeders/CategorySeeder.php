<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Budaya',         'slug' => 'budaya',         'icon' => 'home',     'color' => '#86A35F', 'order' => 1, 'description' => 'Cerita seputar kebudayaan daerah.'],
            ['name' => 'Sejarah',        'slug' => 'sejarah',        'icon' => 'sword',    'color' => '#8B5E3C', 'order' => 2, 'description' => 'Kisah peristiwa sejarah dan tokoh.'],
            ['name' => 'Tradisi',        'slug' => 'tradisi',        'icon' => 'drum',     'color' => '#D8B15F', 'order' => 3, 'description' => 'Tradisi turun-temurun masyarakat.'],
            ['name' => 'Alam',           'slug' => 'alam',           'icon' => 'mountain', 'color' => '#2E7D32', 'order' => 4, 'description' => 'Legenda tentang alam dan lingkungan.'],
            ['name' => 'Kearifan Lokal', 'slug' => 'kearifan-lokal', 'icon' => 'book',     'color' => '#1F2937', 'order' => 5, 'description' => 'Nilai-nilai kearifan lokal nusantara.'],
        ];

        foreach ($categories as $c) {
            Category::updateOrCreate(['slug' => $c['slug']], $c);
        }
    }
}
