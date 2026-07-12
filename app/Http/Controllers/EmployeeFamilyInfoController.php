<?php

namespace App\Http\Controllers;

use App\Models\EmployeeFamilyInfo;
use App\Models\Employe;
use App\Models\MaritalStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployeeFamilyInfoController extends Controller
{
    public function index(): View
    {
        $familyInfos = EmployeeFamilyInfo::with(['employe', 'maritalStatus'])->latest()->paginate(10);

        return view('employee_family_infos.index', compact('familyInfos'));
    }

    public function create(): View
    {
        $employes = Employe::orderBy('nom')->get();
        $maritalStatuses = MaritalStatus::orderBy('label')->get();

        return view('employee_family_infos.create', compact('employes', 'maritalStatuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id|unique:employee_family_info,employe_id',
            'marital_status_id' => 'required|exists:marital_statuses,id',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_identity' => 'nullable|string|max:255',
            'marriage_date' => 'nullable|date',
            'number_of_children' => 'nullable|integer|min:0',
            'marriage_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('marriage_certificate')) {
            $validated['marriage_certificate_path'] = $request->file('marriage_certificate')->store('employee/family', 'public');
        }

        EmployeeFamilyInfo::create($validated);

        return redirect()->route('employee-family-infos.index')->with('success', 'Dossier familial créé avec succès.');
    }

    public function show(EmployeeFamilyInfo $employeeFamilyInfo): View
    {
        $employeeFamilyInfo->load(['employe', 'maritalStatus', 'dependents']);

        return view('employee_family_infos.show', compact('employeeFamilyInfo'));
    }

    public function edit(EmployeeFamilyInfo $employeeFamilyInfo): View
    {
        $employes = Employe::orderBy('nom')->get();
        $maritalStatuses = MaritalStatus::orderBy('label')->get();

        return view('employee_family_infos.edit', compact('employeeFamilyInfo', 'employes', 'maritalStatuses'));
    }

    public function update(Request $request, EmployeeFamilyInfo $employeeFamilyInfo): RedirectResponse
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id|unique:employee_family_info,employe_id,' . $employeeFamilyInfo->id,
            'marital_status_id' => 'required|exists:marital_statuses,id',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_identity' => 'nullable|string|max:255',
            'marriage_date' => 'nullable|date',
            'number_of_children' => 'nullable|integer|min:0',
            'marriage_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('marriage_certificate')) {
            if ($employeeFamilyInfo->marriage_certificate_path) {
                Storage::disk('public')->delete($employeeFamilyInfo->marriage_certificate_path);
            }
            $validated['marriage_certificate_path'] = $request->file('marriage_certificate')->store('employee/family', 'public');
        }

        $employeeFamilyInfo->update($validated);

        return redirect()->route('employee-family-infos.index')->with('success', 'Dossier familial mis à jour avec succès.');
    }

    public function destroy(EmployeeFamilyInfo $employeeFamilyInfo): RedirectResponse
    {
        if ($employeeFamilyInfo->marriage_certificate_path) {
            Storage::disk('public')->delete($employeeFamilyInfo->marriage_certificate_path);
        }

        $employeeFamilyInfo->delete();

        return redirect()->route('employee-family-infos.index')->with('success', 'Dossier familial supprimé avec succès.');
    }
}
