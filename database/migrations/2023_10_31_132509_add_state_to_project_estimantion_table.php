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
            $table->string('state',20);
            $table->string('city',20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_estimantion', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('city');
        });
    }
};
