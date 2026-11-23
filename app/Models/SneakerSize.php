<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SneakerSize extends Model
{
    protected $fillable = [
        'sneaker_id',
        'size',
        'stock_quantity',
    ];

    public function sneaker(): BelongsTo
    {
        return $this->belongsTo(Sneaker::class);
    }
}