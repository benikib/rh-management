<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le poste</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('postes.update', $poste) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="titre" value="Titre" />
                <x-text-input id="titre" name="titre" type="text" class="mt-1 block w-full" :value="old('titre', $poste->titre)" required />
                <x-input-error :messages="$errors->get('titre')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $poste->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="salaire_reference" value="Salaire de référence" />
                <x-text-input id="salaire_reference" name="salaire_reference" type="number" step="0.01" min="0"
                              class="mt-1 block w-full" :value="old('salaire_reference', $poste->salaire_reference)" required />
                <x-input-error :messages="$errors->get('salaire_reference')" class="mt-2" />
            </div>
            @include('partials.form-actions', ['cancelRoute' => route('postes.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
