<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractTypeController extends Controller
{
    public function index(): View
    {
        $contractTypes = ContractType::query()->orderBy('created_at', 'desc')->paginate(10);

        return view('contract_types.index', compact('contractTypes'));
    }

    public function create(): View
    {
        return view('contract_types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateContractType($request);

        ContractType::create($validated);

        return redirect()->route('contract-types.index')->with('success', 'Type de contrat créé avec succès.');
    }

    public function show(ContractType $contractType): View
    {
        return view('contract_types.show', compact('contractType'));
    }

    public function edit(ContractType $contractType): View
    {
        return view('contract_types.edit', compact('contractType'));
    }

    public function update(Request $request, ContractType $contractType): RedirectResponse
    {
        $validated = $this->validateContractType($request, $contractType);

        $contractType->update($validated);

        return redirect()->route('contract-types.index')->with('success', 'Type de contrat mis à jour avec succès.');
    }

    public function destroy(ContractType $contractType): RedirectResponse
    {
        ContractType::destroy($contractType->id);

        return redirect()->route('contract-types.index')->with('success', 'Type de contrat supprimé avec succès.');
    }

    private function validateContractType(Request $request, ?ContractType $contractType = null): array
    {
        $contractTypeId = $contractType?->id ?? null;

        $data = $request->validate([
            'code' => 'required|string|max:255|unique:contract_types,code,' . $contractTypeId,
            'label' => 'required|string|max:255|unique:contract_types,label,' . $contractTypeId,
            'description' => 'nullable|string|max:1000',
            'requires_end_date' => 'sometimes|boolean',
        ]);

        $data['requires_end_date'] = $request->has('requires_end_date');

        return $data;
    }
}
