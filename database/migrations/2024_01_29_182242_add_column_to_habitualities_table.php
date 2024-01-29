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
        Schema::table('habitualities', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('location_id');

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habitualities', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['location_id']);

            $table->dropColumn('event_id');
            $table->dropColumn('location_id');
        });
    }
};
