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
        Schema::create('ammunition_habitualities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('habituality_id');
            $table->integer('quantity');
            $table->string('origin');
            $table->string('type');
            $table->timestamps();

            $table->foreign('habituality_id')->references('id')->on('habitualities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ammunition_habitualities');
    }
};
