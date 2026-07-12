<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier une compétence</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('competences.update', $competence) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <x-input-label for="nom" value="Nom de la compétence" />
                        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full"
                                      :value="old('nom', $competence->nom)" required />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="categorie" value="Catégorie" />
                        <x-text-input id="categorie" name="categorie" type="text" class="mt-1 block w-full"
                                      :value="old('categorie', $competence->categorie)" />
                        <x-input-error :messages="$errors->get('categorie')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $competence->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="statut" value="Statut" />
                        <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="Active" @selected(old('statut', $competence->statut) === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('statut', $competence->statut) === 'Inactive')>Inactive</option>
                        </select>
                        <x-input-error :messages="$errors->get('statut')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex gap-3 justify-end">
                    <a href="{{ route('competences.index') }}"
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
