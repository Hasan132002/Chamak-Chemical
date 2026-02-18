<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogCategoryTranslation extends Model
{
    protected $fillable = [
        'blog_category_id',
        'locale',
        'name',
        'description',
    ];

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
