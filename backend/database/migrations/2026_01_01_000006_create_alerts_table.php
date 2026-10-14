<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('alert_type', ['LOW_STOCK', 'EXPIRY', 'DISCREPANCY', 'OVERSTOCK', 'FIFO_WARNING']);
            $table->enum('severity', ['INFO', 'WARNING', 'CRITICAL']);
            $table->text('message');
            $table->text('recommended_action')->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->string('resolved_by', 100)->nullable();
            $table->timestamps();

            $table->index(['is_resolved', 'severity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};