<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_attachments', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('message_id')->constrained('messages', 'uuid')->cascadeOnDelete();
            $table->string('attachment_type');
            $table->string('file_path', 1024);
            $table->string('original_filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size_bytes')->nullable();
            $table->string('entity_ref_type')->nullable();
            $table->uuid('entity_ref_id')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_attachments');
    }
};
