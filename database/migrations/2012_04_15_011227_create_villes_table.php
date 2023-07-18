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
        Schema::create('villes', function (Blueprint $table) {
            $table->bigIncrements('id');                    // Primary key automatically generated
            $table->string('nom');                          // Name of the country
            $table->bigInteger('id_etat')->unsigned();      // Id of the etat
        });

        // Foreign keys
        Schema::table('villes', function (Blueprint $table) {
            $table->foreign('id_etat')->references('id')->on('etats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villes');
    }
};
