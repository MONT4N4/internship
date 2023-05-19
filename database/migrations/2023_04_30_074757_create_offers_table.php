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

        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('offer_start_date');
            $table->date('offer_end_date');
            $table->string('offer_theme');
            $table->string('offer_description');
            $table->integer('spots');
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
        Schema::dropIfExists('offers');
    }
};
