<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : UserSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les users
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['nom' => 'Beaulieu',
            'prenom' => 'Matias',
            'email' => 'matiasb@gmail.com',

            'password' => Hash::make('allo1234'),

            'numero_telephone' => 8732009999,
            'date_naissance' => '2002-08-08',
            'est_actif' => 1,
            'id_ville' => null,
            'id_role' => 2],
            ['nom' => 'Racette',
            'prenom' => 'Louis-Philippe',
            'email' => 'lp@gmail.com',

            'password' => Hash::make('allo1234'),

            'numero_telephone' => 8732008888,
            'date_naissance' => '2003-11-15',
            'est_actif' => 1,
            'id_ville' => null,
            'id_role' => 2],
            ['nom' => 'Racette',
            'prenom' => 'Serge',
            'email' => 'racetteserge@gmail.com',

            'password' => Hash::make('allo1234'),

            'numero_telephone' => 8198665488,
            'date_naissance' => '1912-02-15',
            'id_ville' => null,
            'est_actif' => 1,
            'id_role' => 2],
            ['nom' => 'admin',
            'prenom' => 'admin',
            'email' => 'admin.evento@gmail.com',

            'password' => Hash::make('allo1234'),

            'numero_telephone' => 8198669999,
            'date_naissance' => '2000-01-01',
            'id_ville' => null,
            'est_actif' => 1,
            'id_role' => 1],
            ['nom' => 'Dauphinais',
            'prenom' => 'Justine',

            'email' => 'dauphiju@gmail.com',
            'password' => Hash::make('allo1234'),

            'numero_telephone' => 5148661443,
            'date_naissance' => '2000-01-01',
            'id_ville' => null,
            'est_actif' => 1,
            'id_role' => 1],
            ['nom' => 'Lancelot',
            'prenom' => 'Jimmi',
            'email' => 'jimmi-joe@gmail.com',

            'password' => Hash::make('allo1234'),

            'numero_telephone' => 1334558978,
            'date_naissance' => '2000-01-01',
            'id_ville' => null,
            'est_actif' => 1,
            'id_role' => 3]
        ]);
    }
}
