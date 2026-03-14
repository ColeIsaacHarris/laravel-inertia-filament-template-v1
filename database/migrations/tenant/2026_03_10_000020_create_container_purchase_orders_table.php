<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('container_purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('container_id')->constrained('containers')->cascadeOnDelete();
            $table->foreignUuid('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->string('notes')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->unique(['container_id', 'purchase_order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('container_purchase_orders');
    }
};
