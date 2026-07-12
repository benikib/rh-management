<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Formation;
use App\Models\Competence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FormationController extends Controller
{
    public function index(): View
    {
        $formations = Formation::with(['employe', 'competences'])->latest()->paginate(10);

        return view('formations.index', compact('formations'));
    }

    public function create(): View
    {
        $employes = Employe::where('statut', 'Actif')->orderBy('nom')->get();
        $competences = Competence::where('statut', 'Active')->orderBy('nom')->get();

        return view('formations.create', compact('employes', 'competences'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateFormation($request);

        if ($request->hasFile('certificat')) {
            $validated['certificat'] = $request->file('certificat')->store('formations/certificats', 'public');
        }

        $formation = Formation::create($validated);

        if ($request->has('competences') && is_array($request->input('competences'))) {
            $formation->competences()->sync($request->input('competences'));
        }

        return redirect()->route('formations.index')->with('success', 'Formation créée avec succès.');
    }

    public function show(Formation $formation): View
    {
        $formation->load(['employe', 'competences']);

        return view('formations.show', compact('formation'));
    }

    public function edit(Formation $formation): View
    {
        $employes = Employe::where('statut', 'Actif')->orderBy('nom')->get();
        $competences = Competence::where('statut', 'Active')->orderBy('nom')->get();
        $selectedCompetences = $formation->competences()->pluck('competence_id')->toArray();

        return view('formations.edit', compact('formation', 'employes', 'competences', 'selectedCompetences'));
    }

    public function update(Request $request, Formation $formation): RedirectResponse
    {
        $validated = $this->validateFormation($request, $formation);

        if ($request->hasFile('certificat')) {
            if ($formation->certificat) {
                Storage::disk('public')->delete($formation->certificat);
            }
            $validated['certificat'] = $request->file('certificat')->store('formations/certificats', 'public');
        }

        $formation->update($validated);

        if ($request->has('competences') && is_array($request->input('competences'))) {
            $formation->competences()->sync($request->input('competences'));
        } else {
            $formation->competences()->detach();
        }

        return redirect()->route('formations.index')->with('success', 'Formation mise à jour avec succès.');
    }

    public function destroy(Formation $formation): RedirectResponse
    {
        if ($formation->certificat) {
            Storage::disk('public')->delete($formation->certificat);
        }

        $formation->delete();

        return redirect()->route('formations.index')->with('success', 'Formation supprimée avec succès.');
    }

    private function validateFormation(Request $request, ?Formation $formation = null): array
    {
        return $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'organisme_formation' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'duree_heures' => 'nullable|integer|min:1',
            'certificat' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cout' => 'nullable|numeric|min:0',
            'observations' => 'nullable|string|max:1000',
            'statut' => 'required|in:Planifiée,En cours,Terminée,Annulée',
        ]);
    }
}
