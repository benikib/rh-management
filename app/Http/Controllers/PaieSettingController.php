<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaieSetting;

class PaieSettingController extends Controller
{
    public function edit()
    {
        $settings = PaieSetting::first();
        return view('paie_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'calculation_method' => 'required|in:pro_rata,hours',
            'jours_travail_par_mois' => 'required|integer|min:1',
            'heures_par_jour' => 'required|integer|min:1',
            'overtime_multiplier' => 'required|numeric|min:1',
        ]);

        $settings = PaieSetting::first();
        if (! $settings) {
            $settings = PaieSetting::create($data);
        } else {
            $settings->update($data);
        }

        return redirect()->route('paie.settings.edit')->with('status', 'Paramètres de paie mis à jour.');
    }
}
