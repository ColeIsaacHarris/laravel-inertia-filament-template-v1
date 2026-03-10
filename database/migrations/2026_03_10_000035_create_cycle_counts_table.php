<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cycle_counts', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('location_id')->constrained('locations', 'uuid')->restrictOnDelete();
            $table->string('count_type');
            $table->string('status')->default('in_progress');
            $table->foreignId('initiated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cycle_counts');
    }
};
