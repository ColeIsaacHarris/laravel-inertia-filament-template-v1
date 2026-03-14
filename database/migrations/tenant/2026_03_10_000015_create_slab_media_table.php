<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slab_media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('slab_id')->constrained('slabs')->cascadeOnDelete();
            $table->string('media_type');
            $table->string('file_path', 1024);
            $table->string('original_filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size_bytes')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slab_media');
    }
};
