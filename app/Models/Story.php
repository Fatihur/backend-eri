<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Story extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'synopsis',
        'content',
        'sources',
        'thumbnail',
        'duration_minutes',
        'is_new',
        'audio_url',
        'subtitle_vtt',
        'sign_language_video',
        'published_at',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'duration_minutes' => 'integer',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scenes(): HasMany
    {
        return $this->hasMany(PanoramaScene::class)->orderBy('order');
    }
}
