<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('supplier_id')->constrained('suppliers', 'uuid')->restrictOnDelete();
            $table->foreignUuid('purchase_order_id')->nullable()->constrained('purchase_orders', 'uuid')->nullOnDelete();
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->bigInteger('amount_cents');
            $table->string('currency')->default('USD');
            $table->string('status')->default('pending');
            $table->string('expense_category')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_invoices');
    }
};
