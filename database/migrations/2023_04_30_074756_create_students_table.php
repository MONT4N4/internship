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
        Schema::disableForeignKeyConstraints();

        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('major');
            $table->string('academic_year');
            $table->date('b_date');
            $table->integer('semester');
            $table->string('edu_level ');
            $table->string('stud_card_num');
            $table->string('stud_phone_num');
            $table->string('social_sec_num');
            $table->unsignedInteger('id_dep');
            $table->foreign('id_dep')->references('id')->on('departements');
            $table->string('b_place')->nullable();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
