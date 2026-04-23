<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = ['name', 'description', 'icon', 'color', 'order'];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'class_id');
    }
}
