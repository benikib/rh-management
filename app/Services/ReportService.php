<?php

namespace App\Services;

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Evaluation;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    protected const SCHEDULE_ARRIVAL = '08:00:00';
    protected const SCHEDULE_DEPARTURE = '17:00:00';

    public function getReportTypes(): array
    {
        return [
            'presence' => 'Présences',
            'evaluation' => 'Évaluations',
            'department' => 'Départements',
            'direction' => 'Directions',
            'employee' => 'Employé',
        ];
    }

    public function getPeriodOptions(): array
    {
        return [
            'daily' => 'Quotidien',
            'weekly' => 'Hebdomadaire',
            'monthly' => 'Mensuel',
            'quarterly' => 'Trimestriel',
            'semester' => 'Semestriel',
            'yearly' => 'Annuel',
            'custom' => 'Personnalisé',
        ];
    }

    public function normalizeFilters(array $input): array
    {
        $period = $input['period'] ?? 'monthly';
        [$startDate, $endDate] = $this->getDateRange($period, $input['start_date'] ?? null, $input['end_date'] ?? null);

        return [
            'report_type' => $input['report_type'] ?? 'presence',
            'period' => $period,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'department_id' => $input['department_id'] ?? null,
            'direction_id' => $input['direction_id'] ?? null,
            'employe_id' => $input['employe_id'] ?? null,
            'status' => $input['status'] ?? null,
        ];
    }

    public function getReportData(array $filters): array
    {
        return match ($filters['report_type']) {
            'evaluation' => $this->evaluationReport($filters),
            'department' => $this->departmentReport($filters),
            'direction' => $this->directionReport($filters),
            'employee' => $this->employeeReport($filters),
            default => $this->presenceReport($filters),
        };
    }

    public function getReportName(array $filters): string
    {
        $type = $this->getReportTypes()[$filters['report_type']] ?? 'Rapport';
        $range = Carbon::parse($filters['start_date'])->format('d/m/Y') . ' - ' . Carbon::parse($filters['end_date'])->format('d/m/Y');

        return "Rapport {$type} | {$range}";
    }

    public function getReportFileName(array $filters, string $extension): string
    {
        $slug = str_replace([' ', '/'], ['-', '-'], strtolower($this->getReportName($filters)));
        $timestamp = Carbon::now()->format('YmdHis');

        return "report_{$slug}_{$timestamp}.{$extension}";
    }

    protected function getDateRange(string $period, ?string $startDate, ?string $endDate): array
    {
        $today = Carbon::today();

        return match ($period) {
            'daily' => [$today->copy(), $today->copy()],
            'weekly' => [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()],
            'monthly' => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()],
            'quarterly' => $this->getQuarterRange($today),
            'semester' => $this->getSemesterRange($today),
            'yearly' => [$today->copy()->startOfYear(), $today->copy()->endOfYear()],
            'custom' => [Carbon::parse($startDate ?? $today), Carbon::parse($endDate ?? $today)],
            default => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()],
        };
    }

    protected function getQuarterRange(Carbon $date): array
    {
        $quarter = ceil($date->month / 3);
        $start = Carbon::create($date->year, ($quarter - 1) * 3 + 1, 1)->startOfDay();
        $end = $start->copy()->addMonths(3)->subDay()->endOfDay();

        return [$start, $end];
    }

    protected function getSemesterRange(Carbon $date): array
    {
        $semester = $date->month <= 6 ? 1 : 2;
        $start = Carbon::create($date->year, $semester === 1 ? 1 : 7, 1)->startOfDay();
        $end = $start->copy()->addMonths(6)->subDay()->endOfDay();

        return [$start, $end];
    }

    protected function applyEmployeeFilter($query, array $filters)
    {
        if ($filters['employe_id']) {
            $query->where('employe_id', $filters['employe_id']);
        }

        if ($filters['department_id'] || $filters['direction_id']) {
            $query->whereHas('employe', function ($query) use ($filters) {
                if ($filters['department_id']) {
                    $query->where('departement_id', $filters['department_id']);
                }

                if ($filters['direction_id']) {
                    $query->whereHas('departement', function ($query) use ($filters) {
                        $query->where('direction_id', $filters['direction_id']);
                    });
                }
            });
        }

        return $query;
    }

    protected function presenceReport(array $filters): array
    {
        [$start, $end] = $this->getDateRange($filters['period'], $filters['start_date'] ?? null, $filters['end_date'] ?? null);

        $query = Presence::with(['employe.departement.direction'])
            ->whereBetween('date_presence', [$start, $end]);

        if ($filters['status']) {
            $query->where('statut', $filters['status']);
        }

        $query = $this->applyEmployeeFilter($query, $filters);
        $records = $query->orderBy('date_presence', 'desc')->get();

        $categoryCounts = $records
            ->map(fn (Presence $presence) => $this->getPresenceCategory($presence))
            ->countBy()
            ->toArray();

        $summary = [
            'present' => $records->where('statut', 'Present')->count(),
            'absent' => $records->where('statut', 'Absent')->count(),
            'late' => $records->where('statut', 'Retard')->count(),
            'conge' => $records->where('statut', 'Conge')->count(),
            'on_time' => $categoryCounts['on_time'] ?? 0,
            'early_departure' => $categoryCounts['early_departure'] ?? 0,
            'late_arrival' => $categoryCounts['late_arrival'] ?? 0,
            'absent_unjustified' => $categoryCounts['absent_unjustified'] ?? 0,
            'justified_absence' => $categoryCounts['justified_absence'] ?? 0,
            'justified_early_departure' => $categoryCounts['justified_early_departure'] ?? 0,
            'justified_late' => $categoryCounts['justified_late'] ?? 0,
            'holiday' => $categoryCounts['holiday'] ?? 0,
            'total' => $records->count(),
        ];
        $summary['attendance_rate'] = $summary['total'] ? round(100 * ($summary['present'] / $summary['total']), 2) : 0;

        return [
            'title' => 'Rapport des présences',
            'meta' => $summary,
            'filters' => $filters,
            'legend' => $this->getPresenceCalendarLegend(),
            'calendar' => $this->buildPresenceCalendar($start, $end, $records),
            'details' => $records->map(function (Presence $presence) {
                return [
                    'date' => $presence->date_presence->format('d/m/Y'),
                    'employe' => $presence->employe->nom_complet ?? 'N/A',
                    'departement' => optional($presence->employe->departement)->nom,
                    'direction' => optional($presence->employe->departement->direction)->nom,
                    'statut' => $presence->statut,
                    'arrivee' => $presence->heure_arrivee,
                    'depart' => $presence->heure_depart,
                    'remarque' => $presence->remarque,
                ];
            })->toArray(),
        ];
    }

    protected function buildPresenceCalendar(Carbon $start, Carbon $end, $records): array
    {
        $groupedByDate = $records->groupBy(fn (Presence $presence) => $presence->date_presence->format('Y-m-d'));
        $calendarStart = $start->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $end->copy()->endOfWeek(Carbon::SUNDAY);
        $weeks = [];
        $current = $calendarStart->copy();

        while ($current->lte($calendarEnd)) {
            $week = [];

            for ($day = 0; $day < 7; $day++) {
                $dateKey = $current->format('Y-m-d');
                $dayRecords = $groupedByDate->get($dateKey, collect());
                $week[] = $this->getPresenceDaySummary($current, $dayRecords, $start, $end);
                $current->addDay();
            }

            $weeks[] = $week;
        }

        return $weeks;
    }

    protected function getPresenceDaySummary(Carbon $date, $records, Carbon $start, Carbon $end): array
    {
        $withinRange = $date->between($start, $end);
        $status = 'empty';
        $label = $withinRange ? 'Aucun' : '';
        $tooltip = $withinRange ? 'Aucune donnée de présence enregistrée' : '';

        if ($withinRange && $records->isNotEmpty()) {
            $categories = $records->map(fn (Presence $presence) => $this->getPresenceCategory($presence))->unique()->values()->toArray();
            $status = $this->pickPresenceCalendarStatus($categories);
            $label = $this->getPresenceCalendarLabel($status);
            $tooltip = implode(', ', $records->map(fn (Presence $presence) => trim($presence->statut . ' ' . ($presence->remarque ?? '')))->filter()->unique()->toArray());
        }

        return [
            'date' => $date->copy(),
            'within_range' => $withinRange,
            'status' => $status,
            'label' => $label,
            'tooltip' => $tooltip,
        ];
    }

    protected function pickPresenceCalendarStatus(array $statuses): string
    {
        $priority = [
            'holiday',
            'absent_unjustified',
            'justified_absence',
            'justified_late',
            'justified_early_departure',
            'late_arrival',
            'early_departure',
            'on_time',
            'present',
            'unknown',
        ];

        foreach ($priority as $status) {
            if (in_array($status, $statuses, true)) {
                return $status;
            }
        }

        return 'empty';
    }

    protected function getPresenceCalendarLabel(string $status): string
    {
        return match ($status) {
            'holiday' => 'Jour férié',
            'absent_unjustified' => 'Absent sans justificatif',
            'justified_absence' => 'Absence justifiée',
            'justified_late' => 'Retard justifié',
            'justified_early_departure' => 'Départ justifié avant l’heure',
            'late_arrival' => 'Arrivée en retard',
            'early_departure' => 'Départ avant l’heure',
            'on_time' => 'Présent à l’heure',
            'present' => 'Présent',
            default => 'Aucun',
        };
    }

    protected function getPresenceCategory(Presence $presence): string
    {
        $remark = strtolower($presence->remarque ?? '');
        $isJustified = str_contains($remark, 'justifié') || str_contains($remark, 'justifie');
        $isHoliday = str_contains($remark, 'féri') || str_contains($remark, 'ferie') || str_contains($remark, 'vacances');

        if ($presence->statut === 'Ferie' || $isHoliday) {
            return 'holiday';
        }

        if (in_array($presence->statut, ['Conge', 'Congé'], true) || ($presence->statut === 'Absent' && $isJustified)) {
            return 'justified_absence';
        }

        if ($presence->statut === 'Absent') {
            return 'absent_unjustified';
        }

        if ($presence->statut === 'Retard') {
            return $isJustified ? 'justified_late' : 'late_arrival';
        }

        if ($presence->statut === 'Present') {
            $arrival = $presence->heure_arrivee ? Carbon::parse($presence->heure_arrivee) : null;
            $departure = $presence->heure_depart ? Carbon::parse($presence->heure_depart) : null;
            $scheduledArrival = Carbon::parse(self::SCHEDULE_ARRIVAL);
            $scheduledDeparture = Carbon::parse(self::SCHEDULE_DEPARTURE);

            $arrivedOnTime = $arrival && $arrival->lte($scheduledArrival);
            $leftOnTime = $departure && $departure->gte($scheduledDeparture);
            $leftEarly = $departure && $departure->lt($scheduledDeparture);
            $arrivedLate = $arrival && $arrival->gt($scheduledArrival);

            if ($leftEarly && $isJustified) {
                return 'justified_early_departure';
            }

            if ($arrivedLate && $isJustified) {
                return 'justified_late';
            }

            if ($arrivedOnTime && $leftOnTime) {
                return 'on_time';
            }

            if ($arrivedOnTime && $leftEarly) {
                return 'early_departure';
            }

            if ($arrivedLate && $leftOnTime) {
                return 'late_arrival';
            }

            if ($arrivedLate && $leftEarly) {
                return $isJustified ? 'justified_late' : 'late_arrival';
            }

            return 'present';
        }

        return 'unknown';
    }

    protected function getPresenceCalendarLegend(): array
    {
        return [
            ['status' => 'on_time', 'label' => 'Présent. Arrivée et départ à l’heure', 'bg' => 'bg-emerald-500', 'text' => 'text-white'],
            ['status' => 'absent_unjustified', 'label' => 'Absent sans justificatif', 'bg' => 'bg-red-500', 'text' => 'text-white'],
            ['status' => 'early_departure', 'label' => 'Présent. Arrivée à l’heure, départ avant', 'bg' => 'bg-amber-400', 'text' => 'text-slate-900'],
            ['status' => 'late_arrival', 'label' => 'Présent. Arrivée en retard, départ à l’heure', 'bg' => 'bg-orange-500', 'text' => 'text-white'],
            ['status' => 'justified_absence', 'label' => 'Absence justifiée', 'bg' => 'bg-slate-900', 'text' => 'text-white'],
            ['status' => 'justified_early_departure', 'label' => 'Départ justifié avant l’heure', 'bg' => 'bg-sky-300', 'text' => 'text-slate-900'],
            ['status' => 'justified_late', 'label' => 'Retard justifié', 'bg' => 'bg-sky-900', 'text' => 'text-white'],
            ['status' => 'holiday', 'label' => 'Jour férié', 'bg' => 'bg-violet-600', 'text' => 'text-white'],
            ['status' => 'empty', 'label' => 'Aucun enregistrement', 'bg' => 'bg-slate-100', 'text' => 'text-slate-500'],
        ];
    }

    protected function evaluationReport(array $filters): array
    {
        [$start, $end] = $this->getDateRange($filters['period'], $filters['start_date'] ?? null, $filters['end_date'] ?? null);

        $query = Evaluation::with(['employe'])
            ->whereBetween('date_evaluation', [$start, $end]);

        $query = $this->applyEmployeeFilter($query, $filters);
        $records = $query->orderBy('date_evaluation', 'desc')->get();

        $average = $records->avg('note_totale') ? round($records->avg('note_totale'), 2) : 0;

        $criteriaScores = DB::table('evaluation_criteres')
            ->join('evaluations', 'evaluation_criteres.evaluation_id', '=', 'evaluations.id')
            ->join('criteres', 'evaluation_criteres.critere_id', '=', 'criteres.id')
            ->join('employes', 'evaluations.employe_matricule', '=', 'employes.matricule')
            ->when($filters['department_id'], fn($q) => $q->where('employes.departement_id', $filters['department_id']))
            ->when($filters['direction_id'], fn($q) => $q->join('departements', 'employes.departement_id', '=', 'departements.id')
                ->where('departements.direction_id', $filters['direction_id']))
            ->select('criteres.nom as critere', DB::raw('AVG(evaluation_criteres.note) as average_score'), DB::raw('COUNT(*) as total'))
            ->groupBy('criteres.id', 'criteres.nom')
            ->orderByDesc('average_score')
            ->get()
            ->toArray();

        $employeeRanking = $records->groupBy('employe_matricule')->map(function ($group) {
            $employee = $group->first()->employe;
            return [
                'employe' => $employee->nom_complet ?? 'N/A',
                'matricule' => $employee->matricule ?? 'N/A',
                'average_score' => round($group->avg('note_totale'), 2),
                'evaluations' => $group->count(),
            ];
        })->sortByDesc('average_score')->values()->toArray();

        return [
            'title' => 'Rapport des évaluations',
            'meta' => [
                'average_score' => $average,
                'evaluations_count' => $records->count(),
            ],
            'filters' => $filters,
            'criteria' => $criteriaScores,
            'ranking' => $employeeRanking,
            'details' => $records->map(function (Evaluation $evaluation) {
                return [
                    'date' => $evaluation->date_evaluation->format('d/m/Y'),
                    'employe' => $evaluation->employe->nom_complet ?? 'N/A',
                    'note' => $evaluation->note_totale,
                    'commentaire' => $evaluation->commentaire,
                ];
            })->toArray(),
        ];
    }

    protected function departmentReport(array $filters): array
    {
        $departments = Departement::with('direction', 'employes')
            ->when($filters['department_id'], fn($q) => $q->where('id', $filters['department_id']))
            ->when($filters['direction_id'], fn($q) => $q->where('direction_id', $filters['direction_id']))
            ->get();

        $details = $departments->map(function (Departement $department) use ($filters) {
            $employeeIds = $department->employes->pluck('id')->toArray();
            $presences = Presence::whereIn('employe_id', $employeeIds)->get();
            $evaluations = Evaluation::whereIn('employe_matricule', $department->employes->pluck('matricule')->toArray())->get();

            $present = $presences->where('statut', 'Present')->count();
            $total = $presences->count();
            $presenceRate = $total ? round(100 * ($present / $total), 2) : 0;
            $averageScore = $evaluations->avg('note_totale') ? round($evaluations->avg('note_totale'), 2) : 0;

            return [
                'departement' => $department->nom,
                'direction' => $department->direction->nom ?? 'N/A',
                'employees' => $department->employes->count(),
                'presence_rate' => $presenceRate,
                'average_score' => $averageScore,
                'retards' => $presences->where('statut', 'Retard')->count(),
                'absences' => $presences->where('statut', 'Absent')->count(),
            ];
        })->toArray();

        return [
            'title' => 'Rapport des départements',
            'meta' => [
                'count' => count($details),
            ],
            'filters' => $filters,
            'details' => $details,
        ];
    }

    protected function directionReport(array $filters): array
    {
        $directions = Direction::with('departements.employes')
            ->when($filters['direction_id'], fn($q) => $q->where('id', $filters['direction_id']))
            ->get();

        $details = $directions->map(function (Direction $direction) {
            $employeeIds = $direction->departements->flatMap(fn ($departement) => $departement->employes->pluck('id'))->unique()->toArray();
            $presences = Presence::whereIn('employe_id', $employeeIds)->get();
            $evaluations = Evaluation::whereIn('employe_matricule', Employe::whereIn('id', $employeeIds)->pluck('matricule'))->get();

            $present = $presences->where('statut', 'Present')->count();
            $total = $presences->count();
            $presenceRate = $total ? round(100 * ($present / $total), 2) : 0;
            $averageScore = $evaluations->avg('note_totale') ? round($evaluations->avg('note_totale'), 2) : 0;

            return [
                'direction' => $direction->nom,
                'employees' => count($employeeIds),
                'presence_rate' => $presenceRate,
                'average_score' => $averageScore,
                'retards' => $presences->where('statut', 'Retard')->count(),
                'absences' => $presences->where('statut', 'Absent')->count(),
            ];
        })->toArray();

        return [
            'title' => 'Rapport des directions',
            'meta' => [
                'count' => count($details),
            ],
            'filters' => $filters,
            'details' => $details,
        ];
    }

    protected function employeeReport(array $filters): array
    {
        $employee = Employe::with(['departement.direction', 'presences', 'evaluations.criteres.critere'])
            ->findOrFail($filters['employe_id']);

        $presences = $employee->presences->map(function (Presence $presence) {
            return [
                'date' => $presence->date_presence->format('d/m/Y'),
                'statut' => $presence->statut,
                'arrivee' => $presence->heure_arrivee,
                'depart' => $presence->heure_depart,
                'remarque' => $presence->remarque,
            ];
        })->toArray();

        $evaluations = $employee->evaluations->map(function (Evaluation $evaluation) {
            return [
                'date' => $evaluation->date_evaluation->format('d/m/Y'),
                'note' => $evaluation->note_totale,
                'commentaire' => $evaluation->commentaire,
            ];
        })->toArray();

        $averageScore = $employee->evaluations->avg('note_totale') ? round($employee->evaluations->avg('note_totale'), 2) : 0;
        $performance = $averageScore;

        return [
            'title' => 'Rapport employé',
            'meta' => [
                'employe' => $employee->nom_complet,
                'matricule' => $employee->matricule,
                'departement' => optional($employee->departement)->nom,
                'direction' => optional($employee->departement->direction)->nom,
                'average_score' => $averageScore,
                'present' => collect($presences)->where('statut', 'Present')->count(),
                'absent' => collect($presences)->where('statut', 'Absent')->count(),
                'late' => collect($presences)->where('statut', 'Retard')->count(),
                'performance' => $performance,
            ],
            'filters' => $filters,
            'presences' => $presences,
            'evaluations' => $evaluations,
        ];
    }
}
