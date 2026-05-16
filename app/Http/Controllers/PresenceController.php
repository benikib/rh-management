<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Presence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PresenceController extends Controller
{
    public function index(): View
    {
        $presences = Presence::with('employe')->latest()->paginate(10);

        return view('presences.index', compact('presences'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('presences.create', compact('employes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_presence' => 'required|date',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_depart' => 'nullable|date_format:H:i',
            'statut' => 'required|in:Present,Absent,Retard,Conge',
            'remarque' => 'nullable|string',
        ]);

        Presence::create($validated);

        return redirect()->route('presences.index')->with('success', 'Présence enregistrée avec succès.');
    }

    public function show(Presence $presence): View
    {
        $presence->load('employe');

        return view('presences.show', compact('presence'));
    }

    public function edit(Presence $presence): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('presences.edit', compact('presence', 'employes'));
    }

    public function update(Request $request, Presence $presence): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_presence' => 'required|date',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_depart' => 'nullable|date_format:H:i',
            'statut' => 'required|in:Present,Absent,Retard,Conge',
            'remarque' => 'nullable|string',
        ]);

        $presence->update($validated);

        return redirect()->route('presences.index')->with('success', 'Présence mise à jour avec succès.');
    }

    public function destroy(Presence $presence): RedirectResponse
    {
        $presence->delete();

        return redirect()->route('presences.index')->with('success', 'Présence supprimée avec succès.');
    }
}
