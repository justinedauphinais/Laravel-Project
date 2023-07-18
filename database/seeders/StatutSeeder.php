<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : StatutSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les statuts
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuts')->insert([
            ['nom' => 'En cours'],
            ['nom' => 'En attente'],
            ['nom' => 'Annulé'],
            ['nom' => 'Terminé']
        ]);
    }
}
