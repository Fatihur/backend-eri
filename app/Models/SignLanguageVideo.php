<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignLanguageVideo extends Model
{
    protected $fillable = ['story_scene_id', 'file_path'];

    public function storyScene(): BelongsTo
    {
        return $this->belongsTo(StoryScene::class);
    }
}
