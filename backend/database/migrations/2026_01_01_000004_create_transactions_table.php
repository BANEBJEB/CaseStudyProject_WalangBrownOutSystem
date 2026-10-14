<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('inventory_id')->constrained('inventory');
            $table->enum('transaction_type', ['RECEIVED', 'SOLD', 'RESERVED', 'RETURNED', 'ADJUSTED', 'EXPIRED', 'DAMAGED']);
            $table->integer('quantity');
            $table->string('reference_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->string('performed_by', 100);
            $table->timestamps();

            $table->index('created_at');
            $table->index('transaction_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};