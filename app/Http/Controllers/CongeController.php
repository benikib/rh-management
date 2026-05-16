<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CongeController extends Controller
{
    public function index(): View
    {
        $conges = Conge::with('employe')->latest()->paginate(10);

        return view('conges.index', compact('conges'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('conges.create', compact('employes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'type_conge' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'nullable|string',
            'statut' => 'required|in:En attente,Valide,Refuse',
        ]);

        Conge::create($validated);

        return redirect()->route('conges.index')->with('success', 'Congé enregistré avec succès.');
    }

    public function show(Conge $conge): View
    {
        $conge->load('employe');

        return view('conges.show', compact('conge'));
    }

    public function edit(Conge $conge): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('conges.edit', compact('conge', 'employes'));
    }

    public function update(Request $request, Conge $conge): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'type_conge' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'nullable|string',
            'statut' => 'required|in:En attente,Valide,Refuse',
        ]);

        $conge->update($validated);

        return redirect()->route('conges.index')->with('success', 'Congé mis à jour avec succès.');
    }

    public function destroy(Conge $conge): RedirectResponse
    {
        $conge->delete();

        return redirect()->route('conges.index')->with('success', 'Congé supprimé avec succès.');
    }
}
