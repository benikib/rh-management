<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail de la présence</h2>
            <div class="flex gap-2">
                <a href="{{ route('presences.edit', $presence) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('presences.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl space-y-4">
        <div>
            <p class="text-sm text-gray-500">Employé</p>
            <p class="text-lg font-semibold text-gray-900">{{ $presence->employe?->nom_complet ?? '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Date de présence</p>
            <p class="text-gray-900">{{ $presence->date_presence?->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Heure d'arrivée</p>
            <p class="text-gray-900">{{ $presence->heure_arrivee ? substr($presence->heure_arrivee, 0, 5) : '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Heure de départ</p>
            <p class="text-gray-900">{{ $presence->heure_depart ? substr($presence->heure_depart, 0, 5) : '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Statut</p>
            <p class="text-gray-900 font-medium">{{ $presence->statut }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Remarque</p>
            <p class="text-gray-700">{{ $presence->remarque ?: '—' }}</p>
        </div>
    </div>
</x-app-layout>
