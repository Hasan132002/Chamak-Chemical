<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WholesalePricing extends Model
{
    protected $table = 'wholesale_pricing';

    protected $fillable = [
        'product_id',
        'dealer_tier',
        'min_quantity',
        'unit_price',
    ];

    protected $casts = [
        'min_quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
