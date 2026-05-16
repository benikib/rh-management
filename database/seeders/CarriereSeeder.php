<?php

namespace Database\Seeders;

use App\Models\Carriere;
use App\Models\Employe;
use App\Models\Poste;
use Illuminate\Database\Seeder;

class CarriereSeeder extends Seeder
{
    public function run(): void
    {
        $david = Employe::where('matricule', 'EMP-003')->first();
        $patrick = Employe::where('matricule', 'EMP-002')->first();

        $supportIt = Poste::where('titre', 'Technicien support IT')->first();
        $devFullStack = Poste::where('titre', 'Développeur full-stack')->first();
        $chargeRecrutement = Poste::where('titre', 'Chargé de recrutement')->first();
        $directeurRh = Poste::where('titre', 'Directeur RH')->first();

        if ($david && $supportIt && $devFullStack) {
            Carriere::firstOrCreate(
                [
                    'employe_id' => $david->id,
                    'date_changement' => '2021-03-10',
                ],
                [
                    'ancien_poste_id' => $supportIt->id,
                    'nouveau_poste_id' => $devFullStack->id,
                    'type_mouvement' => 'Promotion',
                    'commentaire' => 'Promotion suite à la certification Laravel.',
                ]
            );
        }

        if ($patrick && $chargeRecrutement && $directeurRh) {
            Carriere::firstOrCreate(
                [
                    'employe_id' => $patrick->id,
                    'date_changement' => '2023-06-01',
                ],
                [
                    'ancien_poste_id' => $chargeRecrutement->id,
                    'nouveau_poste_id' => $directeurRh->id,
                    'type_mouvement' => 'Mutation',
                    'commentaire' => 'Mutation interne vers la direction RH.',
                ]
            );
        }
    }
}
