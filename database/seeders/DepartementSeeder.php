<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
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
            Departement::firstOrCreate(['nom' => $departement['nom']], $departement);
        }
    }
}
