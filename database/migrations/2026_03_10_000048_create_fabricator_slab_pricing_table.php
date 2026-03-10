<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabricator_slab_pricing', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('fabricator_id')->constrained('customers', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('slab_id')->nullable()->constrained('slabs', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('material_id')->nullable()->constrained('materials', 'uuid')->cascadeOnDelete();
            $table->decimal('markup_percentage', 5, 2)->nullable();
            $table->bigInteger('retail_price_cents')->nullable();
            $table->timestamps();

            $table->unique(['fabricator_id', 'slab_id'], 'fsp_fabricator_slab_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabricator_slab_pricing');
    }
};
