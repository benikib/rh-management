<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white">Détail du statut RH</h2>
            <div class="flex gap-2">
                <a href="{{ route('employee-statuses.edit', $employeeStatus) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg">Modifier</a>
                <a href="{{ route('employee-statuses.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow p-6 max-w-3xl mx-auto">
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-500">Code</h3>
                <p class="text-gray-900">{{ $employeeStatus->code }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500">Label</h3>
                <p class="text-gray-900">{{ $employeeStatus->label }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500">Description</h3>
                <p class="text-gray-900 whitespace-pre-line">{{ $employeeStatus->description ?? 'Aucune description.' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
