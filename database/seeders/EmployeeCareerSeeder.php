<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employe;
use App\Models\EmployeePositionHistory;
use App\Models\EmployeeHistoryLog;
use App\Models\User;

class EmployeeCareerSeeder extends Seeder
{
    /**
     * Seed detailed career information for employees.
     * This creates position history and career progression data.
     */
    public function run(): void
    {
        $employes = Employe::limit(10)->get();

        if ($employes->isEmpty()) {
            $this->command->warn('No employees found. Skipping career seeding.');
            return;
        }

        $user = User::first();

        foreach ($employes as $index => $employe) {
            // Create career progression history
            $this->createCareerProgression($employe, $user, $index);
        }

        $this->command->info('Employee career data seeded successfully.');
    }

    private function createCareerProgression($employe, $user, $index): void
    {
        $departement = $employe->departement;
        
        if (!$departement) {
            return;
        }

        // Check if position history already exists
        if (EmployeePositionHistory::where('employe_id', $employe->id)->exists()) {
            return;
        }

        // Initial position (current)
        $startDate = $employe->date_embauche ?? now()->subYears(rand(2, 10));

        EmployeePositionHistory::create([
            'employe_id' => $employe->id,
            'poste_id' => $employe->poste_id,
            'departement_id' => $departement->id,
            'start_date' => $startDate,
            'status' => 'active',
            'supervisor_name' => $departement->chef_departement ?? 'Chef de Département',
            'observations' => 'Poste actuel depuis ' . $startDate->format('d/m/Y'),
        ]);

        // Add previous positions for senior employees
        if ($index % 2 === 0 && now()->diffInYears($startDate) > 2) {
            $previousPostId = $employe->poste_id;
            $previousStartDate = $startDate->copy()->subYears(2);
            $previousEndDate = $startDate->copy()->subDay();

            EmployeePositionHistory::create([
                'employe_id' => $employe->id,
                'poste_id' => $previousPostId,
                'departement_id' => $departement->id,
                'start_date' => $previousStartDate,
                'end_date' => $previousEndDate,
                'status' => 'completed',
                'supervisor_name' => 'Chef de Département Précédent',
                'observations' => 'Position antérieure de 2 ans',
            ]);

            // Add transfer event to history
            EmployeeHistoryLog::create([
                'employe_id' => $employe->id,
                'event_type' => 'transferred',
                'event_date' => $previousEndDate,
                'reason' => 'Mutation vers nouveau poste',
                'recorded_by_id' => $user?->id,
            ]);
        }
    }
}
