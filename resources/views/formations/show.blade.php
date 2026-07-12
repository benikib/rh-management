<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détails de la formation</h2>
            <div class="flex gap-2">
                <a href="{{ route('formations.edit', $formation) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                    <i class="fa-solid fa-edit mr-2"></i> Modifier
                </a>
                <a href="{{ route('formations.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg text-sm font-semibold hover:bg-gray-700">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Informations générales -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informations générales</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Employé</p>
                            <p class="text-lg font-medium text-gray-900">{{ $formation->employe->nom_complet }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Titre</p>
                            <p class="text-lg font-medium text-gray-900">{{ $formation->titre }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="text-base text-gray-900">{{ $formation->description ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Organisme</p>
                            <p class="text-lg font-medium text-gray-900">{{ $formation->organisme_formation }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Durée</p>
                            <p class="text-lg font-medium text-gray-900">{{ $formation->duree_heures ?? '—' }} h</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date de début</p>
                            <p class="text-lg font-medium text-gray-900">{{ $formation->date_debut->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date de fin</p>
                            <p class="text-lg font-medium text-gray-900">{{ $formation->date_fin->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Coût</p>
                            <p class="text-lg font-medium text-gray-900">{{ $formation->cout ?? '—' }} €</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compétences -->
            @if ($formation->competences->count() > 0)
                <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Compétences acquises</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($formation->competences as $competence)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $competence->nom }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Observations -->
            @if ($formation->observations)
                <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Observations</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-base text-gray-900">{{ $formation->observations }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Statut -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <p class="text-sm text-gray-500 mb-3">Statut</p>
                @php
                    $statusColors = [
                        'Planifiée' => 'bg-gray-100 text-gray-800',
                        'En cours' => 'bg-blue-100 text-blue-800',
                        'Terminée' => 'bg-green-100 text-green-800',
                        'Annulée' => 'bg-red-100 text-red-800',
                    ];
                @endphp
                <span class="px-3 py-1 text-sm rounded-full {{ $statusColors[$formation->statut] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $formation->statut }}
                </span>
            </div>

            <!-- Certificat -->
            @if ($formation->certificat)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <p class="text-sm text-gray-500 mb-3">Certificat</p>
                    <a href="{{ Storage::url($formation->certificat) }}" target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                        <i class="fa-solid fa-download mr-2"></i> Télécharger
                    </a>
                </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm text-gray-500 mb-3">Actions</p>
                <form action="{{ route('formations.destroy', $formation) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Êtes-vous sûr ?')"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                        <i class="fa-solid fa-trash mr-2"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
