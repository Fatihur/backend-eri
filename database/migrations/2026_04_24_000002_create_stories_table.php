<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('synopsis')->nullable();
            $table->longText('content')->nullable();
            $table->longText('sources')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->boolean('is_new')->default(false);
            $table->string('audio_url')->nullable();
            $table->string('subtitle_vtt')->nullable();
            $table->string('sign_language_video')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
