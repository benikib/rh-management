<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Nouveau type de contrat</h2>
            <a href="{{ route('contract-types.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-gray-100">
                <i class="fa-solid fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('contract-types.store') }}" method="POST">
            @csrf

            @include('contract_types._form')

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-500">
                    <i class="fa-solid fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
