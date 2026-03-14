<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('bundle_number');
            $table->foreignUuid('material_id')->constrained('materials')->restrictOnDelete();
            $table->foreignUuid('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->integer('expected_slab_count')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('bundle_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
