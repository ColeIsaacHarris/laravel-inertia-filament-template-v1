<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('material_name');
            $table->string('material_type');
            $table->string('color_family')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['material_name', 'material_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
