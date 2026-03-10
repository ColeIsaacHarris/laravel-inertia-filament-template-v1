<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_users', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('contact_id')->nullable()->constrained('contacts', 'uuid')->nullOnDelete();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->cascadeOnDelete();
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->string('role');
            $table->foreignUuid('fabricator_id')->nullable()->constrained('customers', 'uuid')->nullOnDelete();
            $table->boolean('two_factor_enabled')->default(false);
            $table->text('two_factor_secret')->nullable();
            $table->json('permissions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_users');
    }
};
