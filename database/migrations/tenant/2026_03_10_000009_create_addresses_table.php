<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('label')->nullable();
            $table->string('address_type');
            $table->string('street_line_1');
            $table->string('street_line_2')->nullable();
            $table->string('city');
            $table->string('state_province')->nullable();
            $table->string('postal_code')->nullable();
            $table->char('country', 2);
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignUuid('supplier_id')->nullable()->constrained('suppliers')->cascadeOnDelete();
            $table->foreignUuid('location_id')->nullable()->constrained('locations')->cascadeOnDelete();
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index('customer_id');
            $table->index('supplier_id');
            $table->index('location_id');
        });

        // Only add CHECK constraint on databases that support it post-creation
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE addresses ADD CONSTRAINT addresses_single_owner CHECK (num_nonnulls(customer_id, supplier_id, location_id) = 1)');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE addresses DROP CONSTRAINT addresses_single_owner');
        }

        Schema::dropIfExists('addresses');
    }
};
