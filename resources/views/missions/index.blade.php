<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Missions</h2>
            <a href="{{ route('missions.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouvelle mission
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lieu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frais</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($missions as $mission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $mission->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $mission->employe?->nom_complet ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $mission->lieu ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $mission->date_debut?->format('d/m/Y') }} @if($mission->date_fin) - {{ $mission->date_fin->format('d/m/Y') }} @endif</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($mission->frais_montant, 2, ',', ' ') }} $</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($mission->statut) }}</td>
                        <td class="px-6 py-4 text-sm">
                            @include('partials.crud-actions', ['routePrefix' => 'missions', 'model' => $mission])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucune mission enregistrée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($missions->hasPages())
            <div class="px-6 py-4 border-t">{{ $missions->links() }}</div>
        @endif
    </div>
</x-app-layout>
