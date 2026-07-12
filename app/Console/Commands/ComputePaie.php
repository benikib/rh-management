<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PaieService;

class ComputePaie extends Command
{
    protected $signature = 'paie:compute {start} {end}';
    protected $description = 'Compute payroll (paie) for a period';

    public function handle(PaieService $paie)
    {
        $start = $this->argument('start');
        $end = $this->argument('end');

        $this->info("Computing paie from {$start} to {$end}...");

        $results = $paie->computeForPeriod($start, $end);

        if (empty($results)) {
            $this->info('No employees or no presence records found for the period.');
            return 0;
        }

        $filename = storage_path('app/paie_' . str_replace([' ', ':'], ['_', '-'], $start) . '_' . str_replace([' ', ':'], ['_', '-'], $end) . '.csv');

        $handle = fopen($filename, 'w');
        fputcsv($handle, ['employe_id', 'matricule', 'nom_complet', 'days_present', 'total_hours', 'salaire_base', 'gross']);
        foreach ($results as $row) {
            fputcsv($handle, [$row['employe_id'], $row['matricule'], $row['nom_complet'], $row['days_present'], $row['total_hours'], $row['salaire_base'], $row['gross']]);
        }
        fclose($handle);

        $this->info("Payroll CSV written to: {$filename}");

        return 0;
    }
}
