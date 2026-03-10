<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('invoice_id')->constrained('invoices', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->restrictOnDelete();
            $table->bigInteger('amount_cents');
            $table->string('payment_method');
            $table->string('reference_number')->nullable();
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
