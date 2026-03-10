<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_requests', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('order_id')->constrained('sales_orders', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->restrictOnDelete();
            $table->foreignUuid('portal_user_id')->nullable()->constrained('portal_users', 'uuid')->nullOnDelete();
            $table->date('requested_date');
            $table->string('requested_window')->nullable();
            $table->foreignUuid('delivery_address_id')->nullable()->constrained('addresses', 'uuid')->nullOnDelete();
            $table->text('access_instructions')->nullable();
            $table->string('status')->default('requested');
            $table->date('confirmed_date')->nullable();
            $table->string('confirmed_window')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_requests');
    }
};
