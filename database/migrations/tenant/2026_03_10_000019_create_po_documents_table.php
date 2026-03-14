<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('po_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->string('document_type');
            $table->string('file_path', 1024);
            $table->string('original_filename')->nullable();
            $table->timestamp('uploaded_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('po_documents');
    }
};
