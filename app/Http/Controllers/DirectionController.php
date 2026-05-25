<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectionController extends Controller
{
    public function index(): View
    {
        $directions = Direction::latest()->paginate(10);

        return view('directions.index', compact('directions'));
    }

    public function create(): View
    {
        return view('directions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:directions,nom',
            'description' => 'nullable|string',
        ]);

        Direction::create($validated);

        return redirect()->route('directions.index')->with('success', 'Direction créée avec succès.');
    }

    public function show(Direction $direction): View
    {
        $direction->load('departements');

        return view('directions.show', compact('direction'));
    }

    public function edit(Direction $direction): View
    {
        return view('directions.edit', compact('direction'));
    }

    public function update(Request $request, Direction $direction): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:directions,nom,' . $direction->id,
            'description' => 'nullable|string',
        ]);

        $direction->update($validated);

        return redirect()->route('directions.index')->with('success', 'Direction mise à jour avec succès.');
    }

    public function destroy(Direction $direction): RedirectResponse
    {
        $direction->delete();

        return redirect()->route('directions.index')->with('success', 'Direction supprimée avec succès.');
    }
}
