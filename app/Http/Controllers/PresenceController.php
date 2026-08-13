<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Presence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presences = Presence::with('employe')
            ->orderBy('date_presence', 'desc')
            ->orderBy('heure_arrivee', 'desc')
            ->paginate(15);

        // Statistiques du jour
        $stats = $this->getStats();

        return view('presences.index', compact('presences', 'stats'));
    }

    /**
     * Get statistics for today
     */
    private function getStats()
    {
        $today = now()->toDateString();
        $presencesToday = Presence::whereDate('date_presence', $today)->get();

        return [
            'total_today' => $presencesToday->count(),
            'arrived_today' => $presencesToday->where('statut', 'Present')->count(),
            'departed_today' => $presencesToday->whereNotNull('heure_depart')
                ->where('heure_depart', '!=', '00:00:00')
                ->count(),
            'absent_today' => $presencesToday->where('statut', 'Absent')->count(),
            'late_today' => $presencesToday->where('statut', 'Retard')->count(),
        ];
    }

    /**
     * Get live data for AJAX refresh
     */
    public function live(Request $request)
    {
        try {
            $today = now()->toDateString();
            
            // Récupérer les présences du jour avec les relations
            $presences = Presence::with('employe')
                ->whereDate('date_presence', $today)
                ->orderBy('heure_arrivee', 'desc')
                ->get()
                ->map(function ($presence) {
                    return [
                        'id' => $presence->id,
                        'employe_nom' => $presence->employe?->nom_complet ?? '—',
                        'date_presence' => $presence->date_presence?->format('Y-m-d'),
                        'heure_arrivee' => $presence->heure_arrivee,
                        'heure_depart' => $presence->heure_depart,
                        'statut' => $presence->statut,
                        'updated_at' => $presence->updated_at?->toISOString(),
                        'created_at' => $presence->created_at?->toISOString(),
                    ];
                });

            // Statistiques
            $stats = $this->getStats();

            return response()->json([
                'success' => true,
                'presences' => $presences,
                'stats' => $stats,
                'timestamp' => now()->toDateTimeString(),
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur dans live presences: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();
        return view('presences.create', compact('employes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_presence' => 'required|date',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_depart' => 'nullable|date_format:H:i|after:heure_arrivee',
            'statut' => 'required|in:Present,Absent,Retard,Conge',
            'remarque' => 'nullable|string|max:255',
        ]);

        // Vérifier si une présence existe déjà pour cet employé ce jour-là
        $existing = Presence::where('employe_id', $validated['employe_id'])
            ->whereDate('date_presence', $validated['date_presence'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Une présence existe déjà pour cet employé à cette date.')
                ->withInput();
        }

        // Ajouter les secondes pour le format de la base de données
        if (!empty($validated['heure_arrivee'])) {
            $validated['heure_arrivee'] = $validated['heure_arrivee'] . ':00';
        }
        if (!empty($validated['heure_depart'])) {
            $validated['heure_depart'] = $validated['heure_depart'] . ':00';
        }

        Presence::create($validated);

        return redirect()->route('presences.index')
            ->with('success', 'Présence enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Presence $presence): View
    {
        $presence->load('employe');
        return view('presences.show', compact('presence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presence $presence): View
    {
        $employes = Employe::orderBy('nom')->get();
        return view('presences.edit', compact('presence', 'employes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presence $presence): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_presence' => 'required|date',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_depart' => 'nullable|date_format:H:i|after:heure_arrivee',
            'statut' => 'required|in:Present,Absent,Retard,Conge',
            'remarque' => 'nullable|string|max:255',
        ]);

        // Vérifier les doublons (exclure l'enregistrement en cours)
        $existing = Presence::where('employe_id', $validated['employe_id'])
            ->whereDate('date_presence', $validated['date_presence'])
            ->where('id', '!=', $presence->id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Une présence existe déjà pour cet employé à cette date.')
                ->withInput();
        }

        // Ajouter les secondes pour le format de la base de données
        if (!empty($validated['heure_arrivee'])) {
            $validated['heure_arrivee'] = $validated['heure_arrivee'] . ':00';
        }
        if (!empty($validated['heure_depart'])) {
            $validated['heure_depart'] = $validated['heure_depart'] . ':00';
        }

        $presence->update($validated);

        return redirect()->route('presences.index')
            ->with('success', 'Présence mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presence $presence): RedirectResponse
    {
        try {
            $presence->delete();
            return redirect()->route('presences.index')
                ->with('success', 'Présence supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('presences.index')
                ->with('error', 'Erreur lors de la suppression.');
        }
    }

    /**
     * Enregistrer l'arrivée d'un employé (API)
     */
    public function arrival(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'heure_arrivee' => 'nullable|date_format:H:i',
        ]);

        $today = now()->toDateString();
        $heureArrivee = $request->heure_arrivee ?? now()->format('H:i');

        // Vérifier si l'employé est déjà présent aujourd'hui
        $presence = Presence::where('employe_id', $validated['employe_id'])
            ->whereDate('date_presence', $today)
            ->first();

        if ($presence) {
            return response()->json([
                'success' => false,
                'message' => 'Cet employé a déjà une présence enregistrée aujourd\'hui.'
            ], 400);
        }

        // Déterminer le statut (Retard si après 9h)
        $statut = 'Present';
        if ($heureArrivee > '09:00') {
            $statut = 'Retard';
        }

        $presence = Presence::create([
            'employe_id' => $validated['employe_id'],
            'date_presence' => $today,
            'heure_arrivee' => $heureArrivee . ':00',
            'statut' => $statut,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Arrivée enregistrée avec succès.',
            'presence' => $presence->load('employe')
        ]);
    }

    /**
     * Enregistrer le départ d'un employé (API)
     */
    public function departure(Request $request)
    {
        $validated = $request->validate([
            'presence_id' => 'required|exists:presences,id',
            'heure_depart' => 'nullable|date_format:H:i',
        ]);

        $presence = Presence::find($validated['presence_id']);
        
        if (!$presence) {
            return response()->json([
                'success' => false,
                'message' => 'Présence non trouvée.'
            ], 404);
        }

        if ($presence->heure_depart) {
            return response()->json([
                'success' => false,
                'message' => 'Le départ a déjà été enregistré.'
            ], 400);
        }

        $heureDepart = $request->heure_depart ?? now()->format('H:i');
        $presence->update([
            'heure_depart' => $heureDepart . ':00',
            // Le statut reste Present car nous n'avons pas de statut "Parti"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Départ enregistré avec succès.',
            'presence' => $presence->load('employe')
        ]);
    }

    /**
     * Get statistics for a specific date
     */
    public function stats(Request $request)
    {
        $date = $request->date ?? now()->toDateString();
        $presencesToday = Presence::whereDate('date_presence', $date)->get();

        return response()->json([
            'total' => $presencesToday->count(),
            'arrived' => $presencesToday->where('statut', 'Present')->count(),
            'departed' => $presencesToday->whereNotNull('heure_depart')
                ->where('heure_depart', '!=', '00:00:00')
                ->count(),
            'absent' => $presencesToday->where('statut', 'Absent')->count(),
            'late' => $presencesToday->where('statut', 'Retard')->count(),
        ]);
    }
}