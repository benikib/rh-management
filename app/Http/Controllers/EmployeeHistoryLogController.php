<?php

namespace App\Http\Controllers;

use App\Models\EmployeeHistoryLog;
use App\Models\EmployeeStatus;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeHistoryLogController extends Controller
{
    protected array $eventTypeOptions = [
        'hired' => 'Embauche',
        'promoted' => 'Promotion',
        'transferred' => 'Mutation',
        'demoted' => 'Rétrogradation',
        'formation' => 'Formation',
        'leave_medical' => 'Arrêt maladie',
        'leave_extended' => 'Absence prolongée',
        'deceased' => 'Décédé',
        'retired' => 'Retraité',
        'dismissed' => 'Renvoyé',
        'resigned' => 'Démissionné',
        'disciplinary' => 'Sanction disciplinaire',
        'reactivated' => 'Réactivé',
    ];

    public function index(): View
    {
        $logs = EmployeeHistoryLog::with(['employe', 'status', 'recordedBy'])->latest()->paginate(10);

        return view('employee_history_logs.index', compact('logs'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();
        $statuses = EmployeeStatus::orderBy('label')->get();
        $users = User::orderBy('name')->get();
        $eventTypeOptions = $this->eventTypeOptions;

        return view('employee_history_logs.create', compact('employes', 'statuses', 'users', 'eventTypeOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'event_type' => 'required|string|max:100',
            'event_date' => 'required|date',
            'status_id' => 'nullable|exists:employee_statuses,id',
            'reason' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
            'recorded_by_id' => 'nullable|exists:users,id',
        ]);

        $validated['recorded_by_id'] = $validated['recorded_by_id'] ?? auth()->id();

        EmployeeHistoryLog::create($validated);

        return redirect()->route('employee-history-logs.index')->with('success', 'Journal RH enregistré avec succès.');
    }

    public function show(EmployeeHistoryLog $employeeHistoryLog): View
    {
        $employeeHistoryLog->load(['employe', 'status', 'recordedBy']);

        return view('employee_history_logs.show', compact('employeeHistoryLog'));
    }

    public function edit(EmployeeHistoryLog $employeeHistoryLog): View
    {
        $employes = Employe::orderBy('nom')->get();
        $statuses = EmployeeStatus::orderBy('label')->get();
        $users = User::orderBy('name')->get();
        $eventTypeOptions = $this->eventTypeOptions;

        return view('employee_history_logs.edit', compact('employeeHistoryLog', 'employes', 'statuses', 'users', 'eventTypeOptions'));
    }

    public function update(Request $request, EmployeeHistoryLog $employeeHistoryLog): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'event_type' => 'required|string|max:100',
            'event_date' => 'required|date',
            'status_id' => 'nullable|exists:employee_statuses,id',
            'reason' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
            'recorded_by_id' => 'nullable|exists:users,id',
        ]);

        $validated['recorded_by_id'] = $validated['recorded_by_id'] ?? auth()->id();

        $employeeHistoryLog->update($validated);

        return redirect()->route('employee-history-logs.index')->with('success', 'Journal RH mis à jour avec succès.');
    }

    public function destroy(EmployeeHistoryLog $employeeHistoryLog): RedirectResponse
    {
        $employeeHistoryLog->delete();

        return redirect()->route('employee-history-logs.index')->with('success', 'Journal RH supprimé avec succès.');
    }
}
