<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail de la personne à charge</h2>
            <div class="flex gap-2">
                <a href="{{ route('employee-dependents.edit', $employeeDependent) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg">Modifier</a>
                <a href="{{ route('employee-dependents.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Employé</p>
                <p class="text-gray-900">{{ $employeeDependent->employe?->nom_complet ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nom complet</p>
                <p class="text-gray-900">{{ $employeeDependent->full_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Type</p>
                <p class="text-gray-900">{{ $employeeDependent->type }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date de naissance</p>
                <p class="text-gray-900">{{ optional($employeeDependent->birth_date)->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Numéro d'identité</p>
                <p class="text-gray-900">{{ $employeeDependent->identity_number ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Étudiant</p>
                <p class="text-gray-900">{{ $employeeDependent->is_student ? 'Oui' : 'Non' }}</p>
            </div>
        </div>

        <div>
            <p class="text-sm text-gray-500">Attestation scolaire</p>
            @if ($employeeDependent->school_certificate_path)
                <a href="{{ asset('storage/' . $employeeDependent->school_certificate_path) }}" class="text-blue-600 hover:underline">Télécharger</a>
            @else
                <p class="text-gray-900">Aucun fichier</p>
            @endif
        </div>

        <div>
            <p class="text-sm text-gray-500">Document de composition familiale</p>
            @if ($employeeDependent->family_composition_document)
                <a href="{{ asset('storage/' . $employeeDependent->family_composition_document) }}" class="text-blue-600 hover:underline">Télécharger</a>
            @else
                <p class="text-gray-900">Aucun fichier</p>
            @endif
        </div>
    </div>
</x-app-layout>
