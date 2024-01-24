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
        Schema::create('weapon_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('weapon_id');
            $table->unsignedBigInteger(('old_owner_id'));
            $table->unsignedBigInteger(('new_owner_id'));
            $table->text('observation')->nullable();
            $table->timestamps();

            $table->foreign('weapon_id')->references('id')->on('weapons');
            $table->foreign('old_owner_id')->references('id')->on('users');
            $table->foreign('new_owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapon_transfers');
    }
};
