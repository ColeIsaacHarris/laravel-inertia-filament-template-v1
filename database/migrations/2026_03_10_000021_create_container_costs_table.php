<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('container_costs', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('container_id')->constrained('containers', 'uuid')->cascadeOnDelete();
            $table->string('cost_type');
            $table->bigInteger('amount_cents');
            $table->string('allocation_method')->default('by_sqft');
            $table->string('notes')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('container_costs');
    }
};
