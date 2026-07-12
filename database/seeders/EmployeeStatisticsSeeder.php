<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employe;
use App\Models\EmployeeHistoryLog;
use App\Models\EmployeeMonthlyRating;
use App\Models\User;

class EmployeeStatisticsSeeder extends Seeder
{
    /**
     * Seed employee statistics and historical data.
     * This generates historical events and ratings for analytics purposes.
     */
    public function run(): void
    {
        $employes = Employe::limit(10)->get();

        if ($employes->isEmpty()) {
            $this->command->warn('No employees found. Skipping statistics seeding.');
            return;
        }

        $user = User::first();

        foreach ($employes as $index => $employe) {
            // Create historical events for different scenarios
            $this->createHistoricalEvents($employe, $user, $index);

            // Create monthly ratings for the past 12 months
            $this->createHistoricalRatings($employe);
        }

        $this->command->info('Employee statistics seeded successfully.');
    }

    private function createHistoricalEvents($employe, $user, $index): void
    {
        $events = [];

        // Add promotional event
        $events[] = [
            'employe_id' => $employe->id,
            'event_type' => 'promoted',
            'event_date' => now()->subMonths(rand(6, 12)),
            'reason' => 'Excellence professionnelle',
            'recorded_by_id' => $user?->id,
        ];

        // Add formation event
        $events[] = [
            'employe_id' => $employe->id,
            'event_type' => 'formation',
            'event_date' => now()->subMonths(rand(3, 6)),
            'reason' => 'Formation en gestion de projet',
            'recorded_by_id' => $user?->id,
        ];

        // Add random status changes for some employees
        if (rand(0, 1)) {
            $statusEvents = ['formation', 'leave_medical', 'leave_extended'];
            $statusEvent = $statusEvents[array_rand($statusEvents)];

            $events[] = [
                'employe_id' => $employe->id,
                'event_type' => $statusEvent,
                'event_date' => now()->subDays(rand(10, 45)),
                'reason' => $this->getEventReason($statusEvent),
                'recorded_by_id' => $user?->id,
            ];
        }

        foreach ($events as $event) {
            EmployeeHistoryLog::firstOrCreate(
                [
                    'employe_id' => $event['employe_id'],
                    'event_type' => $event['event_type'],
                    'event_date' => $event['event_date'],
                ],
                $event
            );
        }
    }

    private function createHistoricalRatings($employe): void
    {
        // Create ratings for past 12 months
        for ($monthsBack = 11; $monthsBack >= 0; $monthsBack--) {
            $date = now()->subMonths($monthsBack);

            // Skip if already exists
            if (EmployeeMonthlyRating::where('employe_id', $employe->id)
                ->where('year', $date->year)
                ->where('month', $date->month)
                ->exists()) {
                continue;
            }

            EmployeeMonthlyRating::create([
                'employe_id' => $employe->id,
                'departement_id' => $employe->departement_id,
                'year' => $date->year,
                'month' => $date->month,
                'performance_score' => $this->generateRealisticScore(),
                'attendance_score' => $this->generateRealisticScore(),
                'productivity_score' => $this->generateRealisticScore(),
                'observations' => $this->generateObservation(),
            ]);
        }
    }

    private function generateRealisticScore(): float
    {
        // Generate scores with tendency towards 7-8
        $base = rand(60, 100);
        $adjustment = rand(-5, 15);
        $score = min(100, max(0, $base + $adjustment)) / 10;
        return round($score, 1);
    }

    private function generateObservation(): string
    {
        $observations = [
            'Performance conforme aux attentes',
            'Excellente participation à l\'équipe',
            'À travailler sur la prise d\'initiative',
            'Très bon respect des délais',
            'Assiduité satisfaisante',
            'Communication efficace',
            'Besoin de développement en leadership',
            'Contributions pertinentes en réunions',
            'Collaboration positive avec collègues',
            'Amélioration notable ce mois',
        ];

        return $observations[array_rand($observations)];
    }

    private function getEventReason($eventType): string
    {
        return match($eventType) {
            'promoted' => 'Promotion due to outstanding performance',
            'transferred' => 'Transfer to new department',
            'formation' => 'Professional training completion',
            'leave_medical' => 'Medical leave authorized',
            'leave_extended' => 'Extended leave for personal reasons',
            'disciplinary' => 'Disciplinary action',
            'reactivated' => 'Reactivation after leave',
            default => 'Employee event',
        };
    }
}
