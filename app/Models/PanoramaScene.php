<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PanoramaScene extends Model
{
    protected $fillable = [
        'story_id',
        'title',
        'panorama_image',
        'initial_yaw',
        'initial_pitch',
        'order',
    ];

    protected $casts = [
        'initial_yaw' => 'float',
        'initial_pitch' => 'float',
        'order' => 'integer',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function hotspots(): HasMany
    {
        return $this->hasMany(PanoramaHotspot::class, 'scene_id');
    }
}
