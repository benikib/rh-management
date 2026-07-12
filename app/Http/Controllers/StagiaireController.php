<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employe;
use App\Models\Stagiaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StagiaireController extends Controller
{
    public function index(): View
    {
        $stagiaires = Stagiaire::with(['departement', 'encadrant'])->latest()->paginate(10);

        return view('stagiaires.index', compact('stagiaires'));
    }

    public function create(): View
    {
        $departements = Departement::orderBy('nom')->get();
        $employes = Employe::where('statut', 'Actif')->orderBy('nom')->get();

        return view('stagiaires.create', compact('departements', 'employes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateStagiaire($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('stagiaires/photos', 'public');
        }

        Stagiaire::create($validated);

        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire créé avec succès.');
    }

    public function show(Stagiaire $stagiaire): View
    {
        $stagiaire->load(['departement', 'encadrant']);

        return view('stagiaires.show', compact('stagiaire'));
    }

    public function edit(Stagiaire $stagiaire): View
    {
        $departements = Departement::orderBy('nom')->get();
        $employes = Employe::where('statut', 'Actif')->orderBy('nom')->get();

        return view('stagiaires.edit', compact('stagiaire', 'departements', 'employes'));
    }

    public function update(Request $request, Stagiaire $stagiaire): RedirectResponse
    {
        $validated = $this->validateStagiaire($request, $stagiaire);

        if ($request->hasFile('photo')) {
            if ($stagiaire->photo) {
                Storage::disk('public')->delete($stagiaire->photo);
            }
            $validated['photo'] = $request->file('photo')->store('stagiaires/photos', 'public');
        }

        $stagiaire->update($validated);

        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire mis à jour avec succès.');
    }

    public function destroy(Stagiaire $stagiaire): RedirectResponse
    {
        if ($stagiaire->photo) {
            Storage::disk('public')->delete($stagiaire->photo);
        }

        $stagiaire->delete();

        return redirect()->route('stagiaires.index')->with('success', 'Stagiaire supprimé avec succès.');
    }

    private function validateStagiaire(Request $request, ?Stagiaire $stagiaire = null): array
    {
        return $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'nom' => 'required|string|max:255',
            'postnom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:Masculin,Feminin',
            'date_naissance' => 'required|date',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'universite' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'date_debut_stage' => 'required|date',
            'date_fin_stage' => 'required|date|after_or_equal:date_debut_stage',
            'encadrant_id' => 'nullable|exists:employes,id',
            'observations' => 'nullable|string|max:1000',
            'statut' => 'required|in:En cours,Terminé,Suspendu',
        ]);
    }
}
