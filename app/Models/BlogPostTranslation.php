<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPostTranslation extends Model
{
    protected $fillable = [
        'blog_post_id',
        'locale',
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }
}
