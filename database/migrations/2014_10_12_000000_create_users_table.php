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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('numero_telephone');
            $table->date('date_naissance');
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('est_actif');
            $table->bigInteger('id_ville')->unsigned()->nullable();
            $table->bigInteger('id_role')->unsigned();
        });

        // Foreign keys
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_ville')->references('id')->on('villes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
