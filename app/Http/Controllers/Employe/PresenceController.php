<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index()
    {
        return view('employe.presences.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'matricule' => 'required'
        ]);

        $employe = Employe::where(
            'matricule',
            $request->matricule
        )->first();

        if (!$employe) {

            return back()
                ->with('error', 'Employé introuvable');
        }

        $presence = Presence::where(
            'employe_id',
            $employe->id
        )
        ->whereDate(
            'date_presence',
            today()
        )
        ->first();

        // ARRIVÉE
        if (!$presence) {

            Presence::create([

                'employe_id' => $employe->id,

                'date_presence' => today(),

                'heure_arrivee' => now()
                    ->format('H:i:s'),

                'statut' => 'present'
            ]);

            return back()
                ->with('success', 'Arrivée enregistrée');
        }

        // DÉPART
        if (!$presence->heure_depart) {

            $presence->update([

                'heure_depart' => now()
                    ->format('H:i:s')
            ]);

            return back()
                ->with('success', 'Départ enregistré');
        }

        return back()
            ->with('error', 'Présence déjà complète');
    }
}