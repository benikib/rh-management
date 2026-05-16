<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PosteController extends Controller
{
    public function index(): View
    {
        $postes = Poste::latest()->paginate(10);

        return view('postes.index', compact('postes'));
    }

    public function create(): View
    {
        return view('postes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'salaire_reference' => 'nullable|numeric|min:0',
        ]);

        Poste::create($validated);

        return redirect()->route('postes.index')->with('success', 'Poste créé avec succès.');
    }

    public function show(Poste $poste): View
    {
        $poste->load('employes.departement');

        return view('postes.show', compact('poste'));
    }

    public function edit(Poste $poste): View
    {
        return view('postes.edit', compact('poste'));
    }

    public function update(Request $request, Poste $poste): RedirectResponse
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'salaire_reference' => 'nullable|numeric|min:0',
        ]);

        $poste->update($validated);

        return redirect()->route('postes.index')->with('success', 'Poste mis à jour avec succès.');
    }

    public function destroy(Poste $poste): RedirectResponse
    {
        $poste->delete();

        return redirect()->route('postes.index')->with('success', 'Poste supprimé avec succès.');
    }
}
