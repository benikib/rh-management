<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Critere;

class CritereSeeder extends Seeder
{
    public function run(): void
    {
        Critere::insert([

            [
                'nom' => 'Ponctualité',
                'description' => 'Respect des horaires',
                'note_max' => 10,
                'ponderation' => 10
            ],

            [
                'nom' => 'Discipline',
                'description' => 'Comportement professionnel',
                'note_max' => 10,
                'ponderation' => 20
            ],

            [
                'nom' => 'Leadership',
                'description' => 'Capacité de gestion',
                'note_max' => 10,
                'ponderation' => 40
            ],

            [
                'nom' => 'Travail équipe',
                'description' => 'Collaboration',
                'note_max' => 10,
                'ponderation' => 30
            ]

        ]);
    }
}