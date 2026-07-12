<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détails de la compétence</h2>
            <div class="flex gap-2">
                <a href="{{ route('competences.edit', $competence) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                    <i class="fa-solid fa-edit mr-2"></i> Modifier
                </a>
                <a href="{{ route('competences.index') }}"
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
                    <h3 class="text-lg font-semibold text-gray-900">Informations</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Nom</p>
                        <p class="text-lg font-medium text-gray-900">{{ $competence->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Catégorie</p>
                        <p class="text-lg font-medium text-gray-900">{{ $competence->categorie ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="text-base text-gray-900">{{ $competence->description ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <!-- Formations -->
            @if ($competence->formations->count() > 0)
                <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Formations ({{ $competence->formations->count() }})</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($competence->formations as $formation)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $formation->titre }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $formation->employe->nom_complet }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Employés -->
            @if ($competence->employes->count() > 0)
                <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Employés possédant cette compétence ({{ $competence->employes->count() }})</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom complet</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Niveau</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date d'acquisition</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($competence->employes as $employe)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $employe->nom_complet }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $employe->pivot->niveau }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $employe->pivot->date_acquisition?->format('d/m/Y') ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Statut -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <p class="text-sm text-gray-500 mb-3">Statut</p>
                <span class="px-3 py-1 text-sm rounded-full {{ $competence->statut === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $competence->statut }}
                </span>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <p class="text-sm text-gray-500 mb-4">Statistiques</p>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b">
                        <span class="text-gray-600">Formations</span>
                        <span class="text-lg font-semibold text-blue-600">{{ $competence->formations->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Employés</span>
                        <span class="text-lg font-semibold text-green-600">{{ $competence->employes->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-sm text-gray-500 mb-3">Actions</p>
                <form action="{{ route('competences.destroy', $competence) }}" method="POST" class="inline">
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
