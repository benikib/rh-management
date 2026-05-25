<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détails de la direction</h2>
            <a href="{{ route('directions.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">Retour à la liste</a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl mx-auto space-y-4">
        <div>
            <p class="text-sm text-gray-500">Nom</p>
            <p class="text-lg font-semibold text-gray-900">{{ $direction->nom }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Description</p>
            <p class="text-gray-700">{{ $direction->description ?: '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500 mb-2">Départements associés ({{ $direction->departements->count() }})</p>
            @if ($direction->departements->isNotEmpty())
                <ul class="list-disc list-inside text-gray-700">
                    @foreach ($direction->departements as $departement)
                        <li>{{ $departement->nom }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Aucun département associé.</p>
            @endif
        </div>
    </div>
</x-app-layout>
