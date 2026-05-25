<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le département</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <form action="{{ route('departements.update', $departement) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="nom" value="Nom" />
                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $departement->nom)" required />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="direction_id" value="Direction" />
                <select id="direction_id" name="direction_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Sélectionner une direction</option>
                    @foreach($directions as $direction)
                        <option value="{{ $direction->id }}" {{ old('direction_id', $departement->direction_id) == $direction->id ? 'selected' : '' }}>{{ $direction->nom }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('direction_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $departement->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            @include('partials.form-actions', ['cancelRoute' => route('departements.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
