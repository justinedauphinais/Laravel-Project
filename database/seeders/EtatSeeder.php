<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : EtatSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les états
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etats')->insert([
            ['nom' => 'Québec',
            'code' => 'QC',
            'id_pays' => 1],
            ['nom' => 'Ontario',
            'code' => 'ON',
            'id_pays' => 1],
            ['nom' => 'Colombie-Britannique',
            'code' => 'BC',
            'id_pays' => 1],
            ['nom' => 'Vermont',
            'code' => 'VT',
            'id_pays' => 2],
            ['nom' => 'New York',
            'code' => 'NY',
            'id_pays' => 2],
            ['nom' => 'Quintana Roo',
            'code' => 'QR',
            'id_pays' => 3],
            ['nom' => 'Ile-de-France',
            'code' => 'IDF',
            'id_pays' => 4]
        ]);
    }
}
