<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détail de la tâche</h2>
            <div class="flex gap-2">
                <a href="{{ route('personnel-tasks.edit', $personnelTask) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold">Modifier</a>
                <a href="{{ route('personnel-tasks.index') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg text-sm">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-4xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Titre</p>
                <p class="text-gray-900">{{ $personnelTask->title }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Assigné à</p>
                <p class="text-gray-900">{{ $personnelTask->assignedTo?->nom_complet ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Direction</p>
                <p class="text-gray-900">{{ $personnelTask->direction?->nom ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Département</p>
                <p class="text-gray-900">{{ $personnelTask->departement?->nom ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Priorité</p>
                <p class="text-gray-900">{{ ucfirst($personnelTask->priority) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <p class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $personnelTask->status)) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Échéance</p>
                <p class="text-gray-900">{{ $personnelTask->due_date?->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Assigné par</p>
                <p class="text-gray-900">{{ $personnelTask->assignedBy?->name ?? '—' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Description</p>
                <p class="text-gray-900 whitespace-pre-line">{{ $personnelTask->description ?? '—' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Notes</p>
                <p class="text-gray-900 whitespace-pre-line">{{ $personnelTask->notes ?? '—' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
