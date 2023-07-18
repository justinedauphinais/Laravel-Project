<?php
/* TODO faire ça */

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
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id');
            $table->date('date_demande');
            $table->date('date_complete')->nullable();
            $table->boolean('paye');
            $table->string('token');
            $table->bigInteger('id_utilisateur')->unsigned();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('id_utilisateur')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
