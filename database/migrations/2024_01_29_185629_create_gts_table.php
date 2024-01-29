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
        Schema::create('gts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('weapon_id');
            $table->date('issue_date');
            $table->date('validate_date');
            $table->timestamps();

            $table->foreign('weapon_id')->references('id')->on('weapons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gts');
    }
};
