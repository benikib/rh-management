<?php

namespace App\Services;

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Evaluation;
use App\Models\Presence;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RHAnalyticsService
{
    protected int $cacheSeconds = 600;

    public function getGlobalMetrics(): array
    {
        if (Cache::has('rh.analytics.global')) {
            $cached = Cache::get('rh.analytics.global');
            if (! is_array($cached) || ! array_key_exists('total_masculin', $cached) || ! array_key_exists('total_feminin', $cached)) {
                Cache::forget('rh.analytics.global');
            }
        }

        return Cache::remember('rh.analytics.global', $this->cacheSeconds, function () {
            return $this->buildGlobalMetrics();
        });
    }

    public function getDepartmentMetrics(): array
    {
        return Cache::remember('rh.analytics.departments', $this->cacheSeconds, function () {
            return $this->buildDepartmentMetrics();
        });
    }

    public function getDirectionMetrics(): array
    {
        return Cache::remember('rh.analytics.directions', $this->cacheSeconds, function () {
            return $this->buildDirectionMetrics();
        });
    }

    public function getAttendanceTrend(int $days = 14): array
    {
        return Cache::remember("rh.analytics.attendance_trend.{$days}", $this->cacheSeconds, function () use ($days) {
            return $this->buildAttendanceTrend($days);
        });
    }

    public function getEvaluationTrend(int $months = 6): array
    {
        return Cache::remember("rh.analytics.evaluation_trend.{$months}", $this->cacheSeconds, function () use ($months) {
            return $this->buildEvaluationTrend($months);
        });
    }

    public function getDepartmentComparison(): array
    {
        return collect($this->getDepartmentMetrics())->map(function ($department) {
            return [
                'label' => $department['nom'],
                'presence_rate' => $department['taux_presence'],
                'average_score' => $department['moyenne_evaluations'],
                'performance' => $department['performance_score'],
            ];
        })->toArray();
    }

    public function getDirectionComparison(): array
    {
        return collect($this->getDirectionMetrics())->map(function ($direction) {
            return [
                'label' => $direction['nom'],
                'presence_rate' => $direction['taux_presence'],
                'average_score' => $direction['moyenne_evaluations'],
                'performance' => $direction['performance_score'],
            ];
        })->toArray();
    }

    public function getTopEmployees(int $limit = 10): array
    {
        return $this->buildEmployeeRanking('desc', $limit);
    }

    public function getScoreHistogram(): array
    {
        return Cache::remember('rh.analytics.score_histogram', $this->cacheSeconds, function () {
            $buckets = collect(range(0, 10))->mapWithKeys(function ($index) {
                $bucket = $index * 10;
                return [$bucket => 0];
            });

            $rows = DB::table('evaluations')
                ->selectRaw('FLOOR(note_totale / 10) * 10 as bucket, COUNT(*) as total')
                ->groupBy('bucket')
                ->orderBy('bucket')
                ->get();

            foreach ($rows as $row) {
                $bucket = (int) $row->bucket;
                if ($bucket < 0) {
                    $bucket = 0;
                } elseif ($bucket > 100) {
                    $bucket = 100;
                }
                $buckets[$bucket] = (int) $row->total;
            }

            return [
                'labels' => $buckets->keys()->map(function ($value) {
                    return $value === 100 ? '100%' : "{$value}% - " . ($value + 9) . "%";
                })->toArray(),
                'data' => $buckets->values()->toArray(),
            ];
        });
    }

    protected function buildGlobalMetrics(): array
    {
        $today = Carbon::today()->toDateString();

        $presenceSummary = Presence::selectRaw('statut, COUNT(*) as total')
            ->whereDate('date_presence', $today)
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->all();

        $presentToday = $presenceSummary['Present'] ?? 0;
        $absentToday = $presenceSummary['Absent'] ?? 0;
        $lateToday = $presenceSummary['Retard'] ?? 0;
        $leaveToday = $presenceSummary['Conge'] ?? 0;

        $attendancePool = max($presentToday + $absentToday + $lateToday + $leaveToday, 1);
        $attendanceRate = round(100 * ($presentToday / $attendancePool), 1);

        $averageScore = round((float) Evaluation::avg('note_totale'), 2);

        $genderSummary = DB::table('employes')
            ->selectRaw('sexe, COUNT(*) as total')
            ->groupBy('sexe')
            ->pluck('total', 'sexe')
            ->all();

        $totalMasculin = (int) ($genderSummary['Masculin'] ?? $genderSummary['M'] ?? $genderSummary['Homme'] ?? $genderSummary['male'] ?? 0);
        $totalFeminin = (int) ($genderSummary['Féminin'] ?? $genderSummary['F'] ?? $genderSummary['Femme'] ?? $genderSummary['female'] ?? 0);

        return [
            'total_employes' => (int) DB::table('employes')->count(),
            'total_masculin' => $totalMasculin,
            'total_feminin' => $totalFeminin,
            'present_today' => $presentToday,
            'absent_today' => $absentToday,
            'late_today' => $lateToday,
            'leave_today' => $leaveToday,
            'attendance_rate' => $attendanceRate,
            'average_evaluation' => $averageScore,
            'top_employees' => $this->buildEmployeeRanking('desc', 5),
            'bottom_employees' => $this->buildEmployeeRanking('asc', 5),
            'best_department' => $this->bestDepartment(),
            'best_direction' => $this->bestDirection(),
        ];
    }

    protected function buildDepartmentMetrics(): array
    {
        $today = Carbon::today()->toDateString();

        return Departement::with(['direction', 'employes'])->get()->map(function (Departement $department) use ($today) {
            $employeeIds = $department->employes->pluck('id')->toArray();

            $presenceSummary = Presence::selectRaw('statut, COUNT(*) as total')
                ->whereIn('employe_id', $employeeIds)
                ->whereDate('date_presence', $today)
                ->groupBy('statut')
                ->pluck('total', 'statut')
                ->all();

            $present = $presenceSummary['Present'] ?? 0;
            $absent = $presenceSummary['Absent'] ?? 0;
            $late = $presenceSummary['Retard'] ?? 0;
            $leave = $presenceSummary['Conge'] ?? 0;
            $denominator = max($present + $absent + $late + $leave, 1);
            $presenceRate = round(100 * ($present / $denominator), 1);

            $averageScore = (float) DB::table('evaluations')
                ->join('employes', 'evaluations.employe_matricule', '=', 'employes.matricule')
                ->where('employes.departement_id', $department->id)
                ->avg('evaluations.note_totale');

            $performanceScore = round(($averageScore + $presenceRate) / 2, 1);

            return [
                'id' => $department->id,
                'nom' => $department->nom,
                'direction' => optional($department->direction)->nom,
                'description' => $department->description,
                'effectif_total' => $department->employes->count(),
                'taux_presence' => $presenceRate,
                'moyenne_evaluations' => round($averageScore, 2),
                'retards' => $late,
                'absences' => $absent,
                'conge' => $leave,
                'performance_score' => $performanceScore,
            ];
        })->toArray();
    }

    protected function buildDirectionMetrics(): array
    {
        $today = Carbon::today()->toDateString();

        return Direction::with('departements.employes')->get()->map(function (Direction $direction) use ($today) {
            $employeeIds = $direction->departements
                ->flatMap(fn ($departement) => $departement->employes->pluck('id'))
                ->unique()
                ->toArray();

            $presenceSummary = Presence::selectRaw('statut, COUNT(*) as total')
                ->whereIn('employe_id', $employeeIds)
                ->whereDate('date_presence', $today)
                ->groupBy('statut')
                ->pluck('total', 'statut')
                ->all();

            $present = $presenceSummary['Present'] ?? 0;
            $absent = $presenceSummary['Absent'] ?? 0;
            $late = $presenceSummary['Retard'] ?? 0;
            $leave = $presenceSummary['Conge'] ?? 0;
            $denominator = max($present + $absent + $late + $leave, 1);
            $presenceRate = round(100 * ($present / $denominator), 1);

            $averageScore = (float) DB::table('evaluations')
                ->join('employes', 'evaluations.employe_matricule', '=', 'employes.matricule')
                ->join('departements', 'employes.departement_id', '=', 'departements.id')
                ->where('departements.direction_id', $direction->id)
                ->avg('evaluations.note_totale');

            $performanceScore = round(($averageScore + $presenceRate) / 2, 1);

            $genderSummary = DB::table('employes')
                ->join('departements', 'employes.departement_id', '=', 'departements.id')
                ->where('departements.direction_id', $direction->id)
                ->selectRaw('sexe, COUNT(*) as total')
                ->groupBy('sexe')
                ->pluck('total', 'sexe')
                ->all();

            $masculinCount = (int) ($genderSummary['Masculin'] ?? $genderSummary['M'] ?? $genderSummary['Homme'] ?? $genderSummary['male'] ?? 0);
            $femininCount = (int) ($genderSummary['Féminin'] ?? $genderSummary['F'] ?? $genderSummary['Femme'] ?? $genderSummary['female'] ?? 0);

            return [
                'id' => $direction->id,
                'nom' => $direction->nom,
                'description' => $direction->description,
                'effectif_total' => $employeeIds ? count($employeeIds) : 0,
                'masculin' => $masculinCount,
                'feminin' => $femininCount,
                'taux_presence' => $presenceRate,
                'moyenne_evaluations' => round($averageScore, 2),
                'retards' => $late,
                'absences' => $absent,
                'conge' => $leave,
                'performance_score' => $performanceScore,
            ];
        })->toArray();
    }

    protected function buildAttendanceTrend(int $days): array
    {
        $startDate = Carbon::today()->subDays($days - 1);
        $today = Carbon::today();

        $rows = Presence::selectRaw('date_presence, statut, COUNT(*) as total')
            ->whereBetween('date_presence', [$startDate, $today])
            ->groupBy('date_presence', 'statut')
            ->orderBy('date_presence')
            ->get();

        $grouped = $rows->groupBy('date_presence');

        $labels = [];
        $present = [];
        $absent = [];
        $late = [];

        for ($date = $startDate->copy(); $date->lte($today); $date->addDay()) {
            $key = $date->toDateString();
            $labels[] = $date->format('d M');
            $statuts = $grouped->get($key, collect())->keyBy('statut');
            $present[] = (int) optional($statuts->get('Present'))->total;
            $absent[] = (int) optional($statuts->get('Absent'))->total;
            $late[] = (int) optional($statuts->get('Retard'))->total;
        }

        return [
            'labels' => $labels,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
        ];
    }

    protected function buildEvaluationTrend(int $months): array
    {
        $startDate = Carbon::today()->subMonths($months - 1)->startOfMonth();
        $endDate = Carbon::today();

        $rows = Evaluation::selectRaw("DATE_FORMAT(date_evaluation, '%Y-%m') as month, AVG(note_totale) as average_score")
            ->whereBetween('date_evaluation', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $avgScores = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subMonths($i);
            $key = $date->format('Y-m');
            $labels[] = $date->format('M Y');
            $avgScores[] = round((float) optional($rows->get($key))->average_score, 2);
        }

        return [
            'labels' => $labels,
            'average_score' => $avgScores,
        ];
    }

    protected function buildEmployeeRanking(string $direction, int $limit = 5): array
    {
        $rows = DB::table('evaluations')
            ->join('employes', 'evaluations.employe_matricule', '=', 'employes.matricule')
            ->select(
                'employes.matricule',
                'employes.prenom',
                'employes.nom',
                'employes.postnom',
                DB::raw('AVG(evaluations.note_totale) as avg_score'),
                DB::raw('COUNT(evaluations.id) as evaluation_count')
            )
            ->groupBy('employes.id', 'employes.matricule', 'employes.prenom', 'employes.nom', 'employes.postnom')
            ->orderBy('avg_score', $direction)
            ->orderBy('evaluation_count', 'desc')
            ->limit($limit)
            ->get();

        return $rows->map(function ($row) {
            return [
                'matricule' => $row->matricule,
                'nom_complet' => trim("{$row->prenom} {$row->nom} {$row->postnom}"),
                'score' => round($row->avg_score, 2),
                'evaluations' => $row->evaluation_count,
            ];
        })->toArray();
    }

    protected function bestDepartment(): ?array
    {
        $row = DB::table('departements')
            ->join('employes', 'departements.id', '=', 'employes.departement_id')
            ->join('evaluations', 'evaluations.employe_matricule', '=', 'employes.matricule')
            ->select('departements.nom', DB::raw('AVG(evaluations.note_totale) as average_score'))
            ->groupBy('departements.id', 'departements.nom')
            ->orderByDesc('average_score')
            ->first();

        return $row ? [
            'nom' => $row->nom,
            'average_score' => round($row->average_score, 2),
        ] : null;
    }

    protected function bestDirection(): ?array
    {
        $row = DB::table('directions')
            ->join('departements', 'directions.id', '=', 'departements.direction_id')
            ->join('employes', 'departements.id', '=', 'employes.departement_id')
            ->join('evaluations', 'evaluations.employe_matricule', '=', 'employes.matricule')
            ->select('directions.nom', DB::raw('AVG(evaluations.note_totale) as average_score'))
            ->groupBy('directions.id', 'directions.nom')
            ->orderByDesc('average_score')
            ->first();

        return $row ? [
            'nom' => $row->nom,
            'average_score' => round($row->average_score, 2),
        ] : null;
    }
}
