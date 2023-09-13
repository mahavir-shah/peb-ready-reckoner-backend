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
        Schema::create('project_estimantion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('project_name');
            $table->text('project_location');
            $table->tinyInteger('code_of_design')->nullable()->comment('1 = Indian Code, 2 = American Code');
            $table->string('type_of_frame');
            $table->integer('wind_speed');
            $table->integer('span');
            $table->integer('width');
            $table->integer('height');
            $table->integer('length_of_building');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_estimantion');
    }
};
