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
        Schema::create('transactions_representations', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id');
            $table->bigInteger('id_transaction')->unsigned();
            $table->bigInteger('id_representation')->unsigned();
        });

        Schema::table('transactions_representations', function (Blueprint $table) {
            $table->foreign('id_transaction')->references('id')->on('transactions');
            $table->foreign('id_representation')->references('id')->on('representations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions__representations');
    }
};
