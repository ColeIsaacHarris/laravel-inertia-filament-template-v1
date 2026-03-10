<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hold_requests', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->restrictOnDelete();
            $table->foreignUuid('portal_user_id')->nullable()->constrained('portal_users', 'uuid')->nullOnDelete();
            $table->foreignUuid('hold_id')->nullable()->constrained('holds', 'uuid')->nullOnDelete();
            $table->string('project_name')->nullable();
            $table->text('notes')->nullable();
            $table->string('requested_hold_type')->nullable();
            $table->string('status')->default('pending_review');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('review_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hold_requests');
    }
};
