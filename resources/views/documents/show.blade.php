<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail du document</h2>
            <div class="flex gap-2">
                <a href="{{ route('documents.edit', $document) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('documents.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl space-y-4">
        <div>
            <p class="text-sm text-gray-500">Employé</p>
            <p class="text-lg font-semibold text-gray-900">{{ $document->employe?->nom_complet ?? '—' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Nom du document</p>
            <p class="text-gray-900">{{ $document->nom_document }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Type de document</p>
            <p class="text-gray-900">{{ $document->type_document }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Fichier</p>
            @if ($document->fichier)
                <a href="{{ Storage::url($document->fichier) }}" target="_blank" rel="noopener"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    <i class="fa-solid fa-file-arrow-down mr-2"></i> Télécharger le fichier
                </a>
            @else
                <p class="text-gray-500">Aucun fichier.</p>
            @endif
        </div>
    </div>
</x-app-layout>
