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
            $table->boolean('gantry_girder_in_all_days');
            $table->boolean('no_gable_on_both_side');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_estimantion', function (Blueprint $table) {
            $table->dropColumn('gantry_girder_in_all_days');
            $table->dropColumn('no_gable_on_both_side');
        });
    }
};
