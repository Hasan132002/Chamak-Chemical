<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deal extends Model
{
    protected $fillable = [
        'image',
        'url',
        'is_active',
        'sort_order',
        'starts_at',
        'ends_at',
        'discount_percentage',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'discount_percentage' => 'decimal:2',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(DealTranslation::class);
    }

    public function translate($locale = 'en')
    {
        return $this->translations()->where('locale', $locale)->first()
            ?? $this->translations()->where('locale', 'en')->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }
}
