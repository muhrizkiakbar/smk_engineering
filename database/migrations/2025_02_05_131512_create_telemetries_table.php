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
        Schema::create('telemetries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_location_id')->constrained('device_locations');
            $table->float('ph')->default(0);
            $table->float('tds')->default(0);
            $table->float('tss')->default(0);
            $table->float('debit')->default(0);
            $table->float('water_height')->default(0);
            $table->float('rainfall')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telemetries');
    }
};
