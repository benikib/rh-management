<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail du poste</h2>
            <div class="flex gap-2">
                <a href="{{ route('postes.edit', $poste) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('postes.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl space-y-4">
        <div>
            <p class="text-sm text-gray-500">Titre</p>
            <p class="text-lg font-semibold text-gray-900">{{ $poste->titre }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Description</p>
            <p class="text-gray-700">{{ $poste->description ?: '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Salaire de référence</p>
            <p class="text-gray-900 font-medium">{{ number_format($poste->salaire_reference, 2, ',', ' ') }} $</p>
        </div>
        <div>
            <p class="text-sm text-gray-500 mb-2">Employés ({{ $poste->employes->count() }})</p>
            @if ($poste->employes->isNotEmpty())
                <ul class="list-disc list-inside text-gray-700">
                    @foreach ($poste->employes as $employe)
                        <li>{{ $employe->nom_complet }} — {{ $employe->matricule }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Aucun employé.</p>
            @endif
        </div>
    </div>
</x-app-layout>
