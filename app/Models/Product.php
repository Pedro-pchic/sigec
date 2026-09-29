<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['category_id', 'sku', 'name', 'description', 'price', 'is_active'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function purchaseDetails(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function quoteDetails(): HasMany
    {
        return $this->hasMany(QuoteDetail::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function isAvailable(): bool
    {
        return ($this->inventory?->stock ?? 0) > 0;
    }

    public function isPurchasable(): bool
    {
        return $this->is_active
            && ($this->category?->is_active ?? false)
            && $this->isAvailable();
    }

    public function availabilityLabel(): string
    {
        if (! $this->isAvailable()) {
            return 'Agotado';
        }

        if (
            $this->inventory->minimum_stock > 0
            && $this->inventory->stock <= $this->inventory->minimum_stock
        ) {
            return 'Stock bajo';
        }

        return 'Disponible';
    }
}
