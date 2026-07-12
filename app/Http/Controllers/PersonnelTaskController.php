<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\PersonnelTask;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonnelTaskController extends Controller
{
    public function index(): View
    {
        $tasks = PersonnelTask::with(['direction', 'departement', 'assignedBy', 'assignedTo'])->latest()->paginate(10);

        return view('personnel_tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        $directions = Direction::orderBy('nom')->get();
        $departements = Departement::orderBy('nom')->get();
        $users = User::orderBy('name')->get();
        $employes = Employe::orderBy('nom')->get();

        return view('personnel_tasks.create', compact('directions', 'departements', 'users', 'employes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'direction_id' => 'required|exists:directions,id',
            'departement_id' => 'required|exists:departements,id',
            'assigned_by_id' => 'required|exists:users,id',
            'assigned_to_id' => 'nullable|exists:employes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        PersonnelTask::create($validated);

        return redirect()->route('personnel-tasks.index')->with('success', 'Tâche enregistrée avec succès.');
    }

    public function show(PersonnelTask $personnelTask): View
    {
        $personnelTask->load(['direction', 'departement', 'assignedBy', 'assignedTo']);

        return view('personnel_tasks.show', compact('personnelTask'));
    }

    public function edit(PersonnelTask $personnelTask): View
    {
        $directions = Direction::orderBy('nom')->get();
        $departements = Departement::orderBy('nom')->get();
        $users = User::orderBy('name')->get();
        $employes = Employe::orderBy('nom')->get();

        return view('personnel_tasks.edit', compact('personnelTask', 'directions', 'departements', 'users', 'employes'));
    }

    public function update(Request $request, PersonnelTask $personnelTask): RedirectResponse
    {
        $validated = $request->validate([
            'direction_id' => 'required|exists:directions,id',
            'departement_id' => 'required|exists:departements,id',
            'assigned_by_id' => 'required|exists:users,id',
            'assigned_to_id' => 'nullable|exists:employes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $personnelTask->update($validated);

        return redirect()->route('personnel-tasks.index')->with('success', 'Tâche mise à jour avec succès.');
    }

    public function destroy(PersonnelTask $personnelTask): RedirectResponse
    {
        $personnelTask->delete();

        return redirect()->route('personnel-tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
