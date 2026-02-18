<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    protected $fillable = [
        'subject_en',
        'subject_ur',
        'body_en',
        'body_ur',
        'sent_at',
        'sent_count',
        'open_count',
        'click_count',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'sent_count' => 'integer',
        'open_count' => 'integer',
        'click_count' => 'integer',
    ];
}
