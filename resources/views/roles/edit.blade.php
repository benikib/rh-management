<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Modifier le rôle</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <form action="{{ route('roles.update', $role) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="nom" value="Nom" />
                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $role->nom)" required />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>
            @include('partials.form-actions', ['cancelRoute' => route('roles.index'), 'submitLabel' => 'Mettre à jour'])
        </form>
    </div>
</x-app-layout>
