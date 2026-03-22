<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('quote_number')->unique();
            $table->foreignUuid('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('sales_rep_id')->constrained('users')->restrictOnDelete();
            $table->string('status')->default('draft');
            $table->date('expiry_date')->nullable();
            $table->bigInteger('subtotal_cents')->default(0);
            $table->bigInteger('tax_cents')->default(0);
            $table->bigInteger('delivery_cents')->default(0);
            $table->bigInteger('total_cents')->default(0);
            $table->string('payment_terms')->nullable();
            $table->text('notes')->nullable();
            $table->text('terms_text')->nullable();
            $table->uuid('previous_version_id')->nullable();
            $table->timestamps();
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->foreign('previous_version_id')->references('id')->on('quotes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
