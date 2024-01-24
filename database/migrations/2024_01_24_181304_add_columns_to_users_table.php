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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cnh')->nullable();
            $table->date('cnh_issue_date')->nullable()->comment('Data de emissão da CNH');
            $table->string('cnh_expiration_date')->nullable()->comment('Data de expiração da CNH');
            $table->string('sisgcorp_password')->nullable()->comment('Senha do SISGCORP');
            $table->string('blood_type')->nullable()->comment('Tipo sanguíneo');
            $table->integer('dispatcher')->nullable()->comment('Despachante');
            $table->char('status', 1)->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('street', 150)->nullable();
            $table->string('number', 10)->nullable();
            $table->string('neighborhood', 50)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('zip_code', 10)->nullable()->comment('CEP');
            $table->string('city', 100)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('marital_status', 50)->nullable()->comment('Estado civil');
            $table->string('birthplace', 50)->nullable()->comment('Naturalidade');
            $table->string('nationality', 50)->nullable();
            $table->string('birth_date', 50)->nullable();
            $table->string('profession', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('instagram', 30)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('father', 100)->nullable();
            $table->string('mother', 100)->nullable();
            $table->string('cpf', 30)->nullable();
            $table->string('identity', 20)->nullable()->comment('Identidade');
            $table->string('issuing_authority', 6)->nullable()->comment('Órgão emissor');
            $table->date('identity_issue_date')->nullable()->comment('Data de emissão da identidade');
            $table->string('voter_registration', 20)->nullable()->comment('Título de eleitor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
