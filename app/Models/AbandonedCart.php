<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbandonedCart extends Model
{
    protected $fillable = [
        'user_id',
        'cart_id',
        'email_sent_at',
        'recovered_at',
    ];

    protected $casts = [
        'email_sent_at' => 'datetime',
        'recovered_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
