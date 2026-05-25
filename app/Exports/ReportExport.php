<?php

namespace App\Exports;

use App\Exports\ReportSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets, ShouldAutoSize
{
    public function __construct(protected array $reportData)
    {
    }

    public function sheets(): array
    {
        $sheets = [];

        $metaRows = collect($this->reportData['meta'])->map(function ($value, $key) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
            return [ucfirst(str_replace('_', ' ', $key)), $value];
        })->toArray();

        $sheets[] = new ReportSheet('Résumé', ['Clé', 'Valeur'], $metaRows);

        if (! empty($this->reportData['details'])) {
            $details = $this->reportData['details'];
            $headers = array_keys((array) ($details[0] ?? []));
            $rows = array_map(fn ($row) => array_values((array) $row), $details);
            $sheets[] = new ReportSheet('Détails', $headers, $rows);
        }

        if (! empty($this->reportData['criteria'])) {
            $criteria = $this->reportData['criteria'];
            $headers = array_keys((array) ($criteria[0] ?? []));
            $rows = array_map(fn ($row) => array_values((array) $row), $criteria);
            $sheets[] = new ReportSheet('Critères', $headers, $rows);
        }

        if (! empty($this->reportData['ranking'])) {
            $ranking = $this->reportData['ranking'];
            $headers = array_keys((array) ($ranking[0] ?? []));
            $rows = array_map(fn ($row) => array_values((array) $row), $ranking);
            $sheets[] = new ReportSheet('Classement', $headers, $rows);
        }

        if (! empty($this->reportData['presences'])) {
            $presences = $this->reportData['presences'];
            $headers = array_keys((array) ($presences[0] ?? []));
            $rows = array_map(fn ($row) => array_values((array) $row), $presences);
            $sheets[] = new ReportSheet('Présences', $headers, $rows);
        }

        if (! empty($this->reportData['evaluations'])) {
            $evaluations = $this->reportData['evaluations'];
            $headers = array_keys((array) ($evaluations[0] ?? []));
            $rows = array_map(fn ($row) => array_values((array) $row), $evaluations);
            $sheets[] = new ReportSheet('Évaluations', $headers, $rows);
        }

        return $sheets;
    }
}
