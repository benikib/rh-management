<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Mission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MissionController extends Controller
{
    public function index(): View
    {
        $missions = Mission::with('employe')->latest()->paginate(10);

        return view('missions.index', compact('missions'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('missions.create', compact('employes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lieu' => 'nullable|string|max:255',
            'motif' => 'nullable|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'frais_montant' => 'nullable|numeric|min:0',
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
            'observations' => 'nullable|string',
        ]);

        Mission::create($validated);

        return redirect()->route('missions.index')->with('success', 'Mission enregistrée avec succès.');
    }

    public function show(Mission $mission): View
    {
        $mission->load('employe');

        return view('missions.show', compact('mission'));
    }

    public function edit(Mission $mission): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('missions.edit', compact('mission', 'employes'));
    }

    public function update(Request $request, Mission $mission): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lieu' => 'nullable|string|max:255',
            'motif' => 'nullable|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'frais_montant' => 'nullable|numeric|min:0',
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
            'observations' => 'nullable|string',
        ]);

        $mission->update($validated);

        return redirect()->route('missions.index')->with('success', 'Mission mise à jour avec succès.');
    }

    public function destroy(Mission $mission): RedirectResponse
    {
        $mission->delete();

        return redirect()->route('missions.index')->with('success', 'Mission supprimée avec succès.');
    }
}
