<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_threads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('thread_type')->default('general_inquiry');
            $table->foreignUuid('customer_id')->constrained('customers')->restrictOnDelete();
            $table->string('subject');
            $table->string('entity_type')->nullable();
            $table->uuid('entity_id')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_closed')->default(false);
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_threads');
    }
};
