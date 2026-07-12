<?php

namespace App\Http\Controllers;

use App\Models\EmployeeStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeStatusController extends Controller
{
    public function index(): View
    {
        $statuses = EmployeeStatus::latest()->paginate(10);

        return view('employee_statuses.index', compact('statuses'));
    }

    public function create(): View
    {
        return view('employee_statuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:100|unique:employee_statuses,code',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        EmployeeStatus::create($validated);

        return redirect()->route('employee-statuses.index')->with('success', 'Statut RH créé avec succès.');
    }

    public function show(EmployeeStatus $employeeStatus): View
    {
        return view('employee_statuses.show', compact('employeeStatus'));
    }

    public function edit(EmployeeStatus $employeeStatus): View
    {
        return view('employee_statuses.edit', compact('employeeStatus'));
    }

    public function update(Request $request, EmployeeStatus $employeeStatus): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:100|unique:employee_statuses,code,' . $employeeStatus->id,
            'label' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $employeeStatus->update($validated);

        return redirect()->route('employee-statuses.index')->with('success', 'Statut RH mis à jour avec succès.');
    }

    public function destroy(EmployeeStatus $employeeStatus): RedirectResponse
    {
        $employeeStatus->delete();

        return redirect()->route('employee-statuses.index')->with('success', 'Statut RH supprimé avec succès.');
    }
}
