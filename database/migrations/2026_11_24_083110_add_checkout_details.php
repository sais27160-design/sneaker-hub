<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('phone')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_country')->nullable();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('size', 4, 1)->nullable()->after('sneaker_id');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('size');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_email',
                'phone',
                'shipping_address',
                'shipping_city',
                'shipping_postal_code',
                'shipping_country',
            ]);
        });
    }
};
