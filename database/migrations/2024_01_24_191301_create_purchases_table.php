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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('fiscal_note')->nullable()->comment('Nota fiscal');
            $table->unsignedBigInteger('type_id');
            $table->integer('quantity')->nullable();
            $table->unsignedBigInteger('weapon_id')->nullable();
            $table->string('caliber')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('type_id')->references('id')->on('categories');
            $table->foreign('weapon_id')->references('id')->on('weapons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
