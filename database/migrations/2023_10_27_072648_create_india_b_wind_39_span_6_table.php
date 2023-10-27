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
        Schema::create('india_b_wind_39_span_6', function (Blueprint $table) {
            $table->bigIncrements('id')->length(4);
            $table->integer('height')->length(3);
            $table->integer('span')->length(3);
            $table->float('main_frame')->length(4,2);
            $table->float('fm_roofing_purlin')->length(4,2);
            $table->integer('fm_total_side_wall_girt')->length(4);
            $table->integer('fm_total_gable_end_girt')->length(4);
            $table->integer('fm_total_roofing_sheet')->length(4);
            $table->integer('fm_total_clading_sheet')->length(4);
            $table->integer('fm_sag_rod')->length(4);
            $table->integer('fm_stay_brace')->length(4);
            $table->integer('fm_anchor_bolt')->length(4);
            $table->integer('fm_cleat_for_purlin_and_girt')->length(4);
            $table->integer('fm_x_bracing')->length(4);
            $table->integer('fm_tie_strut')->length(4);
            $table->integer('fm_finishing')->length(4);
            $table->integer('fm_gantry_girder')->length(4);
            $table->integer('fc_roofing_purlin')->length(4);
            $table->integer('fc_total_side_wall_girt')->length(4);
            $table->integer('fc_total_gable_end_girt')->length(4);
            $table->integer('fc_total_roofing_sheet')->length(4);
            $table->integer('fc_total_clading_sheet')->length(4);
            $table->integer('fc_sag_rod')->length(4);
            $table->integer('fc_stay_brace')->length(4);
            $table->integer('fc_anchor_bolt')->length(4);
            $table->integer('fc_cleat_for_purlin_and_girt')->length(4);
            $table->integer('fc_x_bracing')->length(4);
            $table->integer('fc_tie_strut')->length(4);
            $table->integer('fc_finishing')->length(4);
            $table->integer('fc_gantry_girder')->length(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('india_b_wind_39_span_6');
    }
};
