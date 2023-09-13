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
            $table->tinyInteger('is_admin')->after('id')->default(0)->comment('0:No admin, 1:admin');
            $table->string('mobile_no')->after('password');
            $table->timestamp('created_at')->nullable()->useCurrent()->change();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->change();
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
