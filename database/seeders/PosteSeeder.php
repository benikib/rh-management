<?php

namespace Database\Seeders;

use App\Models\Poste;
use Illuminate\Database\Seeder;

class PosteSeeder extends Seeder
{
    public function run(): void
    {
        $postes = [
            [
                'titre' => 'Directeur RH',
                'description' => 'Supervision de la politique RH et des équipes.',
                'salaire_reference' => 3500.00,
            ],
            [
                'titre' => 'Chargé de recrutement',
                'description' => 'Sourcing, entretiens et intégration des nouveaux employés.',
                'salaire_reference' => 1800.00,
            ],
            [
                'titre' => 'Développeur full-stack',
                'description' => 'Conception et maintenance des applications web.',
                'salaire_reference' => 2200.00,
            ],
            [
                'titre' => 'Technicien support IT',
                'description' => 'Assistance utilisateurs et maintenance du parc informatique.',
                'salaire_reference' => 1200.00,
            ],
            [
                'titre' => 'Comptable',
                'description' => 'Tenue des comptes et déclarations fiscales.',
                'salaire_reference' => 1600.00,
            ],
            [
                'titre' => 'Commercial terrain',
                'description' => 'Prospection et suivi des clients sur le terrain.',
                'salaire_reference' => 1400.00,
            ],
            [
                'titre' => 'Responsable logistique',
                'description' => 'Coordination des flux et gestion des entrepôts.',
                'salaire_reference' => 2000.00,
            ],
        ];

        foreach ($postes as $poste) {
            Poste::firstOrCreate(['titre' => $poste['titre']], $poste);
        }
    }
}
