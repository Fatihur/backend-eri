<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Material;
use App\Models\SchoolClass;
use App\Models\Video360;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Video360ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_videos_360_by_material(): void
    {
        $class = SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        $category = Category::create(['class_id' => $class->id, 'name' => 'Seni Rupa', 'order' => 1]);
        $material = Material::create(['category_id' => $category->id, 'title' => 'Patung', 'description' => 'Desc']);

        Video360::create(['material_id' => $material->id, 'title' => 'View 360 Patung', 'file_path' => 'videos/360_1.mp4']);

        $response = $this->getJson("/api/videos-360/{$material->id}");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'View 360 Patung');
    }
}
