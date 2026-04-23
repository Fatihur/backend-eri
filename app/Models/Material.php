<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Material extends Model
{
    protected $fillable = ['category_id', 'title', 'description', 'history', 'thumbnail'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function story(): HasOne
    {
        return $this->hasOne(Story::class);
    }

    public function videos360(): HasMany
    {
        return $this->hasMany(Video360::class);
    }

    public function reflections(): HasMany
    {
        return $this->hasMany(Reflection::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class)->orderBy('order');
    }
}
