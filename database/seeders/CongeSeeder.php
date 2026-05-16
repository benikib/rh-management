<?php

namespace Database\Seeders;

use App\Models\Conge;
use App\Models\Employe;
use Illuminate\Database\Seeder;

class CongeSeeder extends Seeder
{
    public function run(): void
    {
        $grace = Employe::where('matricule', 'EMP-001')->first();
        $eric = Employe::where('matricule', 'EMP-006')->first();
        $aline = Employe::where('matricule', 'EMP-005')->first();

        $conges = [
            [
                'employe' => $grace,
                'type_conge' => 'Congé annuel',
                'date_debut' => now()->addDays(10)->toDateString(),
                'date_fin' => now()->addDays(17)->toDateString(),
                'motif' => 'Vacances familiales',
                'statut' => 'En attente',
            ],
            [
                'employe' => $eric,
                'type_conge' => 'Congé maladie',
                'date_debut' => now()->subDays(5)->toDateString(),
                'date_fin' => now()->subDays(2)->toDateString(),
                'motif' => 'Certificat médical fourni',
                'statut' => 'Valide',
            ],
            [
                'employe' => $aline,
                'type_conge' => 'Congé maternité',
                'date_debut' => now()->addMonth()->toDateString(),
                'date_fin' => now()->addMonths(3)->toDateString(),
                'motif' => 'Congé légal',
                'statut' => 'En attente',
            ],
            [
                'employe' => Employe::where('matricule', 'EMP-008')->first(),
                'type_conge' => 'Congé sans solde',
                'date_debut' => now()->subMonth()->toDateString(),
                'date_fin' => now()->subDays(15)->toDateString(),
                'motif' => 'Raison personnelle',
                'statut' => 'Refuse',
            ],
        ];

        foreach ($conges as $conge) {
            if (! $conge['employe']) {
                continue;
            }

            Conge::firstOrCreate(
                [
                    'employe_id' => $conge['employe']->id,
                    'date_debut' => $conge['date_debut'],
                    'type_conge' => $conge['type_conge'],
                ],
                [
                    'date_fin' => $conge['date_fin'],
                    'motif' => $conge['motif'],
                    'statut' => $conge['statut'],
                ]
            );
        }
    }
}
