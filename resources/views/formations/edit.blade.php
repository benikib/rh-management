<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier une formation</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('formations.update', $formation) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('formations._form')

                <div class="mt-6 flex gap-3 justify-end">
                    <a href="{{ route('formations.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fa-solid fa-save mr-2"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
