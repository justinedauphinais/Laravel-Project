<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : CategorieSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les catégories
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([

            ['nom' => 'Festivals',
            'description' => 'Événements rassembleur festifs, souvent accompagnés d\'une thématique.',
            'est_actif' => 1],
            ['nom' => 'Concerts',
            'description' => 'Concerts musicaux mettant en vedette un orchestre.',
            'est_actif' => 1],
            ['nom' => 'Expositions',
            'description' => 'Événements qui permettent à plusieurs d\'exposer et de partager des connaissances.',
            'est_actif' => 1],
            ['nom' => 'Courses',
            'description' => 'Événements de course automobile.',
            'est_actif' => 1],
            ['nom' => 'Rassemblement',
            'description' => 'Événements rassembleurs pour les clubs.',
            'est_actif' => 1]
        ]);

    }
}
