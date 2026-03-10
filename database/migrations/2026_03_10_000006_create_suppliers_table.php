<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('company_name');
            $table->string('trade_name')->nullable();
            $table->char('country', 2)->nullable();
            $table->string('default_payment_terms')->nullable();
            $table->string('default_currency')->nullable();
            $table->string('tax_id')->nullable();
            $table->json('bank_details_encrypted')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
