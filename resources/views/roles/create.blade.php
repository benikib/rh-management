<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nouveau rôle</h2>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl    mx-auto">
        <form action="{{ route('roles.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="nom" value="Nom" />
                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom')" required />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>
            @include('partials.form-actions', ['cancelRoute' => route('roles.index')])
        </form>
    </div>
</x-app-layout>
