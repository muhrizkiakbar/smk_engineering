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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->dateTime('bought_at')->nullable();
            $table->dateTime('used_at')->nullable();
            $table->dateTime('damaged_at')->nullable();
            $table->string('phone_number')->unique();
            $table->boolean('has_ph')->default(false);
            $table->boolean('has_tds')->default(false);
            $table->boolean('has_tss')->default(false);
            $table->boolean('has_velocity')->default(false);
            $table->boolean('has_rainfall')->default(false);
            $table->boolean('has_water_height')->default(false);
            $table->string('state')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
