<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Historique de poste</h2>
            <a href="{{ route('employee-position-history.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau journal
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Poste</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Département</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($histories as $history)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $history->employe?->nom_complet ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $history->poste?->titre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $history->departement?->nom ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ optional($history->start_date)->format('d/m/Y') }} - {{ optional($history->end_date)->format('d/m/Y') ?? 'Présent' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $history->status }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                @include('partials.crud-actions', ['routePrefix' => 'employee-position-history', 'model' => $history])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aucun historique de poste trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $histories->links() }}
        </div>
    </div>
</x-app-layout>
