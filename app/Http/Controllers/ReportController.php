<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport as ReportExcelExport;
use App\Http\Requests\ReportRequest;
use App\Models\ReportExport;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class ReportController extends Controller
{
    public function __construct(protected ReportService $service)
    {
    }

    public function index(): \Illuminate\Contracts\View\View
    {
        $reportTypes = $this->service->getReportTypes();
        $periods = $this->service->getPeriodOptions();
        $departments = Departement::all();
        $directions = Direction::all();
        $employees = Employe::orderBy('nom')->get();
        $history = ReportExport::latest()->paginate(10);

        return view('reports.index', compact('reportTypes', 'periods', 'departments', 'directions', 'employees', 'history'));
    }

    public function preview(ReportRequest $request)
    {
        $filters = $this->service->normalizeFilters($request->validated());
        $report = $this->service->getReportData($filters);
        $reportName = $this->service->getReportName($filters);
        $reportTypes = $this->service->getReportTypes();
        $periods = $this->service->getPeriodOptions();
        $departments = Departement::all();
        $directions = Direction::all();
        $employees = Employe::orderBy('nom')->get();
        $history = ReportExport::latest()->paginate(10);

        return view('reports.index', compact(
            'reportTypes',
            'periods',
            'departments',
            'directions',
            'employees',
            'history',
            'report',
            'filters',
            'reportName'
        ));
    }

  public function exportPdf(ReportRequest $request)
{
    $filters = $this->service->normalizeFilters(
        $request->validated()
    );

    $reportData = $this->service->getReportData($filters);

    $fileName = $this->service->getReportFileName(
        $filters,
        'pdf'
    );

    // Sécuriser le nom du fichier
    $fileName = \Illuminate\Support\Str::ascii($fileName);
    $fileName = preg_replace('/[^A-Za-z0-9._-]/', '-', $fileName);
    $fileName = preg_replace('/-+/', '-', $fileName);
    $fileName = trim($fileName, '-');

    $pdf = Pdf::loadView(
        'reports.pdf.report',
        compact('reportData', 'filters')
    )->setPaper('a4', 'portrait');

    $disk = Storage::disk('public');

    $disk->makeDirectory('reports');

    $path = "reports/{$fileName}";

    // Générer et enregistrer le PDF
    $disk->put($path, $pdf->output());

    // Vérification
    if (!$disk->exists($path)) {
        throw new \Exception(
            "Le fichier PDF n'a pas été créé : {$path}"
        );
    }

    // Enregistrer l'export
    ReportExport::create([
        'uuid' => (string) \Illuminate\Support\Str::uuid(),
        'report_type' => $filters['report_type'],
        'report_name' => $this->service->getReportName($filters),
        'file_name' => $fileName,
        'file_path' => $path,
        'file_type' => 'pdf',
        'filters' => $filters,
        'department_id' => $filters['department_id'] ?? null,
        'direction_id' => $filters['direction_id'] ?? null,
        'employe_id' => $filters['employe_id'] ?? null,
        'generated_by' => Auth::id(),
        'status' => 'generated',
    ]);

    // Télécharger
    return $disk->download($path, $fileName);
}

    public function exportExcel(ReportRequest $request)
    {
        $filters = $this->service->normalizeFilters($request->validated());
        $fileName = $this->service->getReportFileName($filters, 'xlsx');
        $path = "reports/{$fileName}";

        Storage::makeDirectory('reports');
        $export = new ReportExcelExport($this->service->getReportData($filters));
        \Maatwebsite\Excel\Facades\Excel::store($export, $path, 'local');

        ReportExport::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'report_type' => $filters['report_type'],
            'report_name' => $this->service->getReportName($filters),
            'file_name' => $fileName,
            'file_path' => $path,
            'file_type' => 'xlsx',
            'filters' => $filters,
            'department_id' => $filters['department_id'],
            'direction_id' => $filters['direction_id'],
            'employe_id' => $filters['employe_id'],
            'generated_by' => Auth::id(),
            'status' => 'generated',
        ]);

        return Storage::download($path, $fileName);
    }

    public function download(ReportExport $report)
    {
        if (! Storage::exists($report->file_path)) {
            return back()->with('error', 'Le fichier de rapport est introuvable.');
        }

        return Storage::download($report->file_path, $report->file_name);
    }

    public function destroy(ReportExport $report): RedirectResponse
    {
        if (Storage::exists($report->file_path)) {
            Storage::delete($report->file_path);
        }

        $report->delete();

        return back()->with('success', 'Rapport supprimé avec succès.');
    }

    public function regenerate(ReportExport $report)
    {
        $filters = $report->filters;
        $reportData = $this->service->getReportData($filters);
        $fileName = $this->service->getReportFileName($filters, $report->file_type);
        $path = "reports/{$fileName}";
        Storage::makeDirectory('reports');

        if ($report->file_type === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.report', compact('reportData', 'filters'))
                ->setPaper('a4', 'portrait');
            Storage::put($path, $pdf->output());
        } else {
            $export = new ReportExcelExport($reportData);
            \Maatwebsite\Excel\Facades\Excel::store($export, $path, 'local');
        }

        if (Storage::exists($report->file_path)) {
            Storage::delete($report->file_path);
        }

        $report->update([
            'file_name' => $fileName,
            'file_path' => $path,
            'status' => 'generated',
        ]);

        return back()->with('success', 'Rapport régénéré avec succès.');
    }
}
