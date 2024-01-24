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
        Schema::create('registration_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reg_certifiable_id');
            $table->string('reg_certifiable_type');
            $table->date('certificate');
            $table->date('emission');
            $table->date('expedition');
            $table->date('validity');
            $table->timestamps();

            $table->index(['reg_certifiable_id', 'reg_certifiable_type'], 'reg_certifiable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_certificates');
    }
};
