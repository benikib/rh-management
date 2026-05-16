<?php

namespace App\Http\Controllers;

use App\Models\Carriere;
use App\Models\Employe;
use App\Models\Poste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarriereController extends Controller
{
    public function index(): View
    {
        $carrieres = Carriere::with(['employe', 'ancienPoste', 'nouveauPoste'])->latest()->paginate(10);

        return view('carrieres.index', compact('carrieres'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();
        $postes = Poste::orderBy('titre')->get();

        return view('carrieres.create', compact('employes', 'postes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'ancien_poste_id' => 'nullable|exists:postes,id',
            'nouveau_poste_id' => 'required|exists:postes,id',
            'type_mouvement' => 'required|in:Promotion,Mutation',
            'date_changement' => 'required|date',
            'commentaire' => 'nullable|string',
        ]);

        Carriere::create($validated);

        return redirect()->route('carrieres.index')->with('success', 'Mouvement de carrière enregistré avec succès.');
    }

    public function show(Carriere $carriere): View
    {
        $carriere->load(['employe', 'ancienPoste', 'nouveauPoste']);

        return view('carrieres.show', compact('carriere'));
    }

    public function edit(Carriere $carriere): View
    {
        $employes = Employe::orderBy('nom')->get();
        $postes = Poste::orderBy('titre')->get();

        return view('carrieres.edit', compact('carriere', 'employes', 'postes'));
    }

    public function update(Request $request, Carriere $carriere): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'ancien_poste_id' => 'nullable|exists:postes,id',
            'nouveau_poste_id' => 'required|exists:postes,id',
            'type_mouvement' => 'required|in:Promotion,Mutation',
            'date_changement' => 'required|date',
            'commentaire' => 'nullable|string',
        ]);

        $carriere->update($validated);

        return redirect()->route('carrieres.index')->with('success', 'Mouvement de carrière mis à jour avec succès.');
    }

    public function destroy(Carriere $carriere): RedirectResponse
    {
        $carriere->delete();

        return redirect()->route('carrieres.index')->with('success', 'Mouvement de carrière supprimé avec succès.');
    }
}
