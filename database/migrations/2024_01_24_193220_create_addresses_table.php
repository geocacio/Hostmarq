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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('address', 100)->nullable();
            $table->string('street', 150)->nullable();
            $table->string('number', 10)->nullable();
            $table->string('neighborhood', 50)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('zip_code', 10)->nullable()->comment('CEP');
            $table->string('city', 100)->nullable();
            $table->string('state', 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
