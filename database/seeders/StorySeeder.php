<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\PanoramaHotspot;
use App\Models\PanoramaScene;
use App\Models\Story;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        $budaya = Category::where('slug', 'budaya')->first();
        $sejarah = Category::where('slug', 'sejarah')->first();
        $tradisi = Category::where('slug', 'tradisi')->first();

        $stories = [
            [
                'category_id' => $budaya?->id,
                'title' => 'Asal Usul Danau Taliwang',
                'synopsis' => 'Cerita rakyat tentang asal usul terciptanya Danau Taliwang yang penuh nilai moral dan kearifan lokal.',
                'content' => '<p>Pada zaman dahulu, ada seorang pemuda yang tinggal di wilayah Taliwang...</p>',
                'sources' => '<p>Dinas Kebudayaan Sumbawa Barat (2020).</p>',
                'duration_minutes' => 12,
                'is_new' => true,
            ],
            [
                'category_id' => $budaya?->id,
                'title' => 'Legenda Putri Ranggasela',
                'synopsis' => 'Kisah Putri Ranggasela dari tanah Sumbawa.',
                'content' => '<p>Alkisah hiduplah seorang putri bernama Ranggasela...</p>',
                'sources' => '<p>Arsip cerita rakyat lokal.</p>',
                'duration_minutes' => 10,
                'is_new' => false,
            ],
            [
                'category_id' => $tradisi?->id,
                'title' => 'Tradisi Bau Nyale',
                'synopsis' => 'Tradisi menangkap cacing laut di Lombok dan Sumbawa.',
                'content' => '<p>Setiap tahun masyarakat berkumpul di pantai...</p>',
                'sources' => '<p>Dokumentasi budaya Nusa Tenggara Barat.</p>',
                'duration_minutes' => 15,
                'is_new' => true,
            ],
            [
                'category_id' => $sejarah?->id,
                'title' => 'Perang Topat',
                'synopsis' => 'Ritual perang ketupat simbol kerukunan umat.',
                'content' => '<p>Perang Topat adalah tradisi unik di Lombok...</p>',
                'sources' => '<p>Jurnal Sejarah Lokal.</p>',
                'duration_minutes' => 18,
                'is_new' => false,
            ],
        ];

        foreach ($stories as $data) {
            if (! $data['category_id']) {
                continue;
            }
            $data['slug'] = Str::slug($data['title']);
            $data['published_at'] = now();
            $story = Story::updateOrCreate(['slug' => $data['slug']], $data);

            if ($story->scenes()->count() === 0) {
                $sceneA = PanoramaScene::create([
                    'story_id' => $story->id,
                    'title' => 'Tepi Danau',
                    'panorama_image' => 'panoramas/placeholder.jpg',
                    'initial_yaw' => 0,
                    'initial_pitch' => 0,
                    'order' => 1,
                ]);
                $sceneB = PanoramaScene::create([
                    'story_id' => $story->id,
                    'title' => 'Puncak Bukit',
                    'panorama_image' => 'panoramas/placeholder.jpg',
                    'initial_yaw' => 0,
                    'initial_pitch' => 0,
                    'order' => 2,
                ]);

                PanoramaHotspot::create([
                    'scene_id' => $sceneA->id,
                    'target_scene_id' => $sceneB->id,
                    'yaw' => 45,
                    'pitch' => 0,
                    'label' => 'Ke Puncak Bukit',
                    'type' => 'navigation',
                ]);
                PanoramaHotspot::create([
                    'scene_id' => $sceneB->id,
                    'target_scene_id' => $sceneA->id,
                    'yaw' => -135,
                    'pitch' => 0,
                    'label' => 'Ke Tepi Danau',
                    'type' => 'navigation',
                ]);
            }
        }
    }
}
