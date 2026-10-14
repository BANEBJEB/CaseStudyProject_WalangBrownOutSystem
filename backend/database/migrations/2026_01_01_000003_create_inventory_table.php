<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('batch_number', 50);
            $table->date('manufacturing_date');
            $table->date('expiry_date')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0);
            $table->string('warehouse_location', 50);
            $table->date('received_date');
            $table->date('last_physical_count')->nullable();
            $table->enum('status', ['AVAILABLE', 'RESERVED', 'EXPIRED', 'DAMAGED', 'SOLD'])->default('AVAILABLE');
            $table->timestamps();

            $table->index(['product_id', 'batch_number']);
            $table->index('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};