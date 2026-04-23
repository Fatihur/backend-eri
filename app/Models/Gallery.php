<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = ['material_id', 'image_path', 'caption', 'order'];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
