<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sneaker_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sneaker_id')->constrained('sneakers')->cascadeOnDelete();
            $table->decimal('size', 4, 1);
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->timestamps();
            $table->unique(['sneaker_id', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sneaker_sizes');
    }
};
