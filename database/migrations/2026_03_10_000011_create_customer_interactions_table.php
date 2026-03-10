<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_interactions', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('contact_id')->nullable()->constrained('contacts', 'uuid')->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('interaction_type');
            $table->string('subject')->nullable();
            $table->text('notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_interactions');
    }
};
