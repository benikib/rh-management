<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détails de l'évaluation</h2>
            <a href="{{ route('evaluations.index', $evaluation->employe_matricule) }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl mx-auto space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                <span class="text-sm text-gray-500">Employé</span>
                <div class="mt-2 font-semibold text-gray-900">{{ $evaluation->employe->prenom }} {{ $evaluation->employe->nom }}</div>
                <div class="text-sm text-gray-600">Matricule : {{ $evaluation->employe_matricule }}</div>
            </div>
            <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                <span class="text-sm text-gray-500">Date</span>
                <div class="mt-2 font-semibold text-gray-900">{{ $evaluation->date_evaluation->format('d/m/Y') }}</div>
            </div>
            <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                <span class="text-sm text-gray-500">Note totale</span>
                <div class="mt-2 font-semibold text-gray-900">{{ $evaluation->note_totale ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Commentaire</h3>
            <p class="mt-2 text-gray-700">{{ $evaluation->commentaire ?: 'Aucun commentaire.' }}</p>
        </div>

        <div class="rounded-lg border border-gray-200 p-4 bg-white">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Critères</h3>
            <div class="space-y-4">
                @foreach($evaluation->criteres as $item)
                    <div class="rounded-lg border border-gray-200 p-4">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $item->critere->nom }}</h4>
                                <p class="text-sm text-gray-600">{{ $item->critere->description ?: 'Pas de description.' }}</p>
                            </div>
                            <div class="text-sm text-gray-700">Note : <strong>{{ $item->note }}</strong> / {{ $item->critere->note_max }}</div>
                        </div>
                        <div class="text-sm text-gray-700">Observation : {{ $item->observation ?: 'Aucune observation.' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
