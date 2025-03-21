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
        Schema::table('real_telemetries', function (Blueprint $table) {
            $table->float('dissolve_oxygen')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('real_telemetries', function (Blueprint $table) {
            $table->dropColumn('dissolve_oxygen');
        });
    }
};
