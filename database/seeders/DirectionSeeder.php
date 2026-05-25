<?php

namespace Database\Seeders;

use App\Models\Direction;
use Illuminate\Database\Seeder;

class DirectionSeeder extends Seeder
{
    public function run(): void
    {
        $directions = [
            [
                'nom' => 'Direction Générale',
                'description' => 'Supervision globale de l’entreprise.',
            ],
            [
                'nom' => 'Direction Administrative',
                'description' => 'Gestion administrative et financière.',
            ],
            [
                'nom' => 'Direction Technique',
                'description' => 'Pilotage des activités techniques et informatiques.',
            ],
            [
                'nom' => 'Direction Commerciale',
                'description' => 'Stratégie commerciale et relation client.',
            ],
        ];

        foreach ($directions as $direction) {
            Direction::firstOrCreate(['nom' => $direction['nom']], $direction);
        }
    }
}
