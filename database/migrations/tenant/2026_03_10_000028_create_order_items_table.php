<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignUuid('slab_id')->nullable()->constrained('slabs')->nullOnDelete();
            $table->foreignUuid('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('description')->nullable();
            $table->decimal('quantity', 10, 2)->default(1);
            $table->bigInteger('list_price_cents');
            $table->bigInteger('discount_cents')->default(0);
            $table->bigInteger('net_price_cents');
            $table->bigInteger('line_total_cents');
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
