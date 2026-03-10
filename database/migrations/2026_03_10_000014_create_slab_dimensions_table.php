<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slab_dimensions', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('slab_id')->constrained('slabs', 'uuid')->cascadeOnDelete();
            $table->string('stage');
            $table->decimal('length_mm', 7, 2);
            $table->decimal('width_mm', 7, 2);
            $table->decimal('area_mm2', 12, 4)->storedAs('length_mm * width_mm');
            $table->decimal('thickness_mm', 5, 2)->nullable();
            $table->foreignId('measured_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('measured_at')->nullable();

            $table->unique(['slab_id', 'stage']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slab_dimensions');
    }
};
