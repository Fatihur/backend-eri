<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['name' => 'Kelas 7', 'description' => 'Materi seni budaya kelas 7', 'icon' => 'school', 'color' => '#4F46E5', 'order' => 1],
            ['name' => 'Kelas 8', 'description' => 'Materi seni budaya kelas 8', 'icon' => 'school', 'color' => '#7C3AED', 'order' => 2],
            ['name' => 'Kelas 9', 'description' => 'Materi seni budaya kelas 9', 'icon' => 'school', 'color' => '#2563EB', 'order' => 3],
            ['name' => 'Kelas 10', 'description' => 'Materi seni budaya kelas 10', 'icon' => 'school', 'color' => '#0891B2', 'order' => 4],
            ['name' => 'Kelas 11', 'description' => 'Materi seni budaya kelas 11', 'icon' => 'school', 'color' => '#059669', 'order' => 5],
            ['name' => 'Kelas 12', 'description' => 'Materi seni budaya kelas 12', 'icon' => 'school', 'color' => '#D97706', 'order' => 6],
        ];

        foreach ($classes as $class) {
            SchoolClass::create($class);
        }
    }
}
