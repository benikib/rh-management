<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Personnes à charge</h2>
            <a href="{{ route('employee-dependents.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouvelle personne
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Né(e) le</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiant</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($dependents as $dependent)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $dependent->employe?->nom_complet ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $dependent->full_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $dependent->type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ optional($dependent->birth_date)->format('d/m/Y') ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $dependent->is_student ? 'Oui' : 'Non' }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                @include('partials.crud-actions', ['routePrefix' => 'employee-dependents', 'model' => $dependent])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aucune personne à charge trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $dependents->links() }}
        </div>
    </div>
</x-app-layout>
