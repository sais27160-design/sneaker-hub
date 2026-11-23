<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sneaker extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'model',
        'price',
        'stock_quantity',
        'description',
        'image',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function sizes()
    {
        return $this->hasMany(SneakerSize::class);
    }
}
