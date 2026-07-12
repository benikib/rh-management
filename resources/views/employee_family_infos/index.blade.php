<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Dossiers familiaux</h2>
            <a href="{{ route('employee-family-infos.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau dossier
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut marital</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conjoint</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enfants</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mariage</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($familyInfos as $familyInfo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $familyInfo->employe?->nom_complet ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $familyInfo->maritalStatus?->label ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $familyInfo->spouse_name ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $familyInfo->number_of_children ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ optional($familyInfo->marriage_date)->format('d/m/Y') ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                @include('partials.crud-actions', ['routePrefix' => 'employee-family-infos', 'model' => $familyInfo])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aucun dossier familial trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $familyInfos->links() }}
        </div>
    </div>
</x-app-layout>
