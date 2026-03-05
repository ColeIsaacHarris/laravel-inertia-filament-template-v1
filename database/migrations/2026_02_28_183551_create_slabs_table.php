<?php

use App\Enums\SlabStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slabs', function (Blueprint $table) {
            $table->uuid()->primary();

            // Relationships
            $table->foreignUuid('bundle_id')->nullable();
            $table->integer('bundle_position')->nullable();
            $table->foreignUuid('container_id')->nullable();
            $table->foreignUuid('material_id')->nullable();
            $table->foreignUuid('supplier_id')->nullable();
            $table->foreignUuid('location_id')->nullable();
            $table->string('bin_slot', 50)->nullable();
            $table->foreignUuid('consignment_location_id')->nullable();

            // Identification
            $table->string('barcode')->nullable()->unique();

            // Attributes
            $table->string('finish'); /* references SlabFinish enum */
            $table->string('quality_grade'); /* references QualityGrade enum */
            $table->char('origin_country_code', 2)->nullable(); /* iso 3166 alpha-2 */
            $table->string('quarry_name')->nullable();
            $table->string('status')->default(SlabStatus::IN_TRANSIT->value);

            // Financial — all in cents
            $table->bigInteger('fob_cost_cents')->default(0);
            $table->bigInteger('freight_cost_cents')->default(0);
            $table->bigInteger('duty_cost_cents')->default(0);
            $table->bigInteger('other_cost_cents')->default(0);
            $table->bigInteger('landed_cost_cents')->storedAs('fob_cost_cents + freight_cost_cents + duty_cost_cents + other_cost_cents');
            $table->bigInteger('list_price_cents')->nullable();
            $table->bigInteger('minimum_price_cents')->nullable();

            // Portal
            $table->boolean('portal_visible')->default(false);

            // Metadata
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('material_id');
            $table->index('status');
            $table->index('location_id');
            $table->index('bundle_id');
            $table->index('portal_visible');
            $table->unique(['bundle_id', 'bundle_position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slabs');
    }
};
