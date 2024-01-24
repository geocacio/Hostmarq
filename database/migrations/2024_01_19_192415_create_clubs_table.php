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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('name');
            $table->string('acronym');
            $table->string('cnpj');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('email_om');
            $table->string('url');
            $table->string('app_url');
            $table->string('logo');
            $table->string('favicon');
            $table->string('logo_rodape');
            $table->string('favicon');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
