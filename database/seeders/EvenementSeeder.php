<?php namespace Database\Seeders;
/*****************************************************************************
Fichier : EvenementSeeder.php
Auteurs : Matias Beaulieu
Fonctionnalité : Seeder pour les événements
Date : 2023-04-27
*****************************************************************************/

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('evenements')->insert([
            [
                'nom' => 'Sherblues',
                'lieu' => 'Scène MAXI',
                'lien' => 'www.gooogle.ca',
                'est_actif' => 1,
                'path_photo' => 'resources/img/image.png',
                'code_postal' => 'J0B1W0',
                'id_utilisateur' => 1,
                'id_statut' => 1,
                'id_ville' => 1,
                'id_categorie' => 1
            ],
            [
                'nom' => 'Fête du Lac des Nations',
                'lieu' => 'Parc Jacques-Cartier',
                'lien' => 'www.gooogle.ca',
                'est_actif' => 1,
                'path_photo' => 'resources/img/image.png',
                'code_postal' => 'J0B1W0',
                'id_utilisateur' => 1,
                'id_statut' => 2,
                'id_ville' => 1,
                'id_categorie' => 1
            ],
            [
                'nom' => 'Festival générique',
                'lieu' => 'Parc générique',
                'lien' => 'www.gooogle.ca',
                'est_actif' => 1,
                'path_photo' => 'resources/img/image.png',
                'code_postal' => 'J0B1W0',
                'id_utilisateur' => 3,
                'id_statut' => 1,
                'id_ville' => 15,
                'id_categorie' => 1
            ],
            [
                'nom' => 'Course annuelle d\'autos japonaises',
                'lieu' => 'Piste 6',
                'lien' => 'www.gooogle.ca',
                'est_actif' => 1,
                'path_photo' => 'resources/img/image.png',
                'code_postal' => 'J0B1W0',
                'id_utilisateur' => 1,
                'id_statut' => 3,
                'id_ville' => 12,
                'id_categorie' => 4
            ],
            [
                'nom' => 'Meet-up Club Curling de Drummond',
                'lieu' => 'Centre communautaire',
                'lien' => 'www.gooogle.ca',
                'est_actif' => 1,
                'path_photo' => 'resources/img/image.png',
                'code_postal' => 'J0B1W0',
                'id_utilisateur' => 2,
                'id_statut' => 1,
                'id_ville' => 4,
                'id_categorie' => 5
            ],
        ]);
    }
}
