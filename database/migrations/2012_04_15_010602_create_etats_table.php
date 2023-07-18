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
        Schema::create('etats', function (Blueprint $table) {
            $table->bigIncrements('id');                    // Primary key automatically generated
            $table->string('nom'); 
            $table->string('code');                          // Name of the country
            $table->bigInteger('id_pays')->unsigned();      // Id of the country
        });

        // Foreign keys
        Schema::table('etats', function (Blueprint $table) {
            $table->foreign('id_pays')->references('id')->on('pays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etats');
    }
};
