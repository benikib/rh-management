<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDependent;
use App\Models\Employe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployeeDependentController extends Controller
{
    public function index(): View
    {
        $dependents = EmployeeDependent::with('employe')->latest()->paginate(10);

        return view('employee_dependents.index', compact('dependents'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('employee_dependents.create', compact('employes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'full_name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'identity_number' => 'nullable|string|max:255',
            'school_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'family_composition_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_student' => 'nullable|boolean',
            'is_schooled' => 'nullable|boolean',
        ]);

        $validated['is_student'] = $request->boolean('is_student');
        $validated['is_schooled'] = $request->boolean('is_schooled');

        if ($request->hasFile('school_certificate')) {
            $validated['school_certificate_path'] = $request->file('school_certificate')->store('employee/dependents', 'public');
        }

        if ($request->hasFile('family_composition_document')) {
            $validated['family_composition_document'] = $request->file('family_composition_document')->store('employee/dependents', 'public');
        }

        EmployeeDependent::create($validated);

        return redirect()->route('employee-dependents.index')->with('success', 'Personne à charge ajoutée avec succès.');
    }

    public function show(EmployeeDependent $employeeDependent): View
    {
        $employeeDependent->load('employe');

        return view('employee_dependents.show', compact('employeeDependent'));
    }

    public function edit(EmployeeDependent $employeeDependent): View
    {
        $employes = Employe::orderBy('nom')->get();

        return view('employee_dependents.edit', compact('employeeDependent', 'employes'));
    }

    public function update(Request $request, EmployeeDependent $employeeDependent): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'full_name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'identity_number' => 'nullable|string|max:255',
            'school_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'family_composition_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_student' => 'nullable|boolean',
            'is_schooled' => 'nullable|boolean',
        ]);

        $validated['is_student'] = $request->boolean('is_student');
        $validated['is_schooled'] = $request->boolean('is_schooled');

        if ($request->hasFile('school_certificate')) {
            if ($employeeDependent->school_certificate_path) {
                Storage::disk('public')->delete($employeeDependent->school_certificate_path);
            }
            $validated['school_certificate_path'] = $request->file('school_certificate')->store('employee/dependents', 'public');
        }

        if ($request->hasFile('family_composition_document')) {
            if ($employeeDependent->family_composition_document) {
                Storage::disk('public')->delete($employeeDependent->family_composition_document);
            }
            $validated['family_composition_document'] = $request->file('family_composition_document')->store('employee/dependents', 'public');
        }

        $employeeDependent->update($validated);

        return redirect()->route('employee-dependents.index')->with('success', 'Personne à charge mise à jour avec succès.');
    }

    public function destroy(EmployeeDependent $employeeDependent): RedirectResponse
    {
        if ($employeeDependent->school_certificate_path) {
            Storage::disk('public')->delete($employeeDependent->school_certificate_path);
        }

        if ($employeeDependent->family_composition_document) {
            Storage::disk('public')->delete($employeeDependent->family_composition_document);
        }

        $employeeDependent->delete();

        return redirect()->route('employee-dependents.index')->with('success', 'Personne à charge supprimée avec succès.');
    }
}
