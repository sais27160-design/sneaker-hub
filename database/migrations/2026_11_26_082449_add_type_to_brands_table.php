<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('brands', 'type')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->string('type')->default('Other');
            });
        }
    }

    public function down(): void
    {
        // Keep the column.
    }
};