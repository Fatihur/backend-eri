<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Material;
use App\Models\SchoolClass;
use App\Models\SignLanguageVideo;
use App\Models\Story;
use App\Models\StoryScene;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_story_with_scenes_and_sign_language(): void
    {
        $class = SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        $category = Category::create(['class_id' => $class->id, 'name' => 'Seni Rupa', 'order' => 1]);
        $material = Material::create(['category_id' => $category->id, 'title' => 'Patung', 'description' => 'Desc']);

        $story = Story::create(['material_id' => $material->id, 'title' => 'Cerita Patung']);
        $scene = StoryScene::create(['story_id' => $story->id, 'order' => 1, 'text' => 'Scene pertama']);
        SignLanguageVideo::create(['story_scene_id' => $scene->id, 'file_path' => 'videos/sign1.mp4']);

        $response = $this->getJson("/api/stories/{$material->id}");

        $response->assertOk()
            ->assertJsonPath('data.title', 'Cerita Patung')
            ->assertJsonCount(1, 'data.scenes')
            ->assertJsonPath('data.scenes.0.sign_language_video.file_path', 'videos/sign1.mp4');
    }

    public function test_returns_404_when_no_story(): void
    {
        $class = SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        $category = Category::create(['class_id' => $class->id, 'name' => 'Seni Rupa', 'order' => 1]);
        $material = Material::create(['category_id' => $category->id, 'title' => 'Patung', 'description' => 'Desc']);

        $response = $this->getJson("/api/stories/{$material->id}");

        $response->assertNotFound();
    }
}
