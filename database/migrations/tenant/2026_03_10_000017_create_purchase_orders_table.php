<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('po_number')->unique();
            $table->foreignUuid('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->string('status')->default('draft');
            $table->string('currency')->default('USD');
            $table->string('payment_terms')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('expected_container_size')->nullable();
            $table->bigInteger('fob_cost_total_cents')->nullable();
            $table->bigInteger('freight_cost_total_cents')->nullable();
            $table->bigInteger('duty_cost_total_cents')->nullable();
            $table->bigInteger('insurance_cost_total_cents')->nullable();
            $table->bigInteger('other_cost_total_cents')->nullable();
            $table->text('notes')->nullable();
            $table->text('supplier_instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
