<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\EmployeePositionHistory;
use App\Models\Employe;
use App\Models\Poste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeePositionHistoryController extends Controller
{
    public function index(): View
    {
        $histories = EmployeePositionHistory::with(['employe', 'poste', 'departement'])->latest()->paginate(10);

        return view('employee_position_history.index', compact('histories'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();
        $postes = Poste::orderBy('titre')->get();
        $departements = Departement::orderBy('nom')->get();

        return view('employee_position_history.create', compact('employes', 'postes', 'departements'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'poste_id' => 'required|exists:postes,id',
            'departement_id' => 'required|exists:departements,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'observations' => 'nullable|string',
            'supervisor_name' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        EmployeePositionHistory::create($validated);

        return redirect()->route('employee-position-history.index')->with('success', 'Historique de poste ajouté avec succès.');
    }

    public function show(EmployeePositionHistory $employeePositionHistory): View
    {
        $employeePositionHistory->load(['employe', 'poste', 'departement']);

        return view('employee_position_history.show', compact('employeePositionHistory'));
    }

    public function edit(EmployeePositionHistory $employeePositionHistory): View
    {
        $employes = Employe::orderBy('nom')->get();
        $postes = Poste::orderBy('titre')->get();
        $departements = Departement::orderBy('nom')->get();

        return view('employee_position_history.edit', compact('employeePositionHistory', 'employes', 'postes', 'departements'));
    }

    public function update(Request $request, EmployeePositionHistory $employeePositionHistory): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'poste_id' => 'required|exists:postes,id',
            'departement_id' => 'required|exists:departements,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'observations' => 'nullable|string',
            'supervisor_name' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $employeePositionHistory->update($validated);

        return redirect()->route('employee-position-history.index')->with('success', 'Historique de poste mis à jour avec succès.');
    }

    public function destroy(EmployeePositionHistory $employeePositionHistory): RedirectResponse
    {
        $employeePositionHistory->delete();

        return redirect()->route('employee-position-history.index')->with('success', 'Historique de poste supprimé avec succès.');
    }
}
