<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_read_receipts', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('message_id')->constrained('messages', 'uuid')->cascadeOnDelete();
            $table->foreignId('reader_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('reader_portal_user_id')->nullable()->constrained('portal_users', 'uuid')->nullOnDelete();
            $table->timestamp('read_at')->nullable();

            $table->unique(['message_id', 'reader_user_id'], 'mrr_message_user_unique');
            $table->unique(['message_id', 'reader_portal_user_id'], 'mrr_message_portal_user_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_read_receipts');
    }
};
