<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealTranslation extends Model
{
    protected $fillable = [
        'deal_id',
        'locale',
        'title',
        'description',
    ];

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }
}
