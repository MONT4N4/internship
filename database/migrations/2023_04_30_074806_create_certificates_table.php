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

        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->date('cert_date');
            $table->string('cert_place');
            $table->boolean('cert_print');
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
        Schema::dropIfExists('certificates');
    }
};
