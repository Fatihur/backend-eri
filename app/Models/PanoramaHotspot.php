<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PanoramaHotspot extends Model
{
    protected $fillable = [
        'scene_id',
        'target_scene_id',
        'yaw',
        'pitch',
        'label',
        'type',
    ];

    protected $casts = [
        'yaw' => 'float',
        'pitch' => 'float',
    ];

    public function scene(): BelongsTo
    {
        return $this->belongsTo(PanoramaScene::class, 'scene_id');
    }

    public function targetScene(): BelongsTo
    {
        return $this->belongsTo(PanoramaScene::class, 'target_scene_id');
    }
}
