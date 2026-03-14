<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('slabs', function (Blueprint $table) {
            $table->foreign('bundle_id')->references('id')->on('bundles')->nullOnDelete();
            $table->foreign('container_id')->references('id')->on('containers')->nullOnDelete();
            $table->foreign('material_id')->references('id')->on('materials')->nullOnDelete();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();

            $table->foreign('location_id', 'slabs_location_id_foreign')
                ->references('id')->on('locations')->nullOnDelete();

            $table->foreign('consignment_location_id', 'slabs_consignment_location_id_foreign')
                ->references('id')->on('locations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('slabs', function (Blueprint $table) {
            $table->dropForeign(['bundle_id']);
            $table->dropForeign(['container_id']);
            $table->dropForeign(['material_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign('slabs_location_id_foreign');
            $table->dropForeign('slabs_consignment_location_id_foreign');
        });
    }
};
