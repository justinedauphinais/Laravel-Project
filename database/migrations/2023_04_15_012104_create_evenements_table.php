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
        Schema::create('evenements', function (Blueprint $table) {
            $table->bigIncrements('id');                        // Primary key automatically generated
            $table->string('nom');                              // Name of the event                         // Price of the event
            $table->text('lieu');
            $table->text('lien');
            $table->boolean('est_actif');
            $table->text('path_photo');                       // Place of the event
            $table->text('code_postal');
            $table->bigInteger('id_utilisateur')->unsigned();  // Id of the organisator
            $table->bigInteger('id_statut')->unsigned();        // Id of the status
            $table->bigInteger('id_ville')->unsigned();         // Id of the town
            $table->bigInteger('id_categorie')->unsigned();     // Id of the category
        });

        // Foreign keys
        Schema::table('evenements', function (Blueprint $table) {
            $table->foreign('id_utilisateur')->references('id')->on('users');
            $table->foreign('id_statut')->references('id')->on('statuts');
            $table->foreign('id_ville')->references('id')->on('villes');
            $table->foreign('id_categorie')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};
