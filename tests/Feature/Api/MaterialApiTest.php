<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialApiTest extends TestCase
{
    use RefreshDatabase;

    private function createMaterial(): Material
    {
        $class = SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        $category = Category::create(['class_id' => $class->id, 'name' => 'Seni Rupa', 'order' => 1]);

        return Material::create([
            'category_id' => $category->id,
            'title' => 'Patung Tradisional',
            'description' => 'Deskripsi patung',
            'history' => 'Sejarah patung',
        ]);
    }

    public function test_can_list_materials_by_category(): void
    {
        $material = $this->createMaterial();

        $response = $this->getJson("/api/materials?category_id={$material->category_id}");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Patung Tradisional');
    }

    public function test_can_show_material_detail_with_galleries(): void
    {
        $material = $this->createMaterial();
        Gallery::create(['material_id' => $material->id, 'image_path' => 'img1.jpg', 'caption' => 'Foto 1', 'order' => 1]);

        $response = $this->getJson("/api/materials/{$material->id}");

        $response->assertOk()
            ->assertJsonPath('data.title', 'Patung Tradisional')
            ->assertJsonCount(1, 'data.galleries');
    }
}
