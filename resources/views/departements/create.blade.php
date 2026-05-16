<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouveau département</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <form action="{{ route('departements.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="nom" value="Nom" />
                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom')" required />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            @include('partials.form-actions', ['cancelRoute' => route('departements.index'), 'submitLabel' => 'Enregistrer'])
        </form>
    </div>
</x-app-layout>
