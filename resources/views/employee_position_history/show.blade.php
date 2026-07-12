<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail de l'historique de poste</h2>
            <div class="flex gap-2">
                <a href="{{ route('employee-position-history.edit', $employeePositionHistory) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg">Modifier</a>
                <a href="{{ route('employee-position-history.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Employé</p>
                <p class="text-gray-900">{{ $employeePositionHistory->employe?->nom_complet ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Poste</p>
                <p class="text-gray-900">{{ $employeePositionHistory->poste?->titre ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Département</p>
                <p class="text-gray-900">{{ $employeePositionHistory->departement?->nom ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <p class="text-gray-900">{{ $employeePositionHistory->status }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Début</p>
                <p class="text-gray-900">{{ optional($employeePositionHistory->start_date)->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Fin</p>
                <p class="text-gray-900">{{ optional($employeePositionHistory->end_date)->format('d/m/Y') ?? 'Présent' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Superviseur</p>
                <p class="text-gray-900">{{ $employeePositionHistory->supervisor_name ?? '—' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Observations</p>
                <p class="text-gray-900 whitespace-pre-line">{{ $employeePositionHistory->observations ?? 'Aucune observation.' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
