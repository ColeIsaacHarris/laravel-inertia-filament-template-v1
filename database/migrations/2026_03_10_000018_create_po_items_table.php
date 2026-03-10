<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('po_items', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('purchase_order_id')->constrained('purchase_orders', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('material_id')->constrained('materials', 'uuid')->restrictOnDelete();
            $table->string('description')->nullable();
            $table->integer('quantity');
            $table->string('unit')->default('slab');
            $table->bigInteger('unit_price_cents');
            $table->bigInteger('line_total_cents');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('po_items');
    }
};
