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
        Schema::create('address_vacancies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('zip_code', 8);
            $table->string('street', 60);
            $table->string('complement', 60);
            $table->string('neighborhood', 60);
            $table->string('locality', 60);
            $table->string('uf', 60);
            $table->unsignedBigInteger('ibge');
            $table->unsignedBigInteger('gia');
            $table->unsignedBigInteger('ddd');
            $table->unsignedBigInteger('siafi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_vacancies');
    }
};
