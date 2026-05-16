<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employe;
use App\Models\Poste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployeController extends Controller
{
    public function index(): View
    {
        $employes = Employe::with(['departement', 'poste'])->latest()->paginate(10);

        return view('employes.index', compact('employes'));
    }

    public function create(): View
    {
        $departements = Departement::orderBy('nom')->get();
        $postes = Poste::orderBy('titre')->get();

        return view('employes.create', compact('departements', 'postes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEmploye($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employes/photos', 'public');
        }

        Employe::create($validated);

        return redirect()->route('employes.index')->with('success', 'Employé créé avec succès.');
    }

    public function show(Employe $employe): View
    {
        $employe->load(['departement', 'poste', 'presences', 'conges', 'documents', 'carrieres']);

        return view('employes.show', compact('employe'));
    }

    public function edit(Employe $employe): View
    {
        $departements = Departement::orderBy('nom')->get();
        $postes = Poste::orderBy('titre')->get();

        return view('employes.edit', compact('employe', 'departements', 'postes'));
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
}
