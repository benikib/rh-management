<?php

namespace App\Services;

use App\Models\Employe;
use App\Models\Presence;
use Carbon\Carbon;

class PaieService
{
    /**
     * Compute presence summary and remuneration for all employees between two dates.
     *
     * @param  string|\DateTime  $start
     * @param  string|\DateTime  $end
     * @return array
     */
    public function computeForPeriod($start, $end): array
    {
        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->endOfDay();

        $params = config('paie');
        // Prefer DB settings if available
        try {
            $db = \App\Models\PaieSetting::first();
        } catch (\Throwable $e) {
            $db = null;
        }

        $joursTravailParMois = $db->jours_travail_par_mois ?? $params['jours_travail_par_mois'] ?? 22;
        $heuresParJour = $db->heures_par_jour ?? $params['heures_par_jour'] ?? 8;
        $method = $db->calculation_method ?? $params['calculation_method'] ?? 'pro_rata';
        $overtimeMultiplier = $db->overtime_multiplier ?? $params['overtime_multiplier'] ?? 1.5;

        $results = [];

        Employe::chunk(100, function ($employes) use ($start, $end, $joursTravailParMois, $heuresParJour, $method, &$results) {
            foreach ($employes as $employe) {
                $presences = Presence::where('employe_id', $employe->id)
                    ->whereBetween('date_presence', [$start->toDateString(), $end->toDateString()])
                    ->get();

                $daysPresent = $presences->count();

                // total hours from heure_arrivee and heure_depart when present
                $totalHours = 0.0;
                foreach ($presences as $p) {
                    if ($p->heure_arrivee && $p->heure_depart) {
                        try {
                            $arr = Carbon::parse($p->heure_arrivee);
                            $dep = Carbon::parse($p->heure_depart);
                            $totalHours += max(0, $dep->diffInMinutes($arr) / 60);
                        } catch (\Throwable $e) {
                            // ignore parse errors per-record
                        }
                    }
                }

                $salaireBase = $employe->salaire_base ?? 0.0;

                if ($method === 'hours') {
                    $hourlyRate = $salaireBase / max(1, ($joursTravailParMois * $heuresParJour));
                    $gross = $totalHours * $hourlyRate;
                } else { // pro_rata
                    $gross = $salaireBase * ($daysPresent / max(1, $joursTravailParMois));
                }

                // apply overtime multiplier for hours beyond standard
                $standardHours = $daysPresent * $heuresParJour;
                $overtime = max(0, $totalHours - $standardHours);
                if ($overtime > 0) {
                    $overtimeRate = ($overtimeMultiplier ?? ($params['overtime_multiplier'] ?? 1.5));
                    $hourlyRate = $salaireBase / max(1, ($joursTravailParMois * $heuresParJour));
                    $gross += $overtime * $hourlyRate * ($overtimeRate - 1);
                }

                $results[] = [
                    'employe_id' => $employe->id,
                    'matricule' => $employe->matricule,
                    'nom_complet' => $employe->nom_complet ?? $employe->prenom . ' ' . $employe->nom,
                    'days_present' => $daysPresent,
                    'total_hours' => round($totalHours, 2),
                    'gross' => round($gross, 2),
                    'salaire_base' => round($salaireBase, 2),
                ];
            }
        });

        return $results;
    }
}
