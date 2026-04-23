<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reflection extends Model
{
    protected $fillable = ['material_id', 'question', 'type'];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(ReflectionOption::class);
    }
}
