<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('order_number')->unique();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->restrictOnDelete();
            $table->foreignId('sales_rep_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('draft');
            $table->foreignUuid('ship_to_address_id')->nullable()->constrained('addresses', 'uuid')->nullOnDelete();
            $table->foreignUuid('bill_to_address_id')->nullable()->constrained('addresses', 'uuid')->nullOnDelete();
            $table->string('payment_terms')->nullable();
            $table->bigInteger('subtotal_cents')->default(0);
            $table->bigInteger('discount_cents')->default(0);
            $table->bigInteger('tax_cents')->default(0);
            $table->bigInteger('delivery_cents')->default(0);
            $table->bigInteger('total_cents')->default(0);
            $table->date('requested_delivery_date')->nullable();
            $table->string('delivery_method')->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->foreignUuid('hold_id')->nullable()->constrained('holds', 'uuid')->nullOnDelete();
            $table->foreignUuid('quote_id')->nullable()->constrained('quotes', 'uuid')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
