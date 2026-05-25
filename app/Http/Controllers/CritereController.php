<?php

namespace App\Http\Controllers;

use App\Models\Critere;
use Illuminate\Http\Request;

class CritereController extends Controller
{
    public function index()
    {
        $criteres = Critere::latest()->paginate(15);

        return view('criteres.index', compact('criteres'));
    }

    public function create()
    {
        return view('criteres.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note_max' => 'required|numeric|min:0.1',
            'ponderation' => 'required|numeric|min:0',
        ]);

        Critere::create($data);

        return redirect()
            ->route('criteres.index')
            ->with('success', 'Critère créé avec succès.');
    }

    public function show(Critere $critere)
    {
        return view('criteres.show', compact('critere'));
    }

    public function edit(Critere $critere)
    {
        return view('criteres.edit', compact('critere'));
    }

    public function update(Request $request, Critere $critere)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note_max' => 'required|numeric|min:0.1',
            'ponderation' => 'required|numeric|min:0',
        ]);

        $critere->update($data);

        return redirect()
            ->route('criteres.index')
            ->with('success', 'Critère mis à jour avec succès.');
    }

    public function destroy(Critere $critere)
    {
        $critere->delete();

        return redirect()
            ->route('criteres.index')
            ->with('success', 'Critère supprimé avec succès.');
    }
}
