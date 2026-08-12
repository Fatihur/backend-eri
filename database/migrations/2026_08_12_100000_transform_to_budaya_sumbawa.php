<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Transformasi database dari Story360 ke Budaya Sumbawa App:
     * 1. Drop panorama & media_items tables
     * 2. Rename stories → items
     * 3. Restructure columns
     */
    public function up(): void
    {
        // 1. Drop panorama_hotspots (depend on panorama_scenes)
        Schema::dropIfExists('panorama_hotspots');

        // 2. Drop panorama_scenes (depend on stories)
        Schema::dropIfExists('panorama_scenes');

        // 3. Drop media_items (depend on stories)
        Schema::dropIfExists('media_items');

        // 4. Rename stories → items
        Schema::rename('stories', 'items');

        // 5. Restructure items table
        Schema::table('items', function (Blueprint $table) {
            // Drop columns yang tidak dipakai lagi
            $table->dropColumn([
                'synopsis',
                'sources',
                'duration_minutes',
                'audio_url',
                'subtitle_vtt',
                'sign_language_video',
            ]);

            // Rename content → history_text
            $table->renameColumn('content', 'history_text');

            // Add new columns untuk video dan 3D
            $table->string('video_url')->nullable()->after('history_text');
            $table->string('glb_path')->nullable()->after('video_url');
            $table->string('glb_thumbnail')->nullable()->after('glb_path');
        });
    }

    public function down(): void
    {
        // Rollback: items → stories
        Schema::rename('items', 'stories');

        // Restore columns
        Schema::table('stories', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['video_url', 'glb_path', 'glb_thumbnail']);

            // Rename back history_text → content
            $table->renameColumn('history_text', 'content');

            // Restore old columns
            $table->text('synopsis')->nullable()->after('slug');
            $table->longText('sources')->nullable()->after('content');
            $table->unsignedInteger('duration_minutes')->nullable()->after('thumbnail');
            $table->string('audio_url')->nullable()->after('is_new');
            $table->string('subtitle_vtt')->nullable()->after('audio_url');
            $table->string('sign_language_video')->nullable()->after('subtitle_vtt');
        });

        // Recreate dropped tables
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories')->cascadeOnDelete();
            $table->string('type', 16);
            $table->string('title');
            $table->string('file_path');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('panorama_scenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('stories')->cascadeOnDelete();
            $table->string('title');
            $table->string('panorama_image');
            $table->float('initial_yaw')->default(0);
            $table->float('initial_pitch')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('panorama_hotspots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scene_id')->constrained('panorama_scenes')->cascadeOnDelete();
            $table->foreignId('target_scene_id')->nullable()->constrained('panorama_scenes')->nullOnDelete();
            $table->float('yaw');
            $table->float('pitch');
            $table->string('label')->nullable();
            $table->string('type', 32)->default('navigation');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }
};
