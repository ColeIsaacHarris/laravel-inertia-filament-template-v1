<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_invitations', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->cascadeOnDelete();
            $table->foreignId('invited_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('invited_by_portal_user_id')->nullable()->constrained('portal_users', 'uuid')->nullOnDelete();
            $table->string('email');
            $table->string('role');
            $table->string('status')->default('pending');
            $table->string('token')->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_invitations');
    }
};
