<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sku',
        'slug',
        'category_id',
        'brand',
        'featured_image',
        'gallery_images',
        'weight',
        'dimensions',
        'is_active',
        'is_featured',
        'stock_quantity',
        'moq',
        'low_stock_threshold',
        'allow_backorder',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'dimensions' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'allow_backorder' => 'boolean',
        'weight' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function pricing(): HasOne
    {
        return $this->hasOne(ProductPricing::class);
    }

    public function wholesalePricing(): HasMany
    {
        return $this->hasMany(WholesalePricing::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryLogs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function translate($locale = 'en')
    {
        return $this->translations()->where('locale', $locale)->first()
            ?? $this->translations()->where('locale', 'en')->first();
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }
}
