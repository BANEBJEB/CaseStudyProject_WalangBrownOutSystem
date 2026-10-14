<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('product_name', 200);
            $table->enum('category', ['AC_UNIT', 'AIR_PURIFIER', 'FILTER', 'THERMOSTAT']);
            $table->string('sub_category', 100)->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('weight_kg', 8, 2)->nullable();
            $table->integer('shelf_life_months')->nullable();
            $table->enum('seasonality', ['SUMMER', 'WINTER', 'YEAR_ROUND'])->default('YEAR_ROUND');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};