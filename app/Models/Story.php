<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Story extends Model
{
    protected $fillable = ['material_id', 'title'];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function scenes(): HasMany
    {
        return $this->hasMany(StoryScene::class)->orderBy('order');
    }
}
