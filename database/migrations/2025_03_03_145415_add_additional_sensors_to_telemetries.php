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
        Schema::table('telemetries', function (Blueprint $table) {
            $table->float('temperature')->default(0);
            $table->float('humidity')->default(0);
            $table->float('wind_direction')->default(0);
            $table->float('wind_speed')->default(0);
            $table->float('solar_radiation')->default(0);
            $table->float('evaporation')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telemetries', function (Blueprint $table) {
            $table->dropColumn('temperature');
            $table->dropColumn('humidity');
            $table->dropColumn('wind_direction');
            $table->dropColumn('wind_speed');
            $table->dropColumn('solar_radiation');
            $table->dropColumn('evaporation');
        });
    }
};
