<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : RoleSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les roles
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nom' => 'Administrateur'],
            ['nom' => 'Organisateur'],
            ['nom' => 'Utilisateur']
        ]);
    }
}
