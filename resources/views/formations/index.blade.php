<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Formations</h2>
            <a href="{{ route('formations.create') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouvelle formation
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organisme</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($formations as $formation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $formation->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $formation->employe->nom_complet }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $formation->titre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $formation->organisme_formation }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $formation->date_debut->format('d/m/Y') }} - {{ $formation->date_fin->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $statusColors = [
                                        'Planifiée' => 'bg-gray-100 text-gray-800',
                                        'En cours' => 'bg-blue-100 text-blue-800',
                                        'Terminée' => 'bg-green-100 text-green-800',
                                        'Annulée' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$formation->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $formation->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    @include('partials.crud-actions', ['routePrefix' => 'formations', 'model' => $formation])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucune formation enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($formations->hasPages())
            <div class="px-6 py-4 border-t">{{ $formations->links() }}</div>
        @endif
    </div>
</x-app-layout>
