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
        Schema::create('user_vacancy', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // User
            $table->unsignedBigInteger('user_id')->comment('candidate user');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Vacancy
            $table->unsignedBigInteger('vacancy_id')->comment('vacancy applied');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vacancy');
    }
};
