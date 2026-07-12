<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail de la mission</h2>
            <div class="flex gap-2">
                <a href="{{ route('missions.edit', $mission) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('missions.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Titre</p>
                <p class="text-gray-900">{{ $mission->title }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Employé</p>
                <p class="text-gray-900">{{ $mission->employe?->nom_complet ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Lieu</p>
                <p class="text-gray-900">{{ $mission->lieu ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Motif</p>
                <p class="text-gray-900">{{ $mission->motif ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date de début</p>
                <p class="text-gray-900">{{ $mission->date_debut?->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Date de fin</p>
                <p class="text-gray-900">{{ $mission->date_fin?->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Frais</p>
                <p class="text-gray-900">{{ number_format($mission->frais_montant, 2, ',', ' ') }} $</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <p class="text-gray-900">{{ ucfirst($mission->statut) }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Description</p>
                <p class="text-gray-900 whitespace-pre-line">{{ $mission->description ?? '—' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Observations</p>
                <p class="text-gray-900 whitespace-pre-line">{{ $mission->observations ?? '—' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
