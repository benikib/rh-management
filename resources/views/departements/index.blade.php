<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Départements</h2>
            <a href="{{ route('departements.create') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau département
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($departements as $departement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $departement->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $departement->nom }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($departement->description, 60) }}</td>
                            <td class="px-6 py-4 text-sm">
                                @include('partials.crud-actions', ['routePrefix' => 'departements', 'model' => $departement])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Aucun département enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($departements->hasPages())
            <div class="px-6 py-4 border-t">{{ $departements->links() }}</div>
        @endif
    </div>
</x-app-layout>
