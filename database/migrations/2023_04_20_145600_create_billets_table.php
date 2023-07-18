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
        Schema::create('billets', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id');
            $table->boolean('est_utilise');
            $table->boolean('est_actif');
            $table->bigInteger('id_transaction_representation')->unsigned();
        });

        Schema::table('billets', function (Blueprint $table) {
            $table->foreign('id_transaction_representation')->references('id')->on('transactions_representations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billets');
    }
};
