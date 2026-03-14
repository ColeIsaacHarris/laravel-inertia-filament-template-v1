<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hold_slabs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('hold_id')->constrained('holds')->cascadeOnDelete();
            $table->foreignUuid('slab_id')->constrained('slabs')->cascadeOnDelete();

            $table->unique(['hold_id', 'slab_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hold_slabs');
    }
};
