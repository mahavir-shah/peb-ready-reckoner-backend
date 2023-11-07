<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_estimantion', function (Blueprint $table) {
            $table->float('tie_strut_m2')->length(4,2)->after('x_bracing_kg')->nullable();
            $table->double('tie_strut_kg')->after('tie_strut_m2')->nullable();
            $table->float('gantry_girder_m2')->length(4,2)->after('tie_strut_kg')->default(0);
            $table->double('gantry_girder_kg')->after('gantry_girder_m2')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_estimantion', function (Blueprint $table) {
            //
        });
    }
};
