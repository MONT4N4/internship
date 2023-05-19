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

        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->double('discipline_mark');
            $table->double('work_mark');
            $table->double('initiative_mark');
            $table->double('innovation_mark');
            $table->double('knowledge_mark');
            $table->double('final_mark');
            $table->unsignedInteger('id_intern');
            $table->foreign('id_intern')->references('id')->on('internships');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
