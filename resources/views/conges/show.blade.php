<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail du congé</h2>
            <div class="flex gap-2">
                <a href="{{ route('conges.edit', $conge) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('conges.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl space-y-4">
        <div>
            <p class="text-sm text-gray-500">Employé</p>
            <p class="text-lg font-semibold text-gray-900">{{ $conge->employe?->nom_complet ?? '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Type de congé</p>
            <p class="text-gray-900">{{ $conge->type_conge }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Date de début</p>
            <p class="text-gray-900">{{ $conge->date_debut?->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Date de fin</p>
            <p class="text-gray-900">{{ $conge->date_fin?->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Motif</p>
            <p class="text-gray-700">{{ $conge->motif ?: '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Statut</p>
            <p class="text-gray-900 font-medium">{{ $conge->statut }}</p>
        </div>
    </div>
</x-app-layout>
