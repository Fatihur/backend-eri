<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panorama_hotspots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scene_id')->constrained('panorama_scenes')->cascadeOnDelete();
            $table->foreignId('target_scene_id')->nullable()->constrained('panorama_scenes')->nullOnDelete();
            $table->float('yaw');
            $table->float('pitch');
            $table->string('label')->nullable();
            $table->string('type', 32)->default('navigation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panorama_hotspots');
    }
};
