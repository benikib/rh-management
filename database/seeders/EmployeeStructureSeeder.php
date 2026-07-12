<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeStatus;
use App\Models\ContractType;
use App\Models\MaritalStatus;
use App\Models\EmployeeContract;
use App\Models\EmployeeFamilyInfo;
use App\Models\EmployeeDependent;
use App\Models\EmployeeMonthlyRating;
use App\Models\EmployeePositionHistory;
use App\Models\PersonnelTask;
use App\Models\EmployeeHistoryLog;
use App\Models\Employe;
use App\Models\Direction;
use App\Models\Departement;
use App\Models\User;

class EmployeeStructureSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Employee Statuses
        $this->seedEmployeeStatuses();

        // Seed Contract Types
        $this->seedContractTypes();

        // Seed Marital Statuses
        $this->seedMaritalStatuses();

        // Seed related data for existing employees
        $this->seedEmployeeRelatedData();

        $this->command->info('Employee structure seeding completed successfully!');
    }

    private function seedEmployeeStatuses(): void
    {
        $statuses = [
            ['code' => 'actif', 'label' => 'Actif', 'description' => 'Employé actif'],
            ['code' => 'mis_a_pied', 'label' => 'Mis à pied disciplinaire', 'description' => 'Statut disciplinaire'],
            ['code' => 'disponibilite', 'label' => 'Mis en disponibilité', 'description' => 'Employé en disponibilité'],
            ['code' => 'suspension', 'label' => 'Suspension', 'description' => 'Employé suspendu'],
            ['code' => 'revocation', 'label' => 'Révocation', 'description' => 'Employé révoqué'],
            ['code' => 'deces', 'label' => 'Décédé', 'description' => 'Employé décédé'],
            ['code' => 'retraite', 'label' => 'Retraité', 'description' => 'Employé à la retraite'],
            ['code' => 'formation', 'label' => 'En formation', 'description' => 'Employé en formation'],
            ['code' => 'maladie', 'label' => 'Arrêt maladie', 'description' => 'Employé en arrêt maladie'],
            ['code' => 'demission', 'label' => 'Démission', 'description' => 'Employé ayant démissionné'],
        ];

        foreach ($statuses as $status) {
            EmployeeStatus::firstOrCreate($status);
        }

        $this->command->info('Employee statuses seeded successfully.');
    }

    private function seedContractTypes(): void
    {
        $contractTypes = [
            [
                'code' => 'cdi',
                'label' => 'CDI',
                'description' => 'Contrat à durée indéterminée',
                'requires_end_date' => false,
            ],
            [
                'code' => 'cdd',
                'label' => 'CDD',
                'description' => 'Contrat à durée déterminée',
                'requires_end_date' => true,
            ],
            [
                'code' => 'stagiaire',
                'label' => 'Stagiaire',
                'description' => 'Contrat de stage',
                'requires_end_date' => true,
            ],
            [
                'code' => 'temporaire',
                'label' => 'Temporaire (Période d\'essai)',
                'description' => 'Contrat temporaire période d\'essai',
                'requires_end_date' => true,
            ],
        ];

        foreach ($contractTypes as $type) {
            ContractType::firstOrCreate(['code' => $type['code']], $type);
        }

        $this->command->info('Contract types seeded successfully.');
    }

    private function seedMaritalStatuses(): void
    {
        $maritalStatuses = [
            ['code' => 'single', 'label' => 'Célibataire'],
            ['code' => 'married', 'label' => 'Marié'],
            ['code' => 'divorced', 'label' => 'Divorcé'],
            ['code' => 'widowed', 'label' => 'Veuf(ve)'],
        ];

        foreach ($maritalStatuses as $status) {
            MaritalStatus::firstOrCreate($status);
        }

        $this->command->info('Marital statuses seeded successfully.');
    }

    private function seedEmployeeRelatedData(): void
    {
        $employes = Employe::take(5)->get();

        if ($employes->isEmpty()) {
            $this->command->warn('No employees found. Skipping employee related data seeding.');
            return;
        }

        $cdiType = ContractType::where('code', 'cdi')->first();
        $mariedStatus = MaritalStatus::where('code', 'married')->first();
        $singleStatus = MaritalStatus::where('code', 'single')->first();

        foreach ($employes as $employe) {
            // Create contract if not exists
            if (!$employe->contracts()->exists()) {
                EmployeeContract::create([
                    'employe_id' => $employe->id,
                    'contract_type_id' => $cdiType->id,
                    'start_date' => $employe->date_embauche ?? now()->subYears(2),
                    'salary' => $employe->salaire_base,
                    'is_active' => true,
                ]);
            }

            // Create family info if not exists
            if (!$employe->familyInfo()->exists()) {
                EmployeeFamilyInfo::create([
                    'employe_id' => $employe->id,
                    'marital_status_id' => rand(0, 1) ? $mariedStatus->id : $singleStatus->id,
                    'spouse_name' => rand(0, 1) ? 'Conjoint(e) ' . $employe->nom : null,
                    'number_of_children' => rand(0, 3),
                ]);
            }

            // Create dependents if family info exists and has children
            $familyInfo = $employe->familyInfo;
            if ($familyInfo && $familyInfo->number_of_children > 0) {
                for ($i = 0; $i < $familyInfo->number_of_children; $i++) {
                    EmployeeDependent::firstOrCreate(
                        [
                            'employe_id' => $employe->id,
                            'full_name' => "Enfant {$i} " . $employe->nom,
                        ],
                        [
                            'type' => 'child',
                            'birth_date' => now()->subYears(rand(3, 18)),
                            'is_student' => rand(0, 1),
                            'is_schooled' => rand(0, 1),
                        ]
                    );
                }
            }

            // Create monthly ratings for past 3 months
            for ($monthsBack = 0; $monthsBack < 3; $monthsBack++) {
                $date = now()->subMonths($monthsBack);
                
                EmployeeMonthlyRating::firstOrCreate(
                    [
                        'employe_id' => $employe->id,
                        'year' => $date->year,
                        'month' => $date->month,
                    ],
                    [
                        'departement_id' => $employe->departement_id,
                        'performance_score' => rand(60, 100) / 10,
                        'attendance_score' => rand(70, 100) / 10,
                        'productivity_score' => rand(60, 100) / 10,
                        'observations' => 'Notation mensuelle automatique',
                    ]
                );
            }

            // Create position history entry
            EmployeePositionHistory::firstOrCreate(
                [
                    'employe_id' => $employe->id,
                    'start_date' => $employe->date_embauche ?? now()->subYears(2),
                ],
                [
                    'poste_id' => $employe->poste_id,
                    'departement_id' => $employe->departement_id,
                    'observations' => 'Poste actuel depuis l\'embauche',
                    'status' => 'active',
                ]
            );

            // Create history log entry
            EmployeeHistoryLog::firstOrCreate(
                [
                    'employe_id' => $employe->id,
                    'event_type' => 'hired',
                    'event_date' => $employe->date_embauche ?? now()->subYears(2),
                ],
                [
                    'reason' => 'Embauche initiale',
                    'recorded_by_id' => User::first()->id ?? 1,
                ]
            );
        }

        $this->seedPersonnelTasks();
        $this->command->info('Employee related data seeded successfully.');
    }

    private function seedPersonnelTasks(): void
    {
        $directions = Direction::take(2)->get();
        $employes = Employe::take(5)->get();
        $user = User::first();

        if ($directions->isEmpty() || $employes->isEmpty() || !$user) {
            $this->command->warn('Required data not found for personnel tasks seeding.');
            return;
        }

        $tasks = [
            [
                'title' => 'Rapport mensuel de performance',
                'description' => 'Préparer le rapport mensuel de performance du département',
                'priority' => 'high',
                'status' => 'pending',
            ],
            [
                'title' => 'Mise à jour des feuilles de temps',
                'description' => 'Mettre à jour et valider les feuilles de temps du mois',
                'priority' => 'medium',
                'status' => 'in_progress',
            ],
            [
                'title' => 'Évaluation des employés',
                'description' => 'Effectuer l\'évaluation trimestrielle des employés',
                'priority' => 'high',
                'status' => 'pending',
            ],
            [
                'title' => 'Planification de formation',
                'description' => 'Planifier les sessions de formation pour le trimestre',
                'priority' => 'medium',
                'status' => 'pending',
            ],
        ];

        foreach ($directions as $direction) {
            $departement = $direction->departements()->first();
            
            if (!$departement) {
                continue;
            }

            foreach ($tasks as $key => $taskData) {
                PersonnelTask::firstOrCreate(
                    [
                        'direction_id' => $direction->id,
                        'title' => $taskData['title'],
                    ],
                    [
                        'departement_id' => $departement->id,
                        'assigned_by_id' => $user->id,
                        'assigned_to_id' => $employes[$key % $employes->count()]->id,
                        'description' => $taskData['description'],
                        'priority' => $taskData['priority'],
                        'status' => $taskData['status'],
                        'due_date' => now()->addDays(rand(5, 30)),
                    ]
                );
            }
        }

        $this->command->info('Personnel tasks seeded successfully.');
    }
}
