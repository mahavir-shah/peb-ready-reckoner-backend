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
        Schema::table('user_plan_history', function (Blueprint $table) {
            $table->string('subscriptionId')->after('plan_name')->nullable();
            $table->string('planId')->after('subscriptionId')->nullable();
            $table->string('subReferenceId')->after('planId')->nullable();
            $table->string('authLink')->after('subReferenceId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_plan_history', function (Blueprint $table) {
            //
        });
    }
};
