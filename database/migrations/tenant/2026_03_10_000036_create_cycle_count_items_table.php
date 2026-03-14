<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cycle_count_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cycle_count_id')->constrained('cycle_counts')->cascadeOnDelete();
            $table->foreignUuid('slab_id')->constrained('slabs')->restrictOnDelete();
            $table->uuid('expected_location_id')->nullable();
            $table->uuid('actual_location_id')->nullable();
            $table->string('expected_bin')->nullable();
            $table->string('actual_bin')->nullable();
            $table->boolean('is_discrepancy')->default(false);
            $table->text('resolution_notes')->nullable();
            $table->foreignId('adjustment_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->nullable();

            $table->foreign('expected_location_id', 'cci_expected_location_fk')
                ->references('id')->on('locations')->nullOnDelete();

            $table->foreign('actual_location_id', 'cci_actual_location_fk')
                ->references('id')->on('locations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cycle_count_items');
    }
};
