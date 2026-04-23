<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Material;
use App\Models\Reflection;
use App\Models\ReflectionOption;
use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReflectionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_reflections_with_options(): void
    {
        $class = SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        $category = Category::create(['class_id' => $class->id, 'name' => 'Seni Rupa', 'order' => 1]);
        $material = Material::create(['category_id' => $category->id, 'title' => 'Patung', 'description' => 'Desc']);

        $reflection = Reflection::create(['material_id' => $material->id, 'question' => 'Apa yang menarik?', 'type' => 'image_choice']);
        ReflectionOption::create(['reflection_id' => $reflection->id, 'label' => 'Bentuknya']);
        ReflectionOption::create(['reflection_id' => $reflection->id, 'label' => 'Sejarahnya']);

        $response = $this->getJson("/api/reflections/{$material->id}");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.question', 'Apa yang menarik?')
            ->assertJsonCount(2, 'data.0.options');
    }
}
