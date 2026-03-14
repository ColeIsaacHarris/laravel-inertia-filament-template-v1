<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('scope');
            $table->integer('priority');
            $table->string('pricing_model')->default('per_sqft');
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->string('customer_tier')->nullable();
            $table->foreignUuid('material_id')->nullable()->constrained('materials')->cascadeOnDelete();
            $table->bigInteger('price_cents');
            $table->integer('min_quantity')->nullable();
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_rules');
    }
};
