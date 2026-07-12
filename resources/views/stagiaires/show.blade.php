<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détails du stagiaire</h2>
            <div class="flex gap-2">
                <a href="{{ route('stagiaires.edit', $stagiaire) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                    <i class="fa-solid fa-edit mr-2"></i> Modifier
                </a>
                <a href="{{ route('stagiaires.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg text-sm font-semibold hover:bg-gray-700">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Retour
                </a>
            </div>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations personnelles -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informations personnelles</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Nom</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->nom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Postnom</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->postnom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Prénom</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->prenom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Sexe</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->sexe }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date de naissance</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->date_naissance->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Téléphone</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->telephone ?? '—' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->email ?? '—' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Adresse</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->adresse ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de stage -->
            <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Informations de stage</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Département</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->departement->nom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Université</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->universite }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spécialité</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->specialite }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date de début</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->date_debut_stage->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date de fin</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->date_fin_stage->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Encadrant</p>
                            <p class="text-lg font-medium text-gray-900">{{ $stagiaire->encadrant?->nom_complet ?? '—' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Observations</p>
                            <p class="text-base text-gray-900">{{ $stagiaire->observations ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Photo -->
            @if ($stagiaire->photo)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <p class="text-sm text-gray-500 mb-3">Photo</p>
                    <img src="{{ Storage::url($stagiaire->photo) }}" alt="Photo" class="w-full rounded-lg object-cover">
                </div>
            @endif

            <!-- Statut -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <p class="text-sm text-gray-500 mb-3">Statut</p>
                @php
                    $statusColors = [
                        'En cours' => 'bg-blue-100 text-blue-800',
                        'Terminé' => 'bg-green-100 text-green-800',
                        'Suspendu' => 'bg-yellow-100 text-yellow-800',
                    ];
                @endphp
                <span class="px-3 py-1 text-sm rounded-full {{ $statusColors[$stagiaire->statut] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $stagiaire->statut }}
                </span>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm text-gray-500 mb-3">Actions</p>
                <form action="{{ route('stagiaires.destroy', $stagiaire) }}" method="POST" class="inline">
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
