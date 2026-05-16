<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartementController extends Controller
{
    public function index(): View
    {
        $departements = Departement::latest()->paginate(10);

        return view('departements.index', compact('departements'));
    }

    public function create(): View
    {
        return view('departements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Departement::create($validated);

        return redirect()->route('departements.index')->with('success', 'Département créé avec succès.');
    }

    public function show(Departement $departement): View
    {
        $departement->load('employes.poste');

        return view('departements.show', compact('departement'));
    }

    public function edit(Departement $departement): View
    {
        return view('departements.edit', compact('departement'));
    }

    public function update(Request $request, Departement $departement): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $departement->update($validated);

        return redirect()->route('departements.index')->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Departement $departement): RedirectResponse
    {
        $departement->delete();

        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès.');
    }
}
