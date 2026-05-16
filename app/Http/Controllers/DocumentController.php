<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(): View
    {
        $documents = Document::with('employe')->latest()->paginate(10);

        return view('documents.index', compact('documents'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('documents.create', compact('employes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'nom_document' => 'required|string|max:255',
            'fichier' => 'required|file|max:5120',
            'type_document' => 'required|string|max:255',
        ]);

        $validated['fichier'] = $request->file('fichier')->store('documents', 'public');

        Document::create($validated);

        return redirect()->route('documents.index')->with('success', 'Document ajouté avec succès.');
    }

    public function show(Document $document): View
    {
        $document->load('employe');

        return view('documents.show', compact('document'));
    }

    public function edit(Document $document): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('documents.edit', compact('document', 'employes'));
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'nom_document' => 'required|string|max:255',
            'fichier' => 'nullable|file|max:5120',
            'type_document' => 'required|string|max:255',
        ]);

        if ($request->hasFile('fichier')) {
            Storage::disk('public')->delete($document->fichier);
            $validated['fichier'] = $request->file('fichier')->store('documents', 'public');
        } else {
            unset($validated['fichier']);
        }

        $document->update($validated);

        return redirect()->route('documents.index')->with('success', 'Document mis à jour avec succès.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        Storage::disk('public')->delete($document->fichier);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document supprimé avec succès.');
    }
}
