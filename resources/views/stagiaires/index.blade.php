<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Stagiaires</h2>
            <a href="{{ route('stagiaires.create') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau stagiaire
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom complet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Département</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Université</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Spécialité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($stagiaires as $stagiaire)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $stagiaire->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $stagiaire->nom_complet }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $stagiaire->departement?->nom ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $stagiaire->universite }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $stagiaire->specialite }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $stagiaire->date_debut_stage->format('d/m/Y') }} - {{ $stagiaire->date_fin_stage->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $statusColors = [
                                        'En cours' => 'bg-blue-100 text-blue-800',
                                        'Terminé' => 'bg-green-100 text-green-800',
                                        'Suspendu' => 'bg-yellow-100 text-yellow-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$stagiaire->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $stagiaire->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    @include('partials.crud-actions', ['routePrefix' => 'stagiaires', 'model' => $stagiaire])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">Aucun stagiaire enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($stagiaires->hasPages())
            <div class="px-6 py-4 border-t">{{ $stagiaires->links() }}</div>
        @endif
    </div>
</x-app-layout>
