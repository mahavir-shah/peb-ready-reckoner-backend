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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_img')->after('mobile_no')->nullable();
            $table->string('company_name',100)->after('profile_img')->nullable();
            $table->string('designation',100)->after('company_name')->nullable();
            $table->boolean('otp_verified')->after('designation')->default(false);
            $table->string('opt_code',6)->after('otp_verified')->nullable();
            $table->string('selected_theme',10)->after('opt_code')->default('#206CA5');
            $table->string('selected_plan',20)->after('selected_theme')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
