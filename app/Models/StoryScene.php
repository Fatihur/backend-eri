<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StoryScene extends Model
{
    protected $fillable = ['story_id', 'order', 'text', 'image'];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function signLanguageVideo(): HasOne
    {
        return $this->hasOne(SignLanguageVideo::class);
    }
}
