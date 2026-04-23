<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video360 extends Model
{
    protected $table = 'videos_360';

    protected $fillable = ['material_id', 'title', 'file_path', 'thumbnail'];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
