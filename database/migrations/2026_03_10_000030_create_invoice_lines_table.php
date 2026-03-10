<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('invoice_id')->constrained('invoices', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('slab_id')->nullable()->constrained('slabs', 'uuid')->nullOnDelete();
            $table->foreignUuid('product_id')->nullable()->constrained('products', 'uuid')->nullOnDelete();
            $table->string('description')->nullable();
            $table->decimal('quantity', 10, 2)->default(1);
            $table->bigInteger('unit_price_cents');
            $table->bigInteger('amount_cents');
            $table->bigInteger('tax_cents')->default(0);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_lines');
    }
};
