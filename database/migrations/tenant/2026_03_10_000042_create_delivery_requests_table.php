<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignUuid('portal_user_id')->nullable()->constrained('portal_users')->nullOnDelete();
            $table->date('requested_date');
            $table->string('requested_window')->nullable();
            $table->foreignUuid('delivery_address_id')->nullable()->constrained('addresses')->nullOnDelete();
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
