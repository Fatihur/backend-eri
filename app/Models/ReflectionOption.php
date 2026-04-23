<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReflectionOption extends Model
{
    protected $fillable = ['reflection_id', 'label', 'image'];

    public function reflection(): BelongsTo
    {
        return $this->belongsTo(Reflection::class);
    }
}
