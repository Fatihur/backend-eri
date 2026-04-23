<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories_by_class(): void
    {
        $class = SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        Category::create(['class_id' => $class->id, 'name' => 'Seni Rupa', 'order' => 1]);
        Category::create(['class_id' => $class->id, 'name' => 'Seni Tari', 'order' => 2]);

        $response = $this->getJson("/api/categories?class_id={$class->id}");

        $response->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_categories_filtered_by_class_id(): void
    {
        $class1 = SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        $class2 = SchoolClass::create(['name' => 'Kelas 8', 'order' => 2]);
        Category::create(['class_id' => $class1->id, 'name' => 'Seni Rupa', 'order' => 1]);
        Category::create(['class_id' => $class2->id, 'name' => 'Seni Musik', 'order' => 1]);

        $response = $this->getJson("/api/categories?class_id={$class1->id}");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Seni Rupa');
    }
}
