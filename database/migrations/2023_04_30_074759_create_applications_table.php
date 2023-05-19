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

        Schema::create('applications', function (Blueprint $table) {
            $table->unsignedInteger('id_stud');
            $table->foreign('id_stud')->references('id')->on('students');
            $table->unsignedInteger('id_offer');
            $table->foreign('id_offer')->references('id')->on('offers');
            $table->string('app_state');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
