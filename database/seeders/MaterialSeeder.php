<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Material;
use App\Models\Reflection;
use App\Models\ReflectionOption;
use App\Models\Story;
use App\Models\StoryScene;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $sampleMaterials = [
            ['title' => 'Patung Tradisional Nusantara', 'description' => 'Mengenal berbagai patung tradisional dari seluruh Nusantara', 'history' => 'Patung tradisional Nusantara merupakan karya seni tiga dimensi yang dibuat oleh masyarakat Indonesia sejak zaman prasejarah.'],
            ['title' => 'Rumah Adat Indonesia', 'description' => 'Eksplorasi rumah adat dari berbagai daerah', 'history' => 'Rumah adat adalah bangunan yang memiliki ciri khas khusus sesuai dengan budaya dan tradisi masing-masing daerah.'],
            ['title' => 'Candi Borobudur', 'description' => 'Sejarah dan keindahan Candi Borobudur', 'history' => 'Candi Borobudur dibangun pada abad ke-9 pada masa pemerintahan Dinasti Syailendra.'],
        ];

        $category = Category::whereHas('schoolClass', fn ($q) => $q->where('name', 'Kelas 7'))->first();

        if (!$category) {
            return;
        }

        foreach ($sampleMaterials as $data) {
            $material = Material::create([
                'category_id' => $category->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'history' => $data['history'],
            ]);

            $story = Story::create([
                'material_id' => $material->id,
                'title' => "Cerita: {$data['title']}",
            ]);

            StoryScene::create(['story_id' => $story->id, 'order' => 1, 'text' => "Selamat datang di materi {$data['title']}. Mari kita mulai perjalanan belajar."]);
            StoryScene::create(['story_id' => $story->id, 'order' => 2, 'text' => $data['history']]);
            StoryScene::create(['story_id' => $story->id, 'order' => 3, 'text' => "Itulah cerita tentang {$data['title']}. Apa yang paling menarik menurutmu?"]);

            $reflection = Reflection::create([
                'material_id' => $material->id,
                'question' => 'Bagian mana yang paling menarik menurutmu?',
                'type' => 'image_choice',
            ]);

            ReflectionOption::create(['reflection_id' => $reflection->id, 'label' => 'Bentuknya unik']);
            ReflectionOption::create(['reflection_id' => $reflection->id, 'label' => 'Sejarahnya menarik']);
            ReflectionOption::create(['reflection_id' => $reflection->id, 'label' => 'Ingin tahu lebih banyak']);
        }
    }
}
