<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reorder_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('min_stock');
            $table->integer('max_stock');
            $table->integer('reorder_point');
            $table->decimal('seasonal_multiplier', 3, 2)->default(1.00);
            $table->integer('lead_time_days')->default(7);
            $table->date('last_review_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reorder_points');
    }
};