<?php

namespace Tests\Feature\Api;

use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolClassApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_classes(): void
    {
        SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);
        SchoolClass::create(['name' => 'Kelas 8', 'order' => 2]);

        $response = $this->getJson('/api/classes');

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.name', 'Kelas 7');
    }

    public function test_classes_are_ordered(): void
    {
        SchoolClass::create(['name' => 'Kelas 9', 'order' => 3]);
        SchoolClass::create(['name' => 'Kelas 7', 'order' => 1]);

        $response = $this->getJson('/api/classes');

        $response->assertOk()
            ->assertJsonPath('data.0.name', 'Kelas 7')
            ->assertJsonPath('data.1.name', 'Kelas 9');
    }
}
