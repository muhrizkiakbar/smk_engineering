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
            $table->float('low_upper_threshold_start')->default(0);
            $table->float('low_upper_threshold_end')->default(0);
            $table->float('middle_upper_threshold_start')->default(0);
            $table->float('middle_upper_threshold_end')->default(0);
            $table->float('high_upper_threshold_start')->default(0);
            $table->float('high_upper_threshold_end')->default(0);

            $table->float('low_bottom_threshold_start')->default(0);
            $table->float('low_bottom_threshold_end')->default(0);
            $table->float('middle_bottom_threshold_start')->default(0);
            $table->float('middle_bottom_threshold_end')->default(0);
            $table->float('high_bottom_threshold_start')->default(0);
            $table->float('high_bottom_threshold_end')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_locations_warnings', function (Blueprint $table) {
            //
            $table->dropColumn('low_upper_threshold_start');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('low_upper_threshold_end');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('middle_upper_threshold_start');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('middle_upper_threshold_end');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('high_upper_threshold_start');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('high_upper_threshold_end');  // Gantilah column_name dengan nama kolom yang ingin dihapus

            $table->dropColumn('low_bottom_threshold_start');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('low_bottom_threshold_end');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('middle_bottom_threshold_start');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('middle_bottom_threshold_end');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('high_bottom_threshold_start');  // Gantilah column_name dengan nama kolom yang ingin dihapus
            $table->dropColumn('high_bottom_threshold_end');  // Gantilah column_name dengan nama kolom yang ingin dihapus
        });
    }
};
