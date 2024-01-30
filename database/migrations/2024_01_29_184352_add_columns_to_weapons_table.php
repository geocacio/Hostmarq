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
        Schema::table('weapons', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('caliber_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();

            $table->foreign('caliber_id')->references('id')->on('calibers');
            $table->foreign('model_id')->references('id')->on('weapon_models');
            $table->foreign('type_id')->references('id')->on('weapon_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weapons', function (Blueprint $table) {
            $table->dropForeign(['caliber_id']);
            $table->dropForeign(['model_id']);
            $table->dropForeign(['type_id']);

            $table->dropColumn('user_id');
            $table->dropColumn('caliber_id');
            $table->dropColumn('model_id');
            $table->dropColumn('type_id');
        });
    }
};
