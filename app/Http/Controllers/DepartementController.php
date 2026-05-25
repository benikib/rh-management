<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Direction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartementController extends Controller
{
    public function index(): View
    {
        $departements = Departement::with('direction')->latest()->paginate(10);

        return view('departements.index', compact('departements'));
    }

    public function create(): View
    {
        $directions = Direction::orderBy('nom')->get();

        return view('departements.create', compact('directions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'direction_id' => 'required|exists:directions,id',
        ]);

        Departement::create($validated);

        return redirect()->route('departements.index')->with('success', 'Département créé avec succès.');
    }

    public function show(Departement $departement): View
    {
        $departement->load('employes.poste', 'direction');

        return view('departements.show', compact('departement'));
    }

    public function edit(Departement $departement): View
    {
        $directions = Direction::orderBy('nom')->get();

        return view('departements.edit', compact('departement', 'directions'));
    }

    public function update(Request $request, Departement $departement): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'direction_id' => 'required|exists:directions,id',
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
