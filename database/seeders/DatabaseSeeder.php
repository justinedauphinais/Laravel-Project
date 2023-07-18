<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            PaysSeeder::class,
            EtatSeeder::class,
            VilleSeeder::class,
            StatutSeeder::class,
            UserSeeder::class,
            CategorieSeeder::class,
            EvenementSeeder::class,
            RepresentationSeeder::class,
            TransactionSeeder::class,
            TransactionRepresentationSeeder::class,
            BilletSeeder::class

        ]);
    }
}
