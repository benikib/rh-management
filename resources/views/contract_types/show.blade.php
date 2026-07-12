<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Détails du type de contrat</h2>
            <a href="{{ route('contract-types.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Code</h3>
                <p class="mt-2 text-lg text-gray-900">{{ $contractType->code }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Libellé</h3>
                <p class="mt-2 text-lg text-gray-900">{{ $contractType->label }}</p>
            </div>
            <div class="md:col-span-2">
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Description</h3>
                <p class="mt-2 text-gray-700">{{ $contractType->description ?: 'Aucune description' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Date de fin</h3>
                <p class="mt-2 text-gray-900">{{ $contractType->requires_end_date ? 'Oui' : 'Non' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Créé le</h3>
                <p class="mt-2 text-gray-900">{{ $contractType->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('contract-types.edit', $contractType) }}"
               class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-semibold hover:bg-amber-500">
                <i class="fa-solid fa-pen mr-2"></i> Modifier
            </a>
            <form action="{{ route('contract-types.destroy', $contractType) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-500">
                    <i class="fa-solid fa-trash mr-2"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
