<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Carrières</h2>
            <a href="{{ route('carrieres.create') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau mouvement
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nouveau poste</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($carrieres as $carriere)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $carriere->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $carriere->employe?->nom_complet ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $carriere->type_mouvement }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $carriere->nouveauPoste?->titre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $carriere->date_changement?->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @include('partials.crud-actions', ['routePrefix' => 'carrieres', 'model' => $carriere])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aucun mouvement enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($carrieres->hasPages())
            <div class="px-6 py-4 border-t">{{ $carrieres->links() }}</div>
        @endif
    </div>
</x-app-layout>
