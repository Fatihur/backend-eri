<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Seni Rupa', 'Seni Musik', 'Seni Tari', 'Seni Teater', 'Kerajinan', 'Seni Budaya Tradisional'];

        $classes = SchoolClass::all();

        foreach ($classes as $class) {
            foreach ($categories as $order => $name) {
                Category::create([
                    'class_id' => $class->id,
                    'name' => $name,
                    'description' => "$name untuk {$class->name}",
                    'order' => $order + 1,
                ]);
            }
        }
    }
}
