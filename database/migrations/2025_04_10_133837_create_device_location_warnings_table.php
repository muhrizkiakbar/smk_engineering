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
        Schema::create('device_locations_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_location_id')->constrained('device_locations');
            $table->enum('type', ['ph', 'tds', 'tss', 'rainfall', 'water_height', 'temperature', 'humidity', 'wind_direction', 'wind_speed', 'solar_radiation', 'evaporation', 'dissolve_oxygen', 'debit']);
            $table->float('upper_threshold')->default(0);
            $table->float('bottom_threshold')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_locations_warnings');
    }
};
