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

        Schema::create('internships', function (Blueprint $table) {
            $table->increments('id');
            $table->date('intern_start_date');
            $table->date('intern_end_date');
            $table->unsignedInteger('id_stud');
            $table->foreign('id_stud')->references('id')->on('students');
            $table->unsignedInteger('id_sv');
            $table->foreign('id_sv')->references('id')->on('supervisors');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
