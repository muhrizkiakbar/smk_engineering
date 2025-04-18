<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('device_locations_warnings', function (Blueprint $table) {
            //
            $table->dropColumn('upper_threshold');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('bottom_threshold');  // Gantilah column_name dengan nama kolom yang ingin dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_locations_warnings', function (Blueprint $table) {
            //
            $table->float('upper_threshold')->default(0);
            $table->float('bottom_threshold')->default(0);
        });
    }
};
