<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('movement_type');
            $table->foreignUuid('slab_id')->nullable()->constrained('slabs')->nullOnDelete();
            $table->uuid('from_location_id')->nullable();
            $table->uuid('to_location_id')->nullable();
            $table->string('from_bin')->nullable();
            $table->string('to_bin')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reference_type')->nullable();
            $table->uuid('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('from_location_id', 'inv_mov_from_location_fk')
                ->references('id')->on('locations')->nullOnDelete();

            $table->foreign('to_location_id', 'inv_mov_to_location_fk')
                ->references('id')->on('locations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
