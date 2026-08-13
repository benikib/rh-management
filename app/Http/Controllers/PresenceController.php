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

    public function live(Request $request)
{
    $today = now()->toDateString();
    
    // Récupérer les présences du jour
    $presences = Presence::with('employe')
        ->whereDate('date_presence', $today)
        ->orderBy('heure_arrivee', 'desc')
        ->get();
    
    // Calculer les statistiques
    $stats = [
        'total_today' => $presences->count(),
        'arrived_today' => $presences->where('statut', 'Présent')->count(),
        'departed_today' => $presences->where('statut', 'Parti')->count(),
        'absent_today' => $presences->where('statut', 'Absent')->count(),
    ];
    
    return response()->json([
        'presences' => $presences,
        'stats' => $stats,
        'timestamp' => now()->toDateTimeString(),
    ]);
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
