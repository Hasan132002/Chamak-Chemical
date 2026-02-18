<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPricing extends Model
{
    protected $table = 'product_pricing';

    protected $fillable = [
        'product_id',
        'retail_price',
        'wholesale_price',
        'sale_price',
        'sale_start_date',
        'sale_end_date',
        'cost_price',
    ];

    protected $casts = [
        'retail_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'sale_start_date' => 'date',
        'sale_end_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getCurrentPrice(): float
    {
        if ($this->sale_price && $this->isSaleActive()) {
            return $this->sale_price;
        }
        return $this->retail_price;
    }

    public function isSaleActive(): bool
    {
        if (!$this->sale_price) {
            return false;
        }

        $now = now();
        $startValid = !$this->sale_start_date || $now->gte($this->sale_start_date);
        $endValid = !$this->sale_end_date || $now->lte($this->sale_end_date);

        return $startValid && $endValid;
    }
}
