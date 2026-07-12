<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Employés</h2>
            <a href="{{ route('employes.create') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouvel employé
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matricule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom complet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Département</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poste</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type de contrat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($employes as $employe)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $employe->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $employe->matricule }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $employe->nom_complet }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $employe->departement?->nom ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $employe->poste?->titre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $employe->activeContract?->contractType?->label ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full {{ $employe->statut === 'Actif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $employe->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('evaluations.create', $employe->matricule) }}"
                                       class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 rounded hover:bg-emerald-100">
                                        <i class="fa-solid fa-star mr-1"></i> Évaluer
                                    </a>
                                    @include('partials.crud-actions', ['routePrefix' => 'employes', 'model' => $employe])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucun employé enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($employes->hasPages())
            <div class="px-6 py-4 border-t">{{ $employes->links() }}</div>
        @endif
    </div>
</x-app-layout>
