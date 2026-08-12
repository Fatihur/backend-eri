<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'history_text',
        'video_url',
        'glb_path',
        'glb_thumbnail',
        'is_new',
        'published_at',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Item $item) {
            if (empty($item->slug)) {
                $baseSlug = Str::slug($item->title);
                $slug = $baseSlug;
                $i = 1;

                while (static::where('slug', $slug)->where('id', '!=', $item->id ?? 0)->exists()) {
                    $slug = $baseSlug . '-' . $i;
                    $i++;
                }

                $item->slug = $slug;
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
