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
        Schema::create('user_rates_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('main_frame_steel')->nullable();
            $table->string('cold_form_purlin')->nullable();
            $table->string('side_wall_girt')->nullable();
            $table->string('gable_end_girt')->nullable();
            $table->string('roofing_sheet')->nullable();
            $table->string('side_cladding_sheet')->nullable();
            $table->string('sag_rod')->nullable();
            $table->string('cold_form_stay_brace')->nullable();
            $table->string('anchor_bolt')->nullable();
            $table->string('cleat')->nullable();
            $table->string('x_bracing')->nullable();
            $table->string('finishing')->nullable();
            $table->string('tie_beam')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rates_materials');
    }
};
