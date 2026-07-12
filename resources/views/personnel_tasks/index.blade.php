<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Tâches du personnel</h2>
            <a href="{{ route('personnel-tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-plus mr-2"></i> Nouvelle tâche
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Département</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Échéance</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($tasks as $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $task->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $task->assignedTo?->nom_complet ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $task->departement?->nom ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($task->priority) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $task->due_date?->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm">
                            @include('partials.crud-actions', ['routePrefix' => 'personnel-tasks', 'model' => $task])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucune tâche enregistrée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($tasks->hasPages())
            <div class="px-6 py-4 border-t">{{ $tasks->links() }}</div>
        @endif
    </div>
</x-app-layout>
