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
        Schema::table('company_name', function (Blueprint $table) {
            $table->tinyInteger('is_deleted')->after('company_title')->default(0)->comment('0:No Delete, 1:Delete');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_name', function (Blueprint $table) {
            //
        });
    }
};
