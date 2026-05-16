<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail du mouvement de carrière</h2>
            <div class="flex gap-2">
                <a href="{{ route('carrieres.edit', $carriere) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('carrieres.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl space-y-4">
        <div>
            <p class="text-sm text-gray-500">Employé</p>
            <p class="text-lg font-semibold text-gray-900">{{ $carriere->employe?->nom_complet ?? '—' }}</p>
            @if ($carriere->employe)
                <p class="text-sm text-gray-600">Matricule : {{ $carriere->employe->matricule }}</p>
            @endif
        </div>
        <div>
            <p class="text-sm text-gray-500">Ancien poste</p>
            <p class="text-gray-900">{{ $carriere->ancienPoste?->titre ?? '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Nouveau poste</p>
            <p class="text-gray-900 font-medium">{{ $carriere->nouveauPoste?->titre ?? '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Type de mouvement</p>
            <p class="text-gray-900">{{ $carriere->type_mouvement }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Date du changement</p>
            <p class="text-gray-900">{{ $carriere->date_changement?->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Commentaire</p>
            <p class="text-gray-700">{{ $carriere->commentaire ?: '—' }}</p>
        </div>
    </div>
</x-app-layout>
