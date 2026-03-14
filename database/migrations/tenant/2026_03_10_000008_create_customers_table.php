<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('company_name');
            $table->string('customer_type');
            $table->string('tier')->default('standard');
            $table->boolean('tax_exempt')->default(false);
            $table->string('tax_id')->nullable();
            $table->string('payment_terms')->nullable();
            $table->bigInteger('credit_limit_cents')->default(0);
            $table->uuid('price_level_id')->nullable();
            $table->foreignId('sales_rep_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('referral_source')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
