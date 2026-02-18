<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dealer extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_license',
        'tax_id',
        'address',
        'city',
        'state',
        'postal_code',
        'approval_status',
        'approved_by',
        'approved_at',
        'dealer_tier',
        'credit_limit',
        'payment_terms',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'credit_limit' => 'decimal:2',
        'payment_terms' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }
}
