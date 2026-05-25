<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Direction;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'Ressources Humaines' => 'Direction Administrative',
            'Informatique' => 'Direction Technique',
            'Finance' => 'Direction Administrative',
            'Commercial' => 'Direction Commerciale',
            'Logistique' => 'Direction Générale',
        ];

        $departements = [
            [
                'nom' => 'Ressources Humaines',
                'description' => 'Gestion du personnel, recrutement et formation.',
            ],
            [
                'nom' => 'Informatique',
                'description' => 'Développement, infrastructure et support technique.',
            ],
            [
                'nom' => 'Finance',
                'description' => 'Comptabilité, paie et contrôle budgétaire.',
            ],
            [
                'nom' => 'Commercial',
                'description' => 'Ventes, marketing et relation client.',
            ],
            [
                'nom' => 'Logistique',
                'description' => 'Approvisionnement, stock et livraisons.',
            ],
        ];

        foreach ($departements as $departement) {
            $direction = Direction::where('nom', $defaults[$departement['nom']] ?? 'Direction Générale')->first();
            $departement['direction_id'] = $direction?->id;

            Departement::firstOrCreate(
                ['nom' => $departement['nom']],
                $departement
            );
        }
    }
}
