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
        Schema::table('credit_history', function (Blueprint $table) {
            $table->string('payment_group')->after('order_token')->nullable();
            $table->longText('payment_method_details')->after('payment_group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit_history', function (Blueprint $table) {
            //
        });
    }
};
