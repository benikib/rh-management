<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Modifier le type de contrat</h2>
            <a href="{{ route('contract-types.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('contract-types.update', $contractType) }}" method="POST">
            @csrf
            @method('PUT')

            @include('contract_types._form', ['contractType' => $contractType])

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg text-sm font-semibold hover:bg-amber-500">
                    <i class="fa-solid fa-save mr-2"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
