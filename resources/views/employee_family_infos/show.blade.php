<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail du dossier familial</h2>
            <div class="flex gap-2">
                <a href="{{ route('employee-family-infos.edit', $employeeFamilyInfo) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg">Modifier</a>
                <a href="{{ route('employee-family-infos.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Employé</p>
                <p class="text-gray-900">{{ $employeeFamilyInfo->employe?->nom_complet ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut marital</p>
                <p class="text-gray-900">{{ $employeeFamilyInfo->maritalStatus?->label ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Conjoint</p>
                <p class="text-gray-900">{{ $employeeFamilyInfo->spouse_name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Identité du conjoint</p>
                <p class="text-gray-900">{{ $employeeFamilyInfo->spouse_identity ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date de mariage</p>
                <p class="text-gray-900">{{ optional($employeeFamilyInfo->marriage_date)->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nombre d'enfants</p>
                <p class="text-gray-900">{{ $employeeFamilyInfo->number_of_children ?? 0 }}</p>
            </div>
        </div>

        <div>
            <p class="text-sm text-gray-500">Justificatif de mariage</p>
            @if ($employeeFamilyInfo->marriage_certificate_path)
                <a href="{{ asset('storage/' . $employeeFamilyInfo->marriage_certificate_path) }}" class="text-blue-600 hover:underline">Télécharger le document</a>
            @else
                <p class="text-gray-900">Aucun fichier</p>
            @endif
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900">Personnes à charge</h3>
            <p class="text-gray-600">{{ $employeeFamilyInfo->dependents->count() ?? 0 }} enregistré(s)</p>
        </div>
    </div>
</x-app-layout>
