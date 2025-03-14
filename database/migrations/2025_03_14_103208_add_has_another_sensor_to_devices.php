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
        Schema::table('devices', function (Blueprint $table) {
            $table->boolean('has_temperature')->default(false);
            $table->boolean('has_humidity')->default(false);
            $table->boolean('has_wind_direction')->default(false);
            $table->boolean('has_wind_speed')->default(false);
            $table->boolean('has_solar_radiation')->default(false);
            $table->boolean('has_evaporation')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            //
            $table->dropColumn('has_temperature');
            $table->dropColumn('has_humidity');
            $table->dropColumn('has_wind_direction');
            $table->dropColumn('has_wind_speed');
            $table->dropColumn('has_solar_radiation');
            $table->dropColumn('has_evaporation');
        });
    }
};
