<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'features',
        'price',
        'stock',
        'type',
        'is_active',
        'is_on_sale',
        'compare_at_price',
        'cod_enabled',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_on_sale' => 'boolean',
        'cod_enabled' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function specAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class)->orderBy('sort_order');
    }

    public function hasStrikethroughPrice(): bool
    {
        if (! $this->is_on_sale || $this->compare_at_price === null) {
            return false;
        }

        return (float) $this->compare_at_price > (float) $this->price;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->reviews()->approved()->latest();
    }

    public function latestApprovedReview(): HasOne
    {
        return $this->hasOne(ProductReview::class)->ofMany(
            ['created_at' => 'max'],
            function ($query) {
                $query->where('is_approved', true);
            }
        );
    }

    public function primaryImage(): ?ProductImage
    {
        $primary = $this->images->firstWhere('is_primary', true);

        return $primary ?? $this->images->first();
    }
}
