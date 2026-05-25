<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Critères</h2>
            <a href="{{ route('criteres.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau critère
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note max</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pondération</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($criteres as $critere)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $critere->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $critere->nom }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $critere->note_max }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $critere->ponderation }}%</td>
                            <td class="px-6 py-4 text-sm">
                                @include('partials.crud-actions', ['routePrefix' => 'criteres', 'model' => $critere])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucun critère enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($criteres->hasPages())
            <div class="px-6 py-4 border-t">{{ $criteres->links() }}</div>
        @endif
    </div>
</x-app-layout>
