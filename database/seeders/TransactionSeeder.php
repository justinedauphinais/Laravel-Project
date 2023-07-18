<?php

namespace Database\Seeders;

/*****************************************************************************
Fichier : TransactionSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les transactions
Date : 2023-05-04
 *****************************************************************************/

### PLACEHOLDER - en attendant l'app mobile

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* for ($i = 0; $i < 50; $i++) {
            DB::table('transactions')->insert([
                ['date_demande' => date('Y-m-d'),
                'date_complete' => date('Y-m-d'),
                'paye' => 1,
                'token' => 'placeholder token',
                'id_utilisateur' => 5]
            ]);
        } */
    }
}
