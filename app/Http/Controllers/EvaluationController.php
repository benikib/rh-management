<?php

namespace App\Http\Controllers;

use App\Models\Critere;
use App\Models\Employe;
use App\Models\Evaluation;
use App\Models\EvaluationCritere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function index($matricule)
    {
        $employe = Employe::where('matricule', $matricule)->firstOrFail();

        $evaluations = Evaluation::with('criteres.critere')
            ->where('employe_matricule', $matricule)
            ->latest()
            ->get();

        return view('evaluations.index', compact('employe', 'evaluations'));
    }

    public function all()
    {
        $evaluations = Evaluation::with('criteres.critere', 'employe')->latest()->get();

        return view('evaluations.all', compact('evaluations'));
    }

    public function create($matricule)
    {
        $employe = Employe::where('matricule', $matricule)->firstOrFail();
        $criteres = Critere::all();

        return view('evaluations.create', compact('employe', 'criteres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employe_matricule' => 'required',
            'date_evaluation' => 'required|date',
            'criteres' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $evaluation = Evaluation::create([
                'employe_matricule' => $request->employe_matricule,
                'evaluateur_id' => auth()->id(),
                'date_evaluation' => $request->date_evaluation,
                'commentaire' => $request->commentaire,
            ]);

            $noteFinale = 0;

            foreach ($request->criteres as $item) {
                $critere = Critere::find($item['critere_id']);

                if (! $critere) {
                    continue;
                }

                EvaluationCritere::create([
                    'evaluation_id' => $evaluation->id,
                    'critere_id' => $critere->id,
                    'note' => $item['note'],
                    'observation' => $item['observation'] ?? null,
                ]);

                $noteFinale += ($item['note'] / $critere->note_max) * $critere->ponderation;
            }

            $evaluation->update(['note_totale' => $noteFinale]);

            DB::commit();

            return redirect()
                ->route('evaluations.index', $request->employe_matricule)
                ->with('success', 'Évaluation enregistrée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load('criteres.critere', 'employe');

        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        $criteres = Critere::all();
        $evaluation->load('criteres');

        return view('evaluations.edit', compact('evaluation', 'criteres'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'employe_matricule' => 'required',
            'date_evaluation' => 'required|date',
            'criteres' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $evaluation->update([
                'date_evaluation' => $request->date_evaluation,
                'commentaire' => $request->commentaire,
            ]);

            EvaluationCritere::where('evaluation_id', $evaluation->id)->delete();

            $noteFinale = 0;

            foreach ($request->criteres as $item) {
                $critere = Critere::find($item['critere_id']);

                if (! $critere) {
                    continue;
                }

                EvaluationCritere::create([
                    'evaluation_id' => $evaluation->id,
                    'critere_id' => $critere->id,
                    'note' => $item['note'],
                    'observation' => $item['observation'] ?? null,
                ]);

                $noteFinale += ($item['note'] / $critere->note_max) * $critere->ponderation;
            }

            $evaluation->update(['note_totale' => $noteFinale]);

            DB::commit();

            return redirect()
                ->route('evaluations.show', $evaluation)
                ->with('success', 'Évaluation mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Evaluation $evaluation)
    {
        $matricule = $evaluation->employe_matricule;
        $evaluation->delete();

        return redirect()
            ->route('evaluations.index', $matricule)
            ->with('success', 'Évaluation supprimée avec succès.');
    }
}
