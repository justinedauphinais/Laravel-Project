<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : VilleSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les villes
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('villes')->insert([
            ['nom' => 'Sherbrooke',
            'id_etat' => 1],
            ['nom' => 'Montréal',
            'id_etat' => 1],
            ['nom' => 'Magog',
            'id_etat' => 1],
            ['nom' => 'Drummondville',
            'id_etat' => 1],
            ['nom' => 'Alma',
            'id_etat' => 1],
            ['nom' => 'Kingston',
            'id_etat' => 2],
            ['nom' => 'Ottawa',
            'id_etat' => 2],
            ['nom' => 'Toronto',
            'id_etat' => 2],
            ['nom' => 'Kelowna',
            'id_etat' => 3],
            ['nom' => 'Vancouver',
            'id_etat' => 3],
            ['nom' => 'Burlington',
            'id_etat' => 4],
            ['nom' => 'Woodstock',
            'id_etat' => 4],
            ['nom' => 'New York City',
            'id_etat' => 5],
            ['nom' => 'Cancun',
            'id_etat' => 6],
            ['nom' => 'Paris',
            'id_etat' => 7]
        ]);
    }
}
