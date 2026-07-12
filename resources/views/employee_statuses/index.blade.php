<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white">Statuts RH</h2>
            <a href="{{ route('employee-statuses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Ajouter un statut</a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($statuses as $status)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $status->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $status->label }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($status->description, 60) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('employee-statuses.show', $status) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                                <a href="{{ route('employee-statuses.edit', $status) }}" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                <form action="{{ route('employee-statuses.destroy', $status) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce statut ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Aucun statut RH trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $statuses->links() }}
        </div>
    </div>
</x-app-layout>
