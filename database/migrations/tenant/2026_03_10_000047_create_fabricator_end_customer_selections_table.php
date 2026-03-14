<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabricator_end_customer_selections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fabricator_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignUuid('portal_user_id')->constrained('portal_users')->cascadeOnDelete();
            $table->foreignUuid('slab_id')->constrained('slabs')->cascadeOnDelete();
            $table->string('project_name')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->unique(['fabricator_id', 'portal_user_id', 'slab_id'], 'fecs_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabricator_end_customer_selections');
    }
};
