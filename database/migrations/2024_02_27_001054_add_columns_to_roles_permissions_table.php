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
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('club_id')->nullable();
            $table->unsignedBigInteger('user_granted_id')->nullable();
            $table->foreign('club_id')->references('id')->on('clubs');
            $table->foreign('user_granted_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropForeign(['user_granted_id']);
            $table->dropColumn('club_id');
            $table->dropColumn('user_granted_id');
        });
    }
};
