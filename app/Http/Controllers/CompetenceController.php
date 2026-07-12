<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompetenceController extends Controller
{
    public function index(): View
    {
        $competences = Competence::latest()->paginate(10);

        return view('competences.index', compact('competences'));
    }

    public function create(): View
    {
        return view('competences.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:competences,nom',
            'description' => 'nullable|string|max:1000',
            'categorie' => 'nullable|string|max:255',
            'statut' => 'required|in:Active,Inactive',
        ]);

        Competence::create($validated);

        return redirect()->route('competences.index')->with('success', 'Compétence créée avec succès.');
    }

    public function show(Competence $competence): View
    {
        $competence->load(['formations', 'employes']);

        return view('competences.show', compact('competence'));
    }

    public function edit(Competence $competence): View
    {
        return view('competences.edit', compact('competence'));
    }

    public function update(Request $request, Competence $competence): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:competences,nom,' . $competence->id,
            'description' => 'nullable|string|max:1000',
            'categorie' => 'nullable|string|max:255',
            'statut' => 'required|in:Active,Inactive',
        ]);

        $competence->update($validated);

        return redirect()->route('competences.index')->with('success', 'Compétence mise à jour avec succès.');
    }

    public function destroy(Competence $competence): RedirectResponse
    {
        $competence->delete();

        return redirect()->route('competences.index')->with('success', 'Compétence supprimée avec succès.');
    }
}
