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
            $table->float('main_frame_steel_m2')->length(4,2)->nullable();
            $table->double('main_frame_steel_kg')->nullable();
            $table->float('top_purlin_m2')->length(4,2)->nullable();
            $table->double('top_purlin_kg')->nullable();
            $table->float('side_wall_girt_m2')->length(4,2)->nullable();
            $table->double('side_wall_girt_kg')->nullable();
            $table->float('gable_end_girt_m2')->length(4,2)->nullable();
            $table->double('gable_end_girt_kg')->nullable();
            $table->float('roofing_sheet_m2')->length(4,2)->nullable();
            $table->double('roofing_sheet_kg')->nullable();
            $table->float('clading_sheet_m2')->length(4,2)->nullable();
            $table->double('clading_sheet_kg')->nullable();
            $table->float('sag_rod_m2')->length(4,2)->nullable();
            $table->double('sag_rod_kg')->nullable();
            $table->float('stay_brace_m2')->length(4,2)->nullable();
            $table->double('stay_brace_kg')->nullable();
            $table->float('anchor_bolt_m2')->length(4,2)->nullable();
            $table->double('anchor_bolt_kg')->nullable();
            $table->float('cleat_m2')->length(4,2)->nullable();
            $table->double('cleat_kg')->nullable();
            $table->float('x_bracing_m2')->length(4,2)->nullable();
            $table->double('x_bracing_kg')->nullable();
            $table->float('finishing_m2')->length(4,2)->nullable();
            $table->double('finishing_kg')->nullable();
            $table->float('total_quantity_m2')->length(4,2)->nullable();
            $table->double('atotal_quantity_kg')->nullable();
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
