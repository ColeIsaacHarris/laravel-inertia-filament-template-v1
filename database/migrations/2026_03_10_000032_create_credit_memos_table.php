<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_memos', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('credit_memo_number')->unique();
            $table->foreignUuid('customer_id')->constrained('customers', 'uuid')->restrictOnDelete();
            $table->foreignUuid('invoice_id')->nullable()->constrained('invoices', 'uuid')->nullOnDelete();
            $table->bigInteger('amount_cents');
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_memos');
    }
};
