<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : PaysSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les pays
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pays')->insert([
            ['nom' => 'Canada',
            'code_ISO' => 'CAN'],
            ['nom' => 'États-Unis',
            'code_ISO' => 'USA'],
            ['nom' => 'Mexique',
            'code_ISO' => 'MEX'],
            ['nom' => 'France',
            'code_ISO' => 'FRA']
        ]);
    }
}
