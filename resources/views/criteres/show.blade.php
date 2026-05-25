<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détails du critère</h2>
            <a href="{{ route('criteres.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl mx-auto space-y-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ $critere->nom }}</h3>
            <p class="text-gray-600">{{ $critere->description ?: 'Pas de description.' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <span class="text-sm text-gray-500">Note maximale</span>
                <div class="mt-2 text-lg font-semibold text-gray-900">{{ $critere->note_max }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <span class="text-sm text-gray-500">Pondération</span>
                <div class="mt-2 text-lg font-semibold text-gray-900">{{ $critere->ponderation }}%</div>
            </div>
        </div>
    </div>
</x-app-layout>
