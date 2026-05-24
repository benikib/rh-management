<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Presence;


class EmployePresenceController extends Controller
{
   public function index()
    {
        return view('employe.presences.index');
    }

 
    public function check(Request $request)
{
    $user = auth()->user(); // identifié via WebAuthn

    $presence = Presence::where('employe_id', $user->id)
        ->whereDate('date_presence', today())
        ->first();

    if ($presence && $presence->heure_depart) {
    return back()->with('error', 'Déjà pointé aujourd’hui');
}
    if (!$presence) {
        Presence::create([
            'employe_id' => $user->id,
            'date_presence' => today(),
            'heure_arrivee' => now()
        ]);

        return response()->json(['message' => 'Arrivée enregistrée']);
    }

    if (!$presence->heure_depart) {
        $presence->update([
            'heure_depart' => now()
        ]);

        return response()->json(['message' => 'Départ enregistré']);
    }

    return response()->json(['message' => 'Déjà pointé']);
    }
}
