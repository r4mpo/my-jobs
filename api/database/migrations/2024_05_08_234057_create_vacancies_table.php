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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('short_description', 60)->comment('Short job description');
            $table->text('long_description')->nullable(true)->comment('Long description (not mandatory) of the position');
            $table->unsignedBigInteger('wage')->comment('Information about the amount (int) that will be paid for the work (converted to cents)');
            $table->string('zip_code', 8)->comment('ZIP code (location) of where the work must be done');
            $table->unsignedBigInteger('user_id')->comment('User who registered the vacancy');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
