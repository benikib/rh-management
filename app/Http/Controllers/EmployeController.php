<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use App\Models\Departement;
use App\Models\Employe;
use App\Models\EmployeeStatus;
use App\Models\Poste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployeController extends Controller
{
    public function index(): View
    {
        $employes = Employe::with([
            'departement',
            'poste',
            'contracts' => function ($query) {
                $query->where('is_active', true)->with('contractType');
            },
        ])->latest()->paginate(10);

        return view('employes.index', compact('employes'));
    }

    public function create(): View
    {
        $departements = Departement::orderBy('nom', 'asc')->get();
        $postes = Poste::orderBy('titre', 'asc')->get();
        $contractTypes = ContractType::orderBy('label', 'asc')->get();
        $employeeStatuses = EmployeeStatus::orderBy('label', 'asc')->get();

        return view('employes.create', compact('departements', 'postes', 'contractTypes', 'employeeStatuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEmploye($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employes/photos', 'public');
        }

        $employe = Employe::create($validated);
        $this->createOrUpdateContract($employe, $validated);

        return redirect()->route('employes.index')->with('success', 'Employé créé avec succès.');
    }

    public function show(Employe $employe): View
    {
        $employe->load([
            'departement',
            'poste',
            'presences',
            'conges',
            'documents',
            'carrieres',
            'contracts.contractType',
            'familyInfo.dependents',
        ])->loadCount(['positionHistory', 'historyLogs', 'dependents']);

        return view('employes.show', compact('employe'));
    }

    public function edit(Employe $employe): View
    {
        $departements = Departement::orderBy('nom', 'asc')->get();
        $postes = Poste::orderBy('titre', 'asc')->get();
        $contractTypes = ContractType::orderBy('label', 'asc')->get();
        $employeeStatuses = EmployeeStatus::orderBy('label', 'asc')->get();

        return view('employes.edit', compact('employe', 'departements', 'postes', 'contractTypes', 'employeeStatuses'));
    }

    public function update(Request $request, Employe $employe): RedirectResponse
    {
        $validated = $this->validateEmploye($request, $employe);

        if ($request->hasFile('photo')) {
            if ($employe->photo) {
                Storage::disk('public')->delete($employe->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employes/photos', 'public');
        }

        $employe->update($validated);
        $this->createOrUpdateContract($employe, $validated);

        return redirect()->route('employes.index')->with('success', 'Employé mis à jour avec succès.');
    }

    public function destroy(Employe $employe): RedirectResponse
    {
        if ($employe->photo) {
            Storage::disk('public')->delete($employe->photo);
        }

        $employe->delete();

        return redirect()->route('employes.index')->with('success', 'Employé supprimé avec succès.');
    }

    private function validateEmploye(Request $request, ?Employe $employe = null): array
    {
        $employeId = $employe?->id;

        return $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'poste_id' => 'required|exists:postes,id',
            'contract_type_id' => 'required|exists:contract_types,id',
            'status_id' => 'nullable|exists:employee_statuses,id',
            'matricule' => 'required|string|max:255|unique:employes,matricule,'.$employeId,
            'nom' => 'required|string|max:255',
            'postnom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:Masculin,Feminin',
            'date_naissance' => 'nullable|date',
            'telephone' => 'nullable|string|max:50',
            'email' => 'required|email|unique:employes,email,'.$employeId,
            'adresse' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'date_embauche' => 'required|date',
            'salaire_base' => 'required|numeric|min:0',
            'statut' => 'required|in:Actif,Inactif',
        ]);
    }

    private function createOrUpdateContract(Employe $employe, array $validated): void
    {
        $contractData = [
            'contract_type_id' => $validated['contract_type_id'],
            'start_date' => $validated['date_embauche'],
            'salary' => $validated['salaire_base'],
            'is_active' => true,
        ];

        $activeContract = $employe->contracts()->where('is_active', true)->latest()->first();

        if ($activeContract) {
            $activeContract->update($contractData);
        } else {
            $employe->contracts()->create($contractData);
        }
    }
}
