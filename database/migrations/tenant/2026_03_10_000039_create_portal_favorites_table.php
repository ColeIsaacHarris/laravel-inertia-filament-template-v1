<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_favorites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('portal_user_id')->constrained('portal_users')->cascadeOnDelete();
            $table->foreignUuid('slab_id')->constrained('slabs')->cascadeOnDelete();
            $table->timestamp('created_at')->nullable();

            $table->unique(['portal_user_id', 'slab_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_favorites');
    }
};
