<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
