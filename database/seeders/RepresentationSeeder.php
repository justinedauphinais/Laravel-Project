<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : RepresentationSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les représentations
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('representations')->insert([
            [
                'date' => '2023-06-28',
                'heure' => '20:00:00',
                'nbr_places' => 300,
                'est_actif' => 1,
                'prix' => 14.99,
                'id_evenement' => 1
            ], #1
            [
                'date' => '2023-06-29',
                'heure' => '20:00:00',
                'nbr_places' => 300,
                'est_actif' => 1,
                'prix' => 14.99,
                'id_evenement' => 1
            ], #1
            [
                'date' => '2022-07-04',
                'heure' => '19:00:00',
                'nbr_places' => 1200,
                'est_actif' => 1,
                'prix' => 74.99,
                'id_evenement' => 2
            ], #2
            [
                'date' => '2022-07-05',
                'heure' => '19:00:00',
                'nbr_places' => 1200,
                'est_actif' => 1,
                'prix' => 74.99,
                'id_evenement' => 2
            ], #2
            [
                'date' => '2022-07-06',
                'heure' => '19:00:00',
                'nbr_places' => 1200,
                'est_actif' => 1,
                'prix' => 74.99,
                'id_evenement' => 2
            ] #2
        ]);
    }
}
