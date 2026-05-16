<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Presence;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    public function run(): void
    {
        $employes = Employe::where('statut', 'Actif')->get();

        $jours = [
            now()->subDays(4)->toDateString(),
            now()->subDays(3)->toDateString(),
            now()->subDays(2)->toDateString(),
            now()->subDay()->toDateString(),
            now()->toDateString(),
        ];

        $statuts = ['Present', 'Present', 'Present', 'Retard', 'Absent'];

        foreach ($employes as $employe) {
            foreach ($jours as $index => $jour) {
                $statut = $statuts[$index % count($statuts)];

                Presence::firstOrCreate(
                    [
                        'employe_id' => $employe->id,
                        'date_presence' => $jour,
                    ],
                    [
                        'heure_arrivee' => $statut === 'Absent' ? null : ($statut === 'Retard' ? '09:25:00' : '08:05:00'),
                        'heure_depart' => $statut === 'Absent' ? null : '17:30:00',
                        'statut' => $statut,
                        'remarque' => $statut === 'Retard' ? 'Embouteillage matinal' : null,
                    ]
                );
            }
        }
    }
}
