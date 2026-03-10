<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('number');
            $table->string('container_size')->nullable();
            $table->string('seal_number')->nullable();
            $table->string('vessel_name')->nullable();
            $table->string('voyage_number')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('port_of_discharge')->nullable();
            $table->foreignUuid('destination_location_id')->nullable()->constrained('locations', 'uuid')->nullOnDelete();
            $table->string('container_status')->default('booked');
            $table->string('customs_status')->nullable();
            $table->string('customs_number')->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->date('actual_arrival_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
