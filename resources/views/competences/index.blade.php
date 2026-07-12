<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Compétences</h2>
            <a href="{{ route('competences.create') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouvelle compétence
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Formations</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employés</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($competences as $competence)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $competence->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $competence->nom }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $competence->categorie ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full {{ $competence->statut === 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $competence->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $competence->formations_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $competence->employes_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    @include('partials.crud-actions', ['routePrefix' => 'competences', 'model' => $competence])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucune compétence enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($competences->hasPages())
            <div class="px-6 py-4 border-t">{{ $competences->links() }}</div>
        @endif
    </div>
</x-app-layout>
